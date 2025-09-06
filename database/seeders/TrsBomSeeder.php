<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TrsBomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $this->command->info('Running TrsBomSeeder...');

        // Optional: Truncate tables to start fresh on each seed
        // This prevents creating duplicate data if you run the seeder multiple times.
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('trs_bom_h')->truncate();
        DB::table('trs_bom_d')->truncate();
        DB::table('mst_material')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Run each seeder logic in sequence
        $this->seedTrsBomH();
        $this->seedTrsBomD();
        $this->seedMstMaterial();

        $this->command->info('TrsBomSeeder finished successfully.');
    }

    /**
     * Seeds the trs_bom_h table.
     */
    private function seedTrsBomH(): void
    {
        $this->command->info('Seeding trs_bom_h table...');
        $now = Carbon::now();

        $data = [
            // Group 1
            ['mat_type' => 'ZFGD', 'resource' => '1B08BD', 'capacity' => 120, 'width' => 0.178, 'length' => 2000, 'product' => 'PP Normal', 'process' => 'Rewind Jumbo', 'material_fg_sfg_kode_lama' => '7PRYFN020-0178L', 'material_fg_sfg' => '7PORA00-Y00U10-00020-000178G'],
            ['mat_type' => 'ZFGD', 'resource' => '1B08BD', 'capacity' => 120, 'width' => 0.178, 'length' => 2000, 'product' => 'PP Normal', 'process' => 'Rewind Jumbo', 'material_fg_sfg_kode_lama' => null, 'material_fg_sfg' => '7PORA00-Y00U10-00020-000178G'],
            
            // Group 2
            ['mat_type' => 'ZSFG', 'resource' => '1B0808', 'capacity' => 234, 'width' => 1.8, 'length' => 2000, 'product' => 'PP Normal', 'process' => 'Spinning', 'material_fg_sfg_kode_lama' => 'PRYFN020', 'material_fg_sfg' => 'P0RA00-Y00U10-00020'],
            ['mat_type' => 'ZSFG', 'resource' => '1B0808', 'capacity' => 234, 'width' => 1.8, 'length' => 2000, 'product' => 'PP Normal', 'process' => 'Spinning', 'material_fg_sfg_kode_lama' => null, 'material_fg_sfg' => 'P0RA00-Y00U10-00020'],
            ['mat_type' => 'ZSFG', 'resource' => '1B0808', 'capacity' => 234, 'width' => 1.8, 'length' => 2000, 'product' => 'PP Normal', 'process' => 'Spinning', 'material_fg_sfg_kode_lama' => null, 'material_fg_sfg' => 'P0RA00-Y00U10-00020'],
            ['mat_type' => 'ZSFG', 'resource' => '1B0808', 'capacity' => 234, 'width' => 1.8, 'length' => 2000, 'product' => 'PP Normal', 'process' => 'Spinning', 'material_fg_sfg_kode_lama' => null, 'material_fg_sfg' => 'P0RA00-Y00U10-00020'],
            ['mat_type' => 'ZSFG', 'resource' => '1B0808', 'capacity' => 234, 'width' => 1.8, 'length' => 2000, 'product' => 'PP Normal', 'process' => 'Spinning', 'material_fg_sfg_kode_lama' => null, 'material_fg_sfg' => 'P0RA00-Y00U10-00020'],
            ['mat_type' => 'ZSFG', 'resource' => '1B0808', 'capacity' => 234, 'width' => 1.8, 'length' => 2000, 'product' => 'PP Normal', 'process' => 'Spinning', 'material_fg_sfg_kode_lama' => null, 'material_fg_sfg' => 'P0RA00-Y00U10-00020'],
            ['mat_type' => 'ZSFG', 'resource' => '1B0808', 'capacity' => 234, 'width' => 1.8, 'length' => 2000, 'product' => 'PP Normal', 'process' => 'Spinning', 'material_fg_sfg_kode_lama' => null, 'material_fg_sfg' => 'P0RA00-Y00U10-00020'],
            ['mat_type' => 'ZSFG', 'resource' => '1B0808', 'capacity' => 234, 'width' => 1.8, 'length' => 2000, 'product' => 'PP Normal', 'process' => 'Spinning', 'material_fg_sfg_kode_lama' => null, 'material_fg_sfg' => 'P0RA00-Y00U10-00020'],

            // Group 3
            ['mat_type' => 'ZFGD', 'resource' => '1B00B3', 'capacity' => 96, 'width' => 1.600, 'length' => 100, 'product' => 'PP Normal', 'process' => 'Rewind Jumbo', 'material_fg_sfg_kode_lama' => null, 'material_fg_sfg' => '7PORA00-Y00U10-00048-0001600A'],
            ['mat_type' => 'ZFGD', 'resource' => '1B00B3', 'capacity' => 96, 'width' => 1.600, 'length' => 100, 'product' => 'PP Normal', 'process' => 'Rewind Jumbo', 'material_fg_sfg_kode_lama' => null, 'material_fg_sfg' => '7PORA00-Y00U10-00048-0001600A'],
            ['mat_type' => 'ZFGD', 'resource' => '1B00B3', 'capacity' => 96, 'width' => 1.600, 'length' => 100, 'product' => 'PP Normal', 'process' => 'Rewind Jumbo', 'material_fg_sfg_kode_lama' => null, 'material_fg_sfg' => '7PORA00-Y00U10-00048-0001600A'],

            // Group 4
            ['mat_type' => 'ZFGD', 'resource' => '1B08BD', 'capacity' => 360, 'width' => 1.600, 'length' => 1500, 'product' => 'PP Normal', 'process' => 'Rewind Jumbo', 'material_fg_sfg_kode_lama' => null, 'material_fg_sfg' => '7PORA00-000W10-00048-0001600F'],
            ['mat_type' => 'ZFGD', 'resource' => '1B08BD', 'capacity' => 360, 'width' => 1.600, 'length' => 1500, 'product' => 'PP Normal', 'process' => 'Rewind Jumbo', 'material_fg_sfg_kode_lama' => null, 'material_fg_sfg' => '7PORA00-000W10-00048-0001600F'],

            // Group 5
            ['mat_type' => 'ZSFG', 'resource' => '1B0808', 'capacity' => 217, 'width' => 1.8, 'length' => 1500, 'product' => 'PP Normal', 'process' => 'Spinning', 'material_fg_sfg_kode_lama' => null, 'material_fg_sfg' => 'P0RA00-000W10-00048'],
            ['mat_type' => 'ZSFG', 'resource' => '1B0808', 'capacity' => 217, 'width' => 1.8, 'length' => 1500, 'product' => 'PP Normal', 'process' => 'Spinning', 'material_fg_sfg_kode_lama' => null, 'material_fg_sfg' => 'P0RA00-000W10-00048'],
            ['mat_type' => 'ZSFG', 'resource' => '1B0808', 'capacity' => 217, 'width' => 1.8, 'length' => 1500, 'product' => 'PP Normal', 'process' => 'Spinning', 'material_fg_sfg_kode_lama' => null, 'material_fg_sfg' => 'P0RA00-000W10-00048'],
            ['mat_type' => 'ZSFG', 'resource' => '1B0808', 'capacity' => 217, 'width' => 1.8, 'length' => 1500, 'product' => 'PP Normal', 'process' => 'Spinning', 'material_fg_sfg_kode_lama' => null, 'material_fg_sfg' => 'P0RA00-000W10-00048'],
            ['mat_type' => 'ZSFG', 'resource' => '1B0808', 'capacity' => 217, 'width' => 1.8, 'length' => 1500, 'product' => 'PP Normal', 'process' => 'Spinning', 'material_fg_sfg_kode_lama' => null, 'material_fg_sfg' => 'P0RA00-000W10-00048'],

            // Group 6
            ['mat_type' => 'ZFGD', 'resource' => '1B08BD', 'capacity' => 83, 'width' => 1.480, 'length' => 250, 'product' => 'PP Normal', 'process' => 'Rewind Jumbo', 'material_fg_sfg_kode_lama' => null, 'material_fg_sfg' => '7PORA00-000W10-00060-0001480B'],
            ['mat_type' => 'ZFGD', 'resource' => '1B08BD', 'capacity' => 83, 'width' => 1.480, 'length' => 250, 'product' => 'PP Normal', 'process' => 'Rewind Jumbo', 'material_fg_sfg_kode_lama' => null, 'material_fg_sfg' => '7PORA00-000W10-00060-0001480B'],

            // Group 7
            ['mat_type' => 'ZFGD', 'resource' => '1B08BD', 'capacity' => 74, 'width' => 1.320, 'length' => 250, 'product' => 'PP Normal', 'process' => 'Rewind Jumbo', 'material_fg_sfg_kode_lama' => null, 'material_fg_sfg' => '7PORA00-000W10-00060-0001320B'],
            ['mat_type' => 'ZFGD', 'resource' => '1B08BD', 'capacity' => 74, 'width' => 1.320, 'length' => 250, 'product' => 'PP Normal', 'process' => 'Rewind Jumbo', 'material_fg_sfg_kode_lama' => null, 'material_fg_sfg' => '7PORA00-000W10-00060-0001320B'],
            
            // Group 8
            ['mat_type' => 'ZFGD', 'resource' => '1B08BC', 'capacity' => 61, 'width' => 1.080, 'length' => 250, 'product' => 'PP Normal', 'process' => 'Rewind Jumbo', 'material_fg_sfg_kode_lama' => null, 'material_fg_sfg' => '7PORA00-000W10-00060-0001080B'],
            ['mat_type' => 'ZFGD', 'resource' => '1B08BC', 'capacity' => 61, 'width' => 1.080, 'length' => 250, 'product' => 'PP Normal', 'process' => 'Rewind Jumbo', 'material_fg_sfg_kode_lama' => null, 'material_fg_sfg' => '7PORA00-000W10-00060-0001080B'],

            // Group 9
            ['mat_type' => 'ZFGD', 'resource' => '1B08BC', 'capacity' => 68, 'width' => 1.200, 'length' => 250, 'product' => 'PP Normal', 'process' => 'Rewind Jumbo', 'material_fg_sfg_kode_lama' => null, 'material_fg_sfg' => '7PORA00-000W10-00060-0001200B'],
            ['mat_type' => 'ZFGD', 'resource' => '1B08BC', 'capacity' => 68, 'width' => 1.200, 'length' => 250, 'product' => 'PP Normal', 'process' => 'Rewind Jumbo', 'material_fg_sfg_kode_lama' => null, 'material_fg_sfg' => '7PORA00-000W10-00060-0001200B'],
            
            // Group 10
            ['mat_type' => 'ZFGD', 'resource' => '1B10BE', 'capacity' => 308, 'width' => 0.800, 'length' => 1000, 'product' => 'PP Normal', 'process' => 'Rewind Jumbo', 'material_fg_sfg_kode_lama' => null, 'material_fg_sfg' => '7PORAH0-000110-00070-0000800E'],
            ['mat_type' => 'ZFGD', 'resource' => '1B10BE', 'capacity' => 308, 'width' => 0.800, 'length' => 1000, 'product' => 'PP Normal', 'process' => 'Rewind Jumbo', 'material_fg_sfg_kode_lama' => null, 'material_fg_sfg' => '7PORAH0-000110-00070-0000800E'],

            // Group 11
            ['mat_type' => 'ZFGD', 'resource' => '1B00B1', 'capacity' => 98, 'width' => 0.050, 'length' => 1000, 'product' => 'PP Normal', 'process' => 'Rewind Jumbo', 'material_fg_sfg_kode_lama' => null, 'material_fg_sfg' => '7PORAH0-000R25-00070-0000050E'],
            ['mat_type' => 'ZFGD', 'resource' => '1B00B1', 'capacity' => 98, 'width' => 0.050, 'length' => 1000, 'product' => 'PP Normal', 'process' => 'Rewind Jumbo', 'material_fg_sfg_kode_lama' => null, 'material_fg_sfg' => '7PORAH0-000R25-00070-0000050E'],

            // Group 12
            ['mat_type' => 'ZFGD', 'resource' => '1B10BE', 'capacity' => 308, 'width' => 0.800, 'length' => 1000, 'product' => 'PP Normal', 'process' => 'Rewind Jumbo', 'material_fg_sfg_kode_lama' => null, 'material_fg_sfg' => '7PORAH0-000R25-00070-0000800E'],
            ['mat_type' => 'ZFGD', 'resource' => '1B10BE', 'capacity' => 308, 'width' => 0.800, 'length' => 1000, 'product' => 'PP Normal', 'process' => 'Rewind Jumbo', 'material_fg_sfg_kode_lama' => null, 'material_fg_sfg' => '7PORAH0-000R25-00070-0000800E'],

            // Group 13
            ['mat_type' => 'ZFGD', 'resource' => '1B00B1', 'capacity' => 98, 'width' => 0.050, 'length' => 1000, 'product' => 'PP Normal', 'process' => 'Rewind Jumbo', 'material_fg_sfg_kode_lama' => null, 'material_fg_sfg' => '7PORAH0-000R25-00070-0000050E'],
            ['mat_type' => 'ZFGD', 'resource' => '1B00B1', 'capacity' => 98, 'width' => 0.050, 'length' => 1000, 'product' => 'PP Normal', 'process' => 'Rewind Jumbo', 'material_fg_sfg_kode_lama' => null, 'material_fg_sfg' => '7PORAH0-000R25-00070-0000050E'],
        ];

        $insertData = array_map(fn($item) => array_merge($item, [
            'isactive' => 1, 'created_at' => $now, 'updated_at' => $now, 'user_create' => 'Seeder', 'user_update' => 'Seeder',
        ]), $data);

        DB::table('trs_bom_h')->insert($insertData);
    }

    /**
     * Seeds the trs_bom_d table.
     */
    private function seedTrsBomD(): void
    {
        $this->command->info('Seeding trs_bom_d table...');
        $now = Carbon::now();
        // Here you would fetch the IDs from trs_bom_h to link them correctly.
        // For this example, we'll use placeholder IDs as in your previous code.
        $data = [
            // Group for fk_trs_bom_h_id = 3 (P0RA00-Y00U10-00020)
            ['fk_trs_bom_h_id' => 3, 'header_desc' => 'Nonwovens Spunbond P0RA00-Y00U10-00020', 'plant' => '1001', 'usage' => '1', 'alt_bom_no' => '1', 'valid_from' => '2021-08-01', 'alternative_bom_text' => '01.08.2021-BS-RED', 'product_qty' => 7.123, 'base_uom_header' => 'KG', 'item_number' => '0010', 'type' => 'L', 'comp_material_code' => '1P_EDMNRMMN00', 'comp_desc' => 'Nonwovens Spunbond P0RA00-Y00U10-00020', 'comp_qty' => 9.130, 'uom' => 'KG', 'length_per_unit' => null, 'waste_jumbo' => 22.00, 'remark' => null, 'lebar' => null],
            ['fk_trs_bom_h_id' => 3, 'header_desc' => 'Nonwovens Spunbond P0RA00-Y00U10-00020', 'plant' => '1001', 'usage' => '1', 'alt_bom_no' => '1', 'valid_from' => '2021-08-01', 'alternative_bom_text' => '01.08.2021-BS-RED', 'product_qty' => 7.123, 'base_uom_header' => 'KG', 'item_number' => '0020', 'type' => 'L', 'comp_material_code' => '3P_BMMJCT70000', 'comp_desc' => 'CORE 3" 8 MM X 178 CM CHIP BOARD', 'comp_qty' => 1.700, 'uom' => 'PC', 'length_per_unit' => null, 'waste_jumbo' => null, 'remark' => null, 'lebar' => null],
            ['fk_trs_bom_h_id' => 3, 'header_desc' => 'Nonwovens Spunbond P0RA00-Y00U10-00020', 'plant' => '1001', 'usage' => '1', 'alt_bom_no' => '1', 'valid_from' => '2021-08-01', 'alternative_bom_text' => '01.08.2021-BS-RED', 'product_qty' => 100.000, 'base_uom_header' => 'KG', 'item_number' => '0010', 'type' => 'L', 'comp_material_code' => '1P_EXVLMAXB001', 'comp_desc' => 'PP CHIPS EXXON 130E5 (BAG)', 'comp_qty' => 11.100, 'uom' => 'KG', 'length_per_unit' => 2000, 'waste_jumbo' => null, 'remark' => null, 'lebar' => 2.550],
            // ... (Continue adding all rows from the image with the same fk_trs_bom_h_id)

            // Group for fk_trs_bom_h_id = 15 (P0RA00-000W10-00048)
            ['fk_trs_bom_h_id' => 15, 'header_desc' => 'Nonwovens Spunbond P0RA00-000W10-00048', 'plant' => '1001', 'usage' => '1', 'alt_bom_no' => '1', 'valid_from' => '2021-08-01', 'alternative_bom_text' => '01.08.2021-BS-PM', 'product_qty' => 3.680, 'base_uom_header' => 'KG', 'item_number' => '0010', 'type' => 'L', 'comp_material_code' => 'P0RA00-000W10-00048-0001600F', 'comp_desc' => 'Nonwovens Spunbond P0RA00-000W10-00048', 'comp_qty' => 2.934, 'uom' => 'KG', 'length_per_unit' => null, 'waste_jumbo' => 4.76, 'remark' => null, 'lebar' => null],
            ['fk_trs_bom_h_id' => 15, 'header_desc' => 'Nonwovens Spunbond P0RA00-000W10-00048', 'plant' => '1001', 'usage' => '1', 'alt_bom_no' => '1', 'valid_from' => '2021-08-01', 'alternative_bom_text' => '01.08.2021-BS-PM', 'product_qty' => 3.680, 'base_uom_header' => 'KG', 'item_number' => '0020', 'type' => 'L', 'comp_material_code' => '3P_BMMJCT70000', 'comp_desc' => 'CORE 3" 8 MM X 1.6 M CHIP BOARD', 'comp_qty' => 1.000, 'uom' => 'PC', 'length_per_unit' => null, 'waste_jumbo' => null, 'remark' => null, 'lebar' => null],

            // Group for fk_trs_bom_h_id = 20 (P0RA00-000W10-00060)
            ['fk_trs_bom_h_id' => 20, 'header_desc' => 'Nonwovens Spunbond P0RA00-000W10-00060', 'plant' => '1001', 'usage' => '1', 'alt_bom_no' => '1', 'valid_from' => '2021-08-01', 'alternative_bom_text' => '01.08.2021-BS-SC', 'product_qty' => 22.228, 'base_uom_header' => 'KG', 'item_number' => '0010', 'type' => 'L', 'comp_material_code' => '1P_EDMNRMMN00', 'comp_desc' => 'Nonwovens Spunbond P0RA00-000W10-00060', 'comp_qty' => 27.540, 'uom' => 'KG', 'length_per_unit' => null, 'waste_jumbo' => 19.39, 'remark' => null, 'lebar' => null],
            ['fk_trs_bom_h_id' => 20, 'header_desc' => 'Nonwovens Spunbond P0RA00-000W10-00060', 'plant' => '1001', 'usage' => '1', 'alt_bom_no' => '1', 'valid_from' => '2021-08-01', 'alternative_bom_text' => '01.08.2021-BS-SC', 'product_qty' => 22.228, 'base_uom_header' => 'KG', 'item_number' => '0020', 'type' => 'L', 'comp_material_code' => '3P_BMMJCT70000', 'comp_desc' => 'CORE 3" 8 MM X 1.320 M CHIP BOARD', 'comp_qty' => 1.700, 'uom' => 'PC', 'length_per_unit' => null, 'waste_jumbo' => null, 'remark' => null, 'lebar' => null],

             // Group for fk_trs_bom_h_id = 28 (P0RAH0-000110-00070)
            ['fk_trs_bom_h_id' => 28, 'header_desc' => 'Nonwovens Spunbond P0RAH0-000110-00070', 'plant' => '1001', 'usage' => '1', 'alt_bom_no' => '1', 'valid_from' => '2021-08-01', 'alternative_bom_text' => '01.08.2021-BE-JVS', 'product_qty' => 58.000, 'base_uom_header' => 'KG', 'item_number' => '0010', 'type' => 'L', 'comp_material_code' => 'P0RAH0-000110-00070', 'comp_desc' => 'Nonwovens Spunbond P0RAH0-000110-00070', 'comp_qty' => 59.450, 'uom' => 'KG', 'length_per_unit' => null, 'waste_jumbo' => 8.85, 'remark' => null, 'lebar' => null],
            ['fk_trs_bom_h_id' => 28, 'header_desc' => 'Nonwovens Spunbond P0RAH0-000110-00070', 'plant' => '1001', 'usage' => '1', 'alt_bom_no' => '1', 'valid_from' => '2021-08-01', 'alternative_bom_text' => '01.08.2021-BE-JVS', 'product_qty' => 58.000, 'base_uom_header' => 'KG', 'item_number' => '0020', 'type' => 'L', 'comp_material_code' => '3P_BMMJCT70000', 'comp_desc' => 'CORE 3" 8 MM X 0.800 M CHIP BOARD', 'comp_qty' => 1.700, 'uom' => 'PC', 'length_per_unit' => null, 'waste_jumbo' => null, 'remark' => null, 'lebar' => null],

             // Group for fk_trs_bom_h_id = 30 (P0RAH0-000R25-00070)
            ['fk_trs_bom_h_id' => 30, 'header_desc' => 'Nonwovens Spunbond P0RAH0-000R25-00070', 'plant' => '1001', 'usage' => '1', 'alt_bom_no' => '1', 'valid_from' => '2021-08-01', 'alternative_bom_text' => '01.08.2021-BE-JVS', 'product_qty' => 58.000, 'base_uom_header' => 'KG', 'item_number' => '0010', 'type' => 'L', 'comp_material_code' => '1P_EDMNRMMN00', 'comp_desc' => 'Nonwovens Spunbond P0RAH0-000R25-00070', 'comp_qty' => 59.450, 'uom' => 'KG', 'length_per_unit' => null, 'waste_jumbo' => 5.86, 'remark' => null, 'lebar' => null],
            ['fk_trs_bom_h_id' => 30, 'header_desc' => 'Nonwovens Spunbond P0RAH0-000R25-00070', 'plant' => '1001', 'usage' => '1', 'alt_bom_no' => '1', 'valid_from' => '2021-08-01', 'alternative_bom_text' => '01.08.2021-BE-JVS', 'product_qty' => 58.000, 'base_uom_header' => 'KG', 'item_number' => '0020', 'type' => 'L', 'comp_material_code' => '3P_BMMJCT70000', 'comp_desc' => 'CORE 3" 8 MM X 0.050 M CHIP BOARD', 'comp_qty' => 1.700, 'uom' => 'PC', 'length_per_unit' => null, 'waste_jumbo' => null, 'remark' => null, 'lebar' => null],
        ];

        $insertData = array_map(fn($item) => array_merge($item, [
             'isactive' => 1, 'created_at' => $now, 'updated_at' => $now, 'user_create' => 'Seeder', 'user_update' => 'Seeder',
        ]), $data);

        DB::table('trs_bom_d')->insert($insertData);
    }

    /**
     * Seeds the mst_material table based on data from BOM tables.
     */
    private function seedMstMaterial(): void
    {
        $this->command->info('Seeding mst_material table...');
        $now = Carbon::now();
        $bomHMaterials = DB::table('trs_bom_h')->pluck('material_fg_sfg')->filter();
        $bomDMaterials = DB::table('trs_bom_d')->pluck('comp_material_code')->filter();
        $allUniqueMaterials = $bomHMaterials->concat($bomDMaterials)->unique()->values();
        
        $materialsToInsert = [];
        $this->command->getOutput()->progressStart($allUniqueMaterials->count());

        foreach ($allUniqueMaterials as $materialCode) {
            $bomHRecord = DB::table('trs_bom_h')->where('material_fg_sfg', $materialCode)->first();
            $bomDRecord = DB::table('trs_bom_d')->where('comp_material_code', $materialCode)->first();
            $productName = $bomDRecord->comp_desc ?? ($bomHRecord->product ?? 'Unknown Product');
            
            $firstPart = explode('-', $materialCode)[0];
            $idMatGroup = substr($firstPart, 0, 2);
            $matG1 = substr($firstPart, 2, 2);
            $matG2 = substr($firstPart, 4, 3);
            $matG3 = substr($firstPart, 7, 3);

            $materialsToInsert[] = [
                'kode_baru_fg' => $materialCode, 'id_mat_group' => $idMatGroup, 'customer' => 'INTERNAL',
                'product_name' => substr($productName, 0, 25), 'division' => '10', 'mat_g1' => $matG1,
                'mat_g2' => $matG2, 'mat_g3' => $matG3, 'keterangan' => $productName,
                'length' => $bomHRecord->length ?? ($bomDRecord->length_per_unit ?? null),
                'width' => $bomHRecord->width ?? ($bomDRecord->lebar ?? null), 'weight' => null,
                'alt_uom' => 'KG', 'top_load' => null, 'created_at' => $now, 'updated_at' => $now,
                'user_create' => 'Seeder', 'user_update' => 'Seeder', 'it_update' => null,
                'status' => '1', 'isactive' => '1',
            ];
            $this->command->getOutput()->progressAdvance();
        }

        foreach (array_chunk($materialsToInsert, 500) as $chunk) {
            DB::table('mst_material')->insert($chunk);
        }

        $this->command->getOutput()->progressFinish();
    }
}