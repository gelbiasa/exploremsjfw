<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class tabel_mst_customer extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sys_table')->where(['gmenu' => 'master', 'dmenu' => 'mscust'])->delete();
        
        DB::table('sys_table')->insert([
            'gmenu' => 'master',
            'dmenu' => 'mscust',
            'urut' => '2',
            'field' => 'cust_name',
            'alias' => 'Nama Customer',
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
            'note' => 'Nama customer dengan format huruf besar',
            'position' => '0',
            'isactive' => '1',
            'created_at' => '2025-07-23 15:59:17',
            'updated_at' => '2025-07-23 15:59:17',
            'user_create' => '',
            'user_update' => '',
        ]);

        DB::table('sys_table')->insert([
            'gmenu' => 'master',
            'dmenu' => 'mscust',
            'urut' => '3',
            'field' => 'cust_email',
            'alias' => 'Email',
            'type' => 'email',
            'length' => '255',
            'decimals' => '0',
            'default' => '',
            'validate' => 'required|email|max:255|unique:mst_customer,cust_email',
            'primary' => '0',
            'generateid' => '',
            'filter' => '1',
            'list' => '1',
            'show' => '1',
            'query' => '',
            'class' => '',
            'sub' => '',
            'link' => '',
            'note' => 'Email customer (harus unik)',
            'position' => '0',
            'isactive' => '1',
            'created_at' => '2025-07-23 15:59:17',
            'updated_at' => '2025-07-23 15:59:17',
            'user_create' => '',
            'user_update' => '',
        ]);

        DB::table('sys_table')->insert([
            'gmenu' => 'master',
            'dmenu' => 'mscust',
            'urut' => '4',
            'field' => 'cust_phone',
            'alias' => 'No. Telepon',
            'type' => 'string',
            'length' => '20',
            'decimals' => '0',
            'default' => '',
            'validate' => 'required|max:20|min:8',
            'primary' => '0',
            'generateid' => '',
            'filter' => '1',
            'list' => '1',
            'show' => '1',
            'query' => '',
            'class' => 'number',
            'sub' => '',
            'link' => '',
            'note' => 'Nomor telepon customer',
            'position' => '0',
            'isactive' => '1',
            'created_at' => '2025-07-23 15:59:17',
            'updated_at' => '2025-07-23 15:59:17',
            'user_create' => '',
            'user_update' => '',
        ]);

        DB::table('sys_table')->insert([
            'gmenu' => 'master',
            'dmenu' => 'mscust',
            'urut' => '5',
            'field' => 'cust_address',
            'alias' => 'Alamat',
            'type' => 'text',
            'length' => '500',
            'decimals' => '0',
            'default' => '',
            'validate' => 'required|max:500|min:10',
            'primary' => '0',
            'generateid' => '',
            'filter' => '1',
            'list' => '1',
            'show' => '1',
            'query' => '',
            'class' => '',
            'sub' => '',
            'link' => '',
            'note' => 'Alamat lengkap customer',
            'position' => '0',
            'isactive' => '1',
            'created_at' => '2025-07-23 15:59:17',
            'updated_at' => '2025-07-23 15:59:17',
            'user_create' => '',
            'user_update' => '',
        ]);

        DB::table('sys_table')->insert([
            'gmenu' => 'master',
            'dmenu' => 'mscust',
            'urut' => '6',
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
            'class' => 'enum',
            'sub' => '',
            'link' => '',
            'note' => '',
            'position' => '0',
            'isactive' => '1',
            'created_at' => '2025-07-23 15:59:17',
            'updated_at' => '2025-07-23 15:59:17',
            'user_create' => '',
            'user_update' => '',
        ]);
    }
}