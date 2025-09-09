<?php

namespace App\Http\Controllers;

use App\Helpers\Format_Helper;
use App\Helpers\Function_Helper;
use App\Models\Transaksi\TrsBomDModel;
use App\Models\Transaksi\TrsBomHModel;
use App\Models\User;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class TrbomjController extends Controller
{
    /**
     * Get material components for a given material FG/SFG
     */
    public function getMaterialComponents(Request $request)
    {
        $material = $request->get('material');
        $header = TrsBomHModel::where('material_fg_sfg', $material)->first();
        $result = [
            'product_qty' => '',
            'base_uom_header' => '',
            'components' => []
        ];
        if ($header) {
            // Ambil satu detail yang memiliki product_qty dan base_uom_header (jika ada)
            $detail = TrsBomDModel::where('fk_trs_bom_h_id', $header->trs_bom_h_id)
                ->whereNotNull('product_qty')
                ->whereNotNull('base_uom_header')
                ->first();
            $result['product_qty'] = $detail ? $detail->product_qty : '';
            $result['base_uom_header'] = $detail ? $detail->base_uom_header : '';
            // Ambil semua komponen
            $details = TrsBomDModel::where('fk_trs_bom_h_id', $header->trs_bom_h_id)->get();
            foreach ($details as $d) {
                $result['components'][] = [
                    'comp_material_code' => $d->comp_material_code,
                    'comp_desc' => $d->comp_desc,
                    'comp_qty' => $d->comp_qty,
                    'uom' => $d->uom,
                    'type' => $d->type
                ];
            }
        }
        return response()->json($result);
    }

    /**
     * Get all component materials for modal selection
     */
    public function getComponentMaterials(Request $request)
    {
        $comps = DB::table('mst_material')
            ->select('kode_baru_fg as material_code', 'product_name as description', 'alt_uom as uom')
            ->orderBy('kode_baru_fg', 'asc')
            ->get();
        return response()->json($comps);
    }

    /**
     * Create new component material from manual input
     */
    public function createComponentMaterial(Request $request)
    {
        $code = $request->get('material_code');
        $desc = $request->get('description');
        $uom = $request->get('uom');
        // Insert to mst_material jika belum ada
        $exists = DB::table('mst_material')->where('kode_baru_fg', $code)->exists();
        if (!$exists) {
            DB::table('mst_material')->insert([
                'kode_baru_fg' => $code,
                'product_name' => $desc,
                'alt_uom' => $uom,
                'created_at' => now(),
                'updated_at' => now(),
                'status' => '1',
                'isactive' => '1'
            ]);
        }
        return response()->json(['success' => true]);
    }

    /**
     * Search component material by code (for manual input)
     */
    public function searchMaterialByCode(Request $request)
    {
        $code = $request->get('code');
        $comp = DB::table('mst_material')
            ->where('kode_baru_fg', $code)
            ->select('product_name as description', 'alt_uom as uom')
            ->first();
        return response()->json($comp);
    }
    /**
     * Get all active resources for modal selection (AJAX)
     */
    public function getAllResources()
    {
        $resources = DB::table('trs_bom_h')
            ->where('isactive', '1')
            ->select('resource', 'mat_type', 'width', 'length', 'capacity')
            ->orderBy('resource', 'asc')
            ->get();

        return response()->json($resources);
    }
    public function searchComp(Request $request)
    {
        $query = $request->get('q');
        $comps = DB::table('mst_material')
            ->where('kode_baru_fg', 'LIKE', "%$query%")
            ->orWhere('product_name', 'LIKE', "%$query%")
            ->select('kode_baru_fg as material_code', 'product_name as description', 'alt_uom as uom')
            ->limit(10)
            ->get();
        return response()->json($comps);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */

    public function index($data)
    {
        // function helper
        $data['format'] = new Format_Helper;

        // Ambil data header BOM yang aktif
        $data['table_detail_h'] = DB::table('trs_bom_h')
            ->where('isactive', '1')
            ->orderBy('trs_bom_h_id', 'desc')
            ->get();

        // List data table untuk detail (kosong dulu, akan diisi via ajax)
        $data['table_detail_d'] = collect();

        if ($data) {
            // return page menu
            return view($data['url'], $data);
        } else {
            //if not exist
            $data['url_menu'] = 'error';
            $data['title_group'] = 'Error';
            $data['title_menu'] = 'Error';
            $data['errorpages'] = 'Not Found!';
            //return error page
            return view("pages.errorpages", $data);
        }
    }

    /**
     * Display the specified resource with ajax.
     */
    public function ajax($data)
    {
        //check decrypt
        try {
            $id = decrypt($_GET['id']);
        } catch (DecryptException $e) {
            $id = "";
        }

        // ajax id
        $data['ajaxid'] = $id;

        // Pastikan header masih aktif
        $headerExists = DB::table('trs_bom_h')
            ->where('trs_bom_h_id', $id)
            ->where('isactive', '1')
            ->exists();

        if (!$headerExists) {
            return response()->json(['error' => 'Header data not found or inactive'], 404);
        }

        // Ambil data detail berdasarkan header id - HANYA yang aktif (enum '1')
        $data['table_detail_d_ajax'] = DB::table('trs_bom_d')
            ->where('fk_trs_bom_h_id', $id)
            ->where('isactive', '1')
            ->whereNotNull('comp_material_code')
            ->where('comp_material_code', '!=', '')
            ->orderBy('item_number', 'asc')
            ->orderBy('trs_bom_d_id', 'asc')
            ->get();

        // Set encrypt primary key untuk detail
        $data['encrypt_primary'] = array();
        foreach ($data['table_detail_d_ajax'] as $detail) {
            array_push($data['encrypt_primary'], encrypt($detail->trs_bom_d_id));
        }

        return json_encode($data);
    }

    /**
     * Display the specified resource.
     */
    public function add($data)
    {
        // function helper
        $syslog = new Function_Helper;

        //check decrypt
        try {
            $id = decrypt($data['idencrypt']);
        } catch (DecryptException $e) {
            $id = "";
        }

        if ($data['authorize']->add == '1') {
            // return page menu
            return view($data['url'], $data);
        } else {
            //if not athorize
            $data['url_menu'] = $data['url_menu'];
            $data['title_group'] = 'Error';
            $data['title_menu'] = 'Error';
            $data['errorpages'] = 'Not Authorized!';
            //insert log
            $syslog->log_insert('E', $data['url_menu'], 'Not Authorized!' . ' - Add -' . $data['url_menu'], '0');
            //return error page
            return view("pages.errorpages", $data);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($data)
    {
        // Implementation for store method

        // function helper
        $data['format'] = new Format_Helper;
        $syslog = new Function_Helper;

        // For now, redirect back with success message
        Session::flash('message', 'Tambah Data Berhasil!');
        Session::flash('class', 'success');

        return redirect($data['url_menu'])->with($data);
    }

    /**
     * Display the specified resource.
     */
    public function show($data)
    {
        // Dekripsi id detail BOM
        try {
            $id = decrypt($data['idencrypt']);
        } catch (DecryptException $e) {
            $id = "";
        }

        // Ambil data detail yang aktif (baris yang dipilih)
        $selectedRow = DB::table('trs_bom_d')
            ->where('trs_bom_d_id', $id)
            ->where('isactive', '1')
            ->first();

        if ($selectedRow) {
            // Ambil data header BOM
            $bom = DB::table('trs_bom_h')
                ->where('trs_bom_h_id', $selectedRow->fk_trs_bom_h_id)
                ->where('isactive', '1')
                ->first();

            // Ambil semua baris detail BOM
            $allRows = DB::table('trs_bom_d')
                ->where('fk_trs_bom_h_id', $selectedRow->fk_trs_bom_h_id)
                ->where('isactive', '1')
                ->orderBy('item_number', 'asc')
                ->orderBy('trs_bom_d_id', 'asc')
                ->get();

            $data['bom'] = $bom;
            $data['selectedRow'] = $selectedRow;
            $data['allRows'] = $allRows;
            $data['list'] = $selectedRow; // untuk kebutuhan lama

            return view($data['url'], $data);
        } else {
            $data['url_menu'] = 'error';
            $data['title_group'] = 'Error';
            $data['title_menu'] = 'Error';
            $data['errorpages'] = 'Data Not Found or Inactive!';
            return view("pages.errorpages", $data);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($data)
    {
        // function helper
        $syslog = new Function_Helper;

        //check decrypt
        try {
            $id = decrypt($data['idencrypt']);
        } catch (DecryptException $e) {
            $id = "";
        }

        // Ambil data header yang aktif
        $list = DB::table('trs_bom_h')
            ->where('trs_bom_h_id', $id)
            ->where('isactive', '1')  // String '1' untuk enum
            ->first();

        // check data list
        if ($list) {
            //check athorization access edit
            if ($data['authorize']->edit == '1') {
                $data['list'] = $list;
                // return page menu
                return view($data['url'], $data);
            } else {
                //if not athorize
                $data['url_menu'] = $data['url_menu'];
                $data['title_group'] = 'Error';
                $data['title_menu'] = 'Error';
                $data['errorpages'] = 'Not Authorized!';
                //insert log
                $syslog->log_insert('E', $data['url_menu'], 'Not Authorized!' . ' - Edit -' . $data['url_menu'], '0');
                //return error page
                return view("pages.errorpages", $data);
            }
        } else {
            //if not exist
            $data['url_menu'] = 'error';
            $data['title_group'] = 'Error';
            $data['title_menu'] = 'Error';
            $data['errorpages'] = 'Data Not Found or Inactive!';
            //return error page
            return view("pages.errorpages", $data);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($data)
    {
        // Implementation for update method

        // function helper
        $syslog = new Function_Helper;

        // For now, redirect back with success message
        Session::flash('message', 'Edit Data Berhasil!');
        Session::flash('class', 'success');

        return redirect($data['url_menu'])->with($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($data)
    {
        // Implementation for destroy method (soft delete)

        // function helper
        $syslog = new Function_Helper;

        //check decrypt
        try {
            $id = decrypt($data['idencrypt']);
        } catch (DecryptException $e) {
            $id = "";
        }

        // Soft delete dengan mengubah isactive menjadi '0'
        $updated = DB::table('trs_bom_h')
            ->where('trs_bom_h_id', $id)
            ->where('isactive', '1')
            ->update([
                'isactive' => '0',
                'updated_at' => now(),
                'user_update' => auth()->user()->firstname ?? 'system'
            ]);

        if ($updated) {
            // Juga soft delete semua detail terkait
            DB::table('trs_bom_d')
                ->where('fk_trs_bom_h_id', $id)
                ->where('isactive', '1')
                ->update([
                    'isactive' => '0',
                    'updated_at' => now(),
                    'user_update' => auth()->user()->firstname ?? 'system'
                ]);

            Session::flash('message', 'Hapus Data Berhasil!');
            Session::flash('class', 'success');
        } else {
            Session::flash('message', 'Data tidak ditemukan atau sudah dihapus!');
            Session::flash('class', 'error');
        }

        return redirect($data['url_menu'])->with($data);
    }

    public function searchResource(Request $request)
    {
        $query = $request->get('q');

        $resources = TrsBomHModel::where('resource', 'LIKE', "%$query%")
            ->select('trs_bom_h_id', 'resource', 'mat_type', 'width', 'length', 'capacity')
            ->limit(10)
            ->get();

        return response()->json($resources);
    }

    public function searchMaterial(Request $request)
    {
        $query = $request->get('q');

        $materials = TrsBomHModel::where('material_fg_sfg', 'LIKE', "%$query%")
            ->select('trs_bom_h_id', 'material_fg_sfg', 'base_uom_header', 'product')
            ->limit(10)
            ->get();

        return response()->json($materials);
    }

    public function getDetail($material)
    {
        // cari header BOM sesuai material_fg_sfg
        $header = TrsBomHModel::where('material_fg_sfg', $material)->first();

        if(!$header){
            return response()->json(['detail' => []]);
        }

        $detail = TrsBomDModel::where('fk_trs_bom_h_id', $header->trs_bom_h_id)
            ->get();

        return response()->json([
            'header' => $header,
            'detail' => $detail
        ]);
    }

}
