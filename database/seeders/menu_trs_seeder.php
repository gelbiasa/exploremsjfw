<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class menu_trs_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //insert tabel sys_dmenu
        DB::table('sys_dmenu')->insert([
            'gmenu' => 'transc',
            'dmenu' => 'trbomj',
            'urut' => 0,
            'name' => 'Transaction BOM Jumbo',
            'url' => 'trbomj',
            'icon' => 'fas fa-cubes',
            'tabel' => '-',
            'notif' => '',
            'layout' => 'manual',
            'show' => '1',
            'js' => '1'
        ]);
        DB::table('sys_dmenu')->insert([
            'gmenu' => 'transc',
            'dmenu' => 'trboms',
            'urut' => 1,
            'name' => 'Transaction BOM Slitter',
            'url' => 'trboms',
            'icon' => 'fas fa-cut',
            'tabel' => '-',
            'notif' => '',
            'layout' => 'manual',
            'show' => '1',
            'js' => '1'
        ]);
        DB::table('sys_dmenu')->insert([
            'gmenu' => 'transc',
            'dmenu' => 'trbomm',
            'urut' => 2,
            'name' => 'Transaction BOM Meltblown',
            'url' => 'trbomm',
            'icon' => 'fas fa-filter',
            'tabel' => '-',
            'notif' => '',
            'layout' => 'manual',
            'show' => '1',
            'js' => '1'
        ]);
        DB::table('sys_dmenu')->insert([
            'gmenu' => 'transc',
            'dmenu' => 'trdbom',
            'urut' => 3,
            'name' => 'Transaction Download BOM',
            'url' => 'trdbom',
            'icon' => 'fas fa-file-download',
            'tabel' => '-',
            'notif' => '',
            'layout' => 'manual',
            'show' => '1',
            'js' => '1'
        ]);

        // Contoh
        DB::table('sys_dmenu')->insert([
            'gmenu' => 'transc',
            'dmenu' => 'trordr',
            'urut' => 4,
            'name' => 'Transaction Order',
            'url' => 'trordr',
            'icon' => 'fas fa-file-download',
            'tabel' => '-',
            'notif' => '',
            'layout' => 'manual',
            'show' => '1',
            'js' => '1'
        ]);
        DB::table('sys_dmenu')->insert([
            'gmenu' => 'master',
            'dmenu' => 'mscust',
            'urut' => 2,
            'name' => 'Master Customer',
            'url' => 'mscust',
            'icon' => 'fas fa-file-download',
            'tabel' => 'mst_customer',
            'notif' => '',
            'layout' => 'master',
            'show' => '1',
            'js' => '1'
        ]);
        DB::table('sys_dmenu')->insert([
            'gmenu' => 'master',
            'dmenu' => 'mspdrk',
            'urut' => 3,
            'name' => 'Master Produk',
            'url' => 'mspdrk',
            'icon' => 'fas fa-file-download',
            'tabel' => 'mst_produk',
            'notif' => '',
            'layout' => 'master',
            'show' => '1',
            'js' => '1'
        ]);

        // END COntoh


        //insert auth
        DB::table('sys_auth')->insert([
            'idroles' => 'ppic01',
            'dmenu' => 'trbomj',
            'gmenu' => 'transc',
            'add' => '1',
            'edit' => '0',
            'delete' => '0',
            'approval' => '0',
            'value' => '1',
            'print' => '1',
            'excel' => '1',
            'pdf' => '1',
            'rules' => '0',
            'isactive' => '1'
        ]);
        DB::table('sys_auth')->insert([
            'idroles' => 'ppic01',
            'dmenu' => 'trboms',
            'gmenu' => 'transc',
            'add' => '1',
            'edit' => '0',
            'delete' => '0',
            'approval' => '0',
            'value' => '1',
            'print' => '1',
            'excel' => '1',
            'pdf' => '1',
            'rules' => '0',
            'isactive' => '1'
        ]);

        // Contoh
        DB::table('sys_auth')->insert([
            'idroles' => 'ppic01',
            'dmenu' => 'mscust',
            'gmenu' => 'master',
            'add' => '1',
            'edit' => '1',
            'delete' => '1',
            'approval' => '1',
            'value' => '1',
            'print' => '1',
            'excel' => '1',
            'pdf' => '1',
            'rules' => '0',
            'isactive' => '1'
        ]);
        DB::table('sys_auth')->insert([
            'idroles' => 'ppic01',
            'dmenu' => 'mspdrk',
            'gmenu' => 'master',
            'add' => '1',
            'edit' => '1',
            'delete' => '1',
            'approval' => '1',
            'value' => '1',
            'print' => '1',
            'excel' => '1',
            'pdf' => '1',
            'rules' => '0',
            'isactive' => '1'
        ]);
        DB::table('sys_auth')->insert([
            'idroles' => 'ppic01',
            'dmenu' => 'trordr',
            'gmenu' => 'transc',
            'add' => '1',
            'edit' => '1',
            'delete' => '1',
            'approval' => '1',
            'value' => '1',
            'print' => '1',
            'excel' => '1',
            'pdf' => '1',
            'rules' => '0',
            'isactive' => '1'
        ]);

        // END Contoh

        DB::table('sys_auth')->insert([
            'idroles' => 'ppic02',
            'dmenu' => 'trbomm',
            'gmenu' => 'transc',
            'add' => '1',
            'edit' => '0',
            'delete' => '0',
            'approval' => '0',
            'value' => '1',
            'print' => '1',
            'excel' => '1',
            'pdf' => '1',
            'rules' => '0',
            'isactive' => '1'
        ]);
            DB::table('sys_auth')->insert([
            'idroles' => 'itdept',
            'dmenu' => 'trdbom',
            'gmenu' => 'transc',
            'add' => '1',
            'edit' => '0',
            'delete' => '0',
            'approval' => '0',
            'value' => '1',
            'print' => '0',
            'excel' => '1',
            'pdf' => '0',
            'rules' => '0',
            'isactive' => '1'
        ]);
    }
}
