<?php

namespace App\Http\Controllers;

use App\Helpers\Format_Helper;
use App\Helpers\Function_Helper;
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
        //check decrypt
        try {
            $id = decrypt($data['idencrypt']);
        } catch (DecryptException $e) {
            $id = "";
        }

        // Ambil data detail yang aktif
        $list = DB::table('trs_bom_d')
            ->where('trs_bom_d_id', $id)
            ->where('isactive', '1')  // String '1' untuk enum
            ->first();

        // check data list
        if ($list) {
            $data['list'] = $list;
            // return page menu
            return view($data['url'], $data);
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
}
