<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class tabel_rpt_orders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //tabel_menu
        DB::table('sys_table')->where(['gmenu' => 'report', 'dmenu' => 'rpordr'])->delete();

        DB::table('sys_table')->insert([
            'gmenu' => 'report',
            'dmenu' => 'rpordr',
            'urut' => '1',
            'field' => 'query',
            'type' => 'report',
            'query' => "SELECT o.trordr_id AS 'ID Order', c.cust_name AS 'Nama Customer', o.ordr_order_date AS 'Tanggal Order', p.pdrk_name AS 'Nama Produk', oi.ordr_it_quantity AS 'Quantity', CONCAT('Rp ', FORMAT(oi.ordr_it_price, 0)) AS 'Harga Satuan', CONCAT('Rp ', FORMAT(oi.ordr_it_subtotal, 0)) AS 'Subtotal', CONCAT('Rp ', FORMAT(o.ordr_total_amount, 0)) AS 'Total Order' FROM trs_orders o LEFT JOIN mst_customer c ON c.cust_id = o.fk_cust_id LEFT JOIN trs_orders_item oi ON oi.fk_trordr_id = o.trordr_id LEFT JOIN mst_produk p ON p.pdrk_id = oi.fk_pdrk_id WHERE o.isactive = '1' AND c.isactive = '1' AND oi.isactive = '1' AND p.isactive = '1' AND o.fk_cust_id LIKE :cust_id AND o.ordr_order_date BETWEEN :frordr_order_date AND :toordr_order_date ORDER BY o.trordr_id ASC, p.pdrk_name ASC"
        ]);

        DB::table('sys_table')->insert([
            'gmenu' => 'report',
            'dmenu' => 'rpordr',
            'urut' => '2',
            'field' => 'cust_id',
            'alias' => 'Pelanggan',
            'type' => 'search',
            'length' => '13',
            'validate' => 'max:13',
            'filter' => '1',
            'query' => "SELECT cust_id, cust_name, cust_phone FROM mst_customer WHERE isactive = '1'",
            'class' => ''
        ]);

        DB::table('sys_table')->insert([
            'gmenu' => 'report',
            'dmenu' => 'rpordr',
            'urut' => '3',
            'field' => 'ordr_order_date',
            'alias' => 'Rentang Tanggal Pesanan',
            'type' => 'date2',
            'length' => '10',
            'validate' => 'max:10',
            'filter' => '1',
            'query' => "",
            'class' => ''
        ]);
    }
}