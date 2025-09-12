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
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index($data)
    {
        // function helper
        $data['format'] = new Format_Helper;

        // Ambil data header BOM yang aktif dan material_fg_sfg tidak diawali '7'
        $data['table_detail_h'] = DB::table('trs_bom_h')
            ->where('isactive', '1')
            ->whereRaw("LEFT(material_fg_sfg, 1) != '7'")
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

        // Handle AJAX requests untuk data resources, materials, components
        if (request()->ajax() || request()->wantsJson()) {
            return $this->handleAjaxRequests();
        }

        if ($data['authorize']->add == '1') {
            // Ambil data resources untuk modal - sama seperti konsep trordr
            $data['resources'] = DB::table('trs_bom_h')
                ->where('isactive', '1')
                ->select('resource', 'mat_type', 'width', 'length', 'capacity')
                ->distinct()
                ->orderBy('resource', 'asc')
                ->get();

            // Ambil data component materials untuk modal - sama seperti konsep trordr
            $data['components'] = DB::table('mst_material')
                ->where('isactive', '1')
                ->select('kode_baru_fg as material_code', 'product_name as description', 'alt_uom as uom')
                ->orderBy('kode_baru_fg', 'asc')
                ->get();

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
        // function helper
        $syslog = new Function_Helper;

        try {
            DB::beginTransaction();

            // Validasi input dasar
            request()->validate([
                'bom_data' => 'required|array|min:1',
                'bom_data.*.resources' => 'required|string',
                'bom_data.*.material' => 'required|string',
                'bom_data.*.capacity' => 'required|numeric|min:1',
                'bom_data.*.alt_bom_text' => 'required|string',
                'bom_data.*.detail' => 'required|array|min:1',
            ], [
                'required' => ':attribute tidak boleh kosong',
                'min' => ':attribute minimal :min',
                'numeric' => ':attribute harus berupa angka',
                'array' => ':attribute harus berupa array'
            ]);

            $bomDataArray = request('bom_data');

            foreach ($bomDataArray as $index => $bomData) {
                // Insert ke tabel trs_bom_h
                $bomHeaderId = DB::table('trs_bom_h')->insertGetId([
                    'resource' => $bomData['resources'],
                    'mat_type' => $bomData['mat_type'] ?? '',
                    'material_fg_sfg' => $bomData['material'],
                    'capacity' => $bomData['capacity'],
                    'width' => $bomData['width'] ?? 0,
                    'length' => $bomData['length'] ?? 0,
                    'alt_bom_text' => $bomData['alt_bom_text'],
                    'user_create' => session('username', 'system'),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'isactive' => '1'
                ]);

                // Insert detail ke trs_bom_d
                if (isset($bomData['detail']) && is_array($bomData['detail'])) {
                    foreach ($bomData['detail'] as $detailData) {
                        // Skip jika comp_material_code kosong
                        if (empty($detailData['comp_material_code'])) {
                            continue;
                        }

                        DB::table('trs_bom_d')->insert([
                            'fk_trs_bom_h_id' => $bomHeaderId,
                            'material_fg_sfg' => $detailData['material_fg_sfg'] ?? $bomData['material'],
                            'alt_bom_text' => $detailData['alt_bom_text'] ?? $bomData['alt_bom_text'],
                            'product_qty' => $detailData['product_qty'] ?? 1,
                            'base_uom_header' => $detailData['base_uom_header'] ?? '',
                            'item_number' => $detailData['item_number'] ?? '0010',
                            'type' => $detailData['type'] ?? 'L',
                            'comp_material_code' => $detailData['comp_material_code'],
                            'comp_desc' => $detailData['comp_desc'] ?? '',
                            'comp_qty' => $detailData['comp_qty'] ?? 1,
                            'uom' => $detailData['uom'] ?? '',
                            'user_create' => session('username', 'system'),
                            'created_at' => now(),
                            'updated_at' => now(),
                            'isactive' => '1'
                        ]);
                    }
                }
            }

            DB::commit();

            // Log success
            $syslog->log_insert('C', $data['dmenu'], 'Created BOM: ' . count($bomDataArray) . ' records', '1');

            // Set success message
            Session::flash('message', 'BOM berhasil dibuat! Total: ' . count($bomDataArray) . ' record');
            Session::flash('class', 'success');

            return redirect($data['url_menu']);
        } catch (\Exception $e) {
            DB::rollback();

            // Log error
            $syslog->log_insert('E', $data['dmenu'], 'Create BOM Error: ' . $e->getMessage(), '0');

            // Set error message
            Session::flash('message', 'Error: ' . $e->getMessage());
            Session::flash('class', 'danger');

            return redirect()->back()->withInput();
        }
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

    /**
     * Handle all AJAX requests for add form
     */
    private function handleAjaxRequests()
    {
        $action = request()->get('action');

        switch ($action) {
            case 'search_material':
                return $this->searchMaterial();
            case 'get_material_components':
                return $this->getMaterialComponents();
            case 'create_material':
                return $this->createComponentMaterial();
            case 'search_material_by_code':
                return $this->searchMaterialByCode();
            case 'search_comp':
                return $this->searchComp();
            case 'get_recommendations':
                return app(RumusAndTemplateController::class)->getRecommendations(request());
            default:
                return response()->json(['error' => 'Invalid action'], 400);
        }
    }

    /**
     * Search material by query
     */
    private function searchMaterial()
    {
        $query = request()->get('q');
        $materials = TrsBomHModel::where('material_fg_sfg', 'LIKE', "%$query%")
            ->whereRaw("LEFT(material_fg_sfg, 1) != '7'")
            ->select('trs_bom_h_id', 'material_fg_sfg', 'base_uom_header', 'product')
            ->limit(10)
            ->get();

        return response()->json($materials);
    }

    /**
     * Get material components for a given material FG/SFG
     */
    private function getMaterialComponents()
    {
        $material = request()->get('material');
        $header = TrsBomHModel::where('material_fg_sfg', $material)
            ->whereRaw("LEFT(material_fg_sfg, 1) != '7'")
            ->first();
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
     * Create new component material from manual input
     */
    private function createComponentMaterial()
    {
        $code = request()->get('material_code');
        $desc = request()->get('description');
        $type = request()->get('type');
        $uom = request()->get('uom');

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
    private function searchMaterialByCode()
    {
        $code = request()->get('code');
        $comp = DB::table('mst_material')
            ->where('kode_baru_fg', $code)
            ->select('product_name as description', 'alt_uom as uom')
            ->first();

        return response()->json($comp);
    }

    /**
     * Search component materials by query
     */
    private function searchComp()
    {
        $query = request()->get('q');
        $comps = DB::table('mst_material')
            ->where('kode_baru_fg', 'LIKE', "%$query%")
            ->orWhere('product_name', 'LIKE', "%$query%")
            ->select('kode_baru_fg as material_code', 'product_name as description', 'alt_uom as uom')
            ->limit(10)
            ->get();

        return response()->json($comps);
    }
}