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
            'tabel' => 'trs_bom_h',
            'notif' => '',
            'layout' => 'manual',
            'show' => '1',
            'js' => '1'
        ]);
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
            'print' => '0',
            'excel' => '0',
            'pdf' => '0',
            'rules' => '0',
            'isactive' => '1'
        ]);
    }
}
