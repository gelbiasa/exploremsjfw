<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class menu_rpt_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //insert tabel sys_dmenu
        DB::table('sys_dmenu')->insert([
            'gmenu' => 'report',
            'dmenu' => 'rpseed',
            'urut' => 0,
            'name' => 'Generate Seeder',
            'url' => 'rptseeder',
            'icon' => 'ni-collection',
            'tabel' => '-',
            'notif' => '',
            'layout' => 'manual'
        ]);
        DB::table('sys_dmenu')->insert([
            'gmenu' => 'report',
            'dmenu' => 'rptbom',
            'urut' => 1,
            'name' => 'Report BOM',
            'url' => 'rptbom',
            'icon' => 'ni-collection',
            'tabel' => '-',
            'notif' => '',
            'layout' => 'manual',
            'show' => '1',
            'js' => '1'
        ]);
        //insert auth
        DB::table('sys_auth')->insert([
            'idroles' => 'admins',
            'dmenu' => 'rpseed',
            'gmenu' => 'report',
            'add' => '1',
            'edit' => '0',
            'delete' => '0',
            'approval' => '0',
            'value' => '0',
            'print' => '0',
            'excel' => '0',
            'pdf' => '0',
            'rules' => '0',
            'isactive' => '1'
        ]);
        DB::table('sys_auth')->insert([
            'idroles' => 'itdept',
            'dmenu' => 'rptbom',
            'gmenu' => 'report',
            'add' => '1',
            'edit' => '0',
            'delete' => '0',
            'approval' => '0',
            'value' => '1',
            'print' => '0',
            'excel' => '0',
            'pdf' => '0',
            'rules' => '0',
            'isactive' => '1'
        ]);
    }
}
