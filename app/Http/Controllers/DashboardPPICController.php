<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardPPICController extends Controller
{
    public function index($data)
    {
        // Ambil total seluruh transaksi upload BOM
        $totalTransaksi = \App\Models\Transaksi\TrsBomHModel::count();

        // Hitung jumlah BOM Jumbo berdasarkan material_fg_sfg karakter pertama bukan angka (A-Z/a-z)
        $totalJumbo = \App\Models\Transaksi\TrsBomHModel::whereRaw("LEFT(material_fg_sfg, 1) REGEXP '^[A-Za-z]'")
            ->count();

        // Kirim data ke view
        $data['totalTransaksi'] = $totalTransaksi;
            $data['totalJumbo'] = $totalJumbo;
        return view($data['url'], $data);
    }
}
