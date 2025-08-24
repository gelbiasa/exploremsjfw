<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class tabel_mst_produk extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sys_table')->where(['gmenu' => 'master', 'dmenu' => 'mspdrk'])->delete();
        
        DB::table('sys_table')->insert([
            'gmenu' => 'master',
            'dmenu' => 'mspdrk',
            'urut' => '2',
            'field' => 'pdrk_name',
            'alias' => 'Nama Produk',
            'type' => 'string',
            'length' => '255',
            'decimals' => '0',
            'default' => '',
            'validate' => 'required|max:255|min:2',
            'primary' => '0',
            'generateid' => '',
            'filter' => '1',
            'list' => '1',
            'show' => '1',
            'query' => '',
            'class' => 'upper',
            'sub' => '',
            'link' => '',
            'note' => 'Nama produk dengan format huruf besar',
            'position' => '0',
            'isactive' => '1',
            'created_at' => '2025-07-23 14:43:33',
            'updated_at' => '2025-07-23 14:43:33',
            'user_create' => '',
            'user_update' => '',
        ]);

        DB::table('sys_table')->insert([
            'gmenu' => 'master',
            'dmenu' => 'mspdrk',
            'urut' => '3',
            'field' => 'pdrk_price',
            'alias' => 'Harga',
            'type' => 'currency',
            'length' => '9999999999',
            'decimals' => '2',
            'default' => '',
            'validate' => 'required|numeric|between:1,9999999999',
            'primary' => '0',
            'generateid' => '',
            'filter' => '1',
            'list' => '1',
            'show' => '1',
            'query' => '',
            'class' => '',
            'sub' => 'IDR',
            'link' => '',
            'note' => 'Harga produk dalam format mata uang',
            'position' => '0',
            'isactive' => '1',
            'created_at' => '2025-07-23 14:43:33',
            'updated_at' => '2025-07-23 14:43:33',
            'user_create' => '',
            'user_update' => '',
        ]);

        DB::table('sys_table')->insert([
            'gmenu' => 'master',
            'dmenu' => 'mspdrk',
            'urut' => '4',
            'field' => 'pdrk_stock',
            'alias' => 'Stok',
            'type' => 'number',
            'length' => '20',
            'decimals' => '0',
            'default' => '0',
            'validate' => 'required',
            'primary' => '0',
            'generateid' => '',
            'filter' => '1',
            'list' => '1',
            'show' => '1',
            'query' => '',
            'class' => '',
            'sub' => '',
            'link' => '',
            'note' => 'Jumlah stok produk',
            'position' => '0',
            'isactive' => '1',
            'created_at' => '2025-07-23 14:43:33',
            'updated_at' => '2025-07-23 14:43:33',
            'user_create' => '',
            'user_update' => '',
        ]);

        DB::table('sys_table')->insert([
            'gmenu' => 'master',
            'dmenu' => 'mspdrk',
            'urut' => '5',
            'field' => 'isactive',
            'alias' => 'Status',
            'type' => 'enum',
            'length' => '1',
            'decimals' => '0',
            'default' => '1',
            'validate' => '',
            'primary' => '0',
            'generateid' => '',
            'filter' => '1',
            'list' => '1',
            'show' => '1',
            'query' => "select value, name from sys_enum where idenum = 'isactive' and isactive = '1'",
            'class' => '',
            'sub' => '',
            'link' => '',
            'note' => '',
            'position' => '0',
            'isactive' => '1',
            'created_at' => '2025-07-23 14:43:33',
            'updated_at' => '2025-07-23 14:43:33',
            'user_create' => '',
            'user_update' => '',
        ]);
    }
}