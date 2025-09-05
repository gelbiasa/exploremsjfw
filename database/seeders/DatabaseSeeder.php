<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Prophecy\Call\Call;
use Carbon\Carbon;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //insert tabel sys_roles
        DB::table('sys_roles')->insert([
            'idroles' => 'admins',
            'name' => 'Admin',
            'description' => 'Administrator'
        ]);

        //insert tabel users
        DB::table('users')->insert([
            'username' => 'msjit',
            'firstname' => 'Admin',
            'lastname' => 'MIS',
            'email' => 'msjit@spunindo.com',
            'password' => bcrypt('mis'),
            'idroles' => 'admins'
        ]);

        //insert tabel sys_gmenu
        DB::table('sys_gmenu')->insert([
            'gmenu' => 'blankx',
            'urut' => 1,
            'name' => '-',
            'icon' => '-'
        ]);
        DB::table('sys_gmenu')->insert([
            'gmenu' => 'master',
            'urut' => 2,
            'name' => 'Master',
            'icon' => 'ni-collection'
        ]);
        DB::table('sys_gmenu')->insert([
            'gmenu' => 'transc',
            'urut' => 3,
            'name' => 'Transactions',
            'icon' => 'ni-collection'
        ]);
        DB::table('sys_gmenu')->insert([
            'gmenu' => 'report',
            'urut' => 4,
            'name' => 'Report',
            'icon' => 'ni-single-copy-04'
        ]);
        DB::table('sys_gmenu')->insert([
            'gmenu' => 'system',
            'urut' => 5,
            'name' => 'System',
            'icon' => 'ni-mobile-button'
        ]);

        //insert tabel sys_dmenu
        DB::table('sys_dmenu')->insert([
            'gmenu' => 'blankx',
            'dmenu' => 'dashbr',
            'urut' => 1,
            'name' => 'Dashboard',
            'url' => 'dashboard',
            'icon' => 'ni-tv-2',
            'tabel' => '-',
            'layout' => 'manual'
        ]);
        DB::table('sys_dmenu')->insert([
            'gmenu' => 'system',
            'dmenu' => 'gmenux',
            'urut' => 1,
            'name' => 'Group Menu',
            'url' => 'sysgmenu',
            'icon' => 'ni-collection',
            'tabel' => 'sys_gmenu',
            'layout' => 'standr'
        ]);
        DB::table('sys_dmenu')->insert([
            'gmenu' => 'system',
            'dmenu' => 'dmenux',
            'urut' => 2,
            'name' => 'List Menu',
            'url' => 'sysdmenu',
            'icon' => 'ni-collection',
            'tabel' => 'sys_dmenu',
            'layout' => 'master'
        ]);
        DB::table('sys_dmenu')->insert([
            'gmenu' => 'system',
            'dmenu' => 'rolesx',
            'urut' => 3,
            'name' => 'Roles',
            'url' => 'sysroles',
            'icon' => 'ni-collection',
            'tabel' => 'sys_roles',
            'layout' => 'standr'
        ]);
        DB::table('sys_dmenu')->insert([
            'gmenu' => 'system',
            'dmenu' => 'authxx',
            'urut' => 4,
            'name' => 'Authorize',
            'url' => 'sysauth',
            'icon' => 'ni-single-copy-04',
            'tabel' => 'sys_auth',
            'layout' => 'system'
        ]);
        DB::table('sys_dmenu')->insert([
            'gmenu' => 'system',
            'dmenu' => 'tablex',
            'urut' => 5,
            'name' => 'Tabel Menu',
            'url' => 'systbl',
            'icon' => 'ni-single-copy-04',
            'tabel' => 'sys_table',
            'layout' => 'system'
        ]);
        DB::table('sys_dmenu')->insert([
            'gmenu' => 'system',
            'dmenu' => 'usersx',
            'urut' => 6,
            'name' => 'Users',
            'url' => 'sysuser',
            'icon' => 'ni-single-02',
            'tabel' => 'users',
            'layout' => 'master'
        ]);
        DB::table('sys_dmenu')->insert([
            'gmenu' => 'system',
            'dmenu' => 'sysidx',
            'urut' => 7,
            'name' => 'Generate ID',
            'url' => 'sysid',
            'icon' => 'ni-ui-04',
            'tabel' => 'sys_id',
            'layout' => 'master',
            'js' => '1'
        ]);
        DB::table('sys_dmenu')->insert([
            'gmenu' => 'system',
            'dmenu' => 'syscnt',
            'urut' => 8,
            'name' => 'ID Counter',
            'url' => 'syscnt',
            'icon' => 'ni-ui-04',
            'tabel' => 'sys_counter',
            'layout' => 'standr'
        ]);
        DB::table('sys_dmenu')->insert([
            'gmenu' => 'system',
            'dmenu' => 'setupx',
            'urut' => 9,
            'name' => 'Setup',
            'url' => 'sysapp',
            'icon' => 'ni-ui-04',
            'tabel' => 'sys_app',
            'layout' => 'master'
        ]);
        DB::table('sys_dmenu')->insert([
            'gmenu' => 'master',
            'dmenu' => 'msenum',
            'urut' => 1,
            'name' => 'Default Value',
            'url' => 'msenum',
            'icon' => 'ni-ui-04',
            'tabel' => 'sys_enum',
            'layout' => 'master'
        ]);
        DB::table('sys_dmenu')->insert([
            'gmenu' => 'report',
            'dmenu' => 'rsyslg',
            'urut' => 1,
            'name' => 'Log User',
            'url' => 'rsyslg',
            'icon' => 'ni-ui-04',
            'tabel' => '-',
            'layout' => 'report'
        ]);

        //insert tabel sys_auth        
        DB::table('sys_auth')->insert([
            'idroles' => 'admins',
            'gmenu' => 'blankx',
            'dmenu' => 'dashbr',
            'add' => '1',
            'edit' => '1',
            'delete' => '1'
        ]);
        DB::table('sys_auth')->insert([
            'idroles' => 'admins',
            'gmenu' => 'system',
            'dmenu' => 'usersx',
            'add' => '1',
            'edit' => '1',
            'delete' => '1'
        ]);
        DB::table('sys_auth')->insert([
            'idroles' => 'admins',
            'gmenu' => 'system',
            'dmenu' => 'rolesx',
            'add' => '1',
            'edit' => '1',
            'delete' => '1'
        ]);
        DB::table('sys_auth')->insert([
            'idroles' => 'admins',
            'gmenu' => 'system',
            'dmenu' => 'authxx',
            'add' => '1',
            'edit' => '1',
            'delete' => '1'
        ]);
        DB::table('sys_auth')->insert([
            'idroles' => 'admins',
            'gmenu' => 'system',
            'dmenu' => 'tablex',
            'add' => '1',
            'edit' => '1',
            'delete' => '1'
        ]);
        DB::table('sys_auth')->insert([
            'idroles' => 'admins',
            'gmenu' => 'system',
            'dmenu' => 'setupx',
            'add' => '1',
            'edit' => '1',
            'delete' => '1'
        ]);
        DB::table('sys_auth')->insert([
            'idroles' => 'admins',
            'gmenu' => 'system',
            'dmenu' => 'gmenux',
            'add' => '1',
            'edit' => '1',
            'delete' => '1'
        ]);
        DB::table('sys_auth')->insert([
            'idroles' => 'admins',
            'gmenu' => 'system',
            'dmenu' => 'dmenux',
            'add' => '1',
            'edit' => '1',
            'delete' => '1'
        ]);
        DB::table('sys_auth')->insert([
            'idroles' => 'admins',
            'gmenu' => 'system',
            'dmenu' => 'sysidx',
            'add' => '1',
            'edit' => '1',
            'delete' => '1'
        ]);
        DB::table('sys_auth')->insert([
            'idroles' => 'admins',
            'gmenu' => 'system',
            'dmenu' => 'syscnt',
            'add' => '0',
            'edit' => '1',
            'delete' => '1'
        ]);
        DB::table('sys_auth')->insert([
            'idroles' => 'admins',
            'gmenu' => 'master',
            'dmenu' => 'msenum',
            'add' => '1',
            'edit' => '1',
            'delete' => '1'
        ]);
        DB::table('sys_auth')->insert([
            'idroles' => 'admins',
            'gmenu' => 'report',
            'dmenu' => 'rsyslg',
            'add' => '1',
            'edit' => '0',
            'delete' => '0'
        ]);

        //sys_enum
        DB::table('sys_enum')->insert([
            'idenum' => 'isactive',
            'value' => '1',
            'name' => 'Active'
        ]);
        DB::table('sys_enum')->insert([
            'idenum' => 'isactive',
            'value' => '0',
            'name' => 'Not Active'
        ]);
        DB::table('sys_enum')->insert([
            'idenum' => 'status',
            'value' => '1',
            'name' => 'Sukses'
        ]);
        DB::table('sys_enum')->insert([
            'idenum' => 'status',
            'value' => '0',
            'name' => 'Gagal'
        ]);
        DB::table('sys_enum')->insert([
            'idenum' => 'questions',
            'value' => '1',
            'name' => 'YA'
        ]);
        DB::table('sys_enum')->insert([
            'idenum' => 'questions',
            'value' => '0',
            'name' => 'TIDAK'
        ]);
        DB::table('sys_enum')->insert([
            'idenum' => 'layout',
            'value' => 'manual',
            'name' => 'Manual'
        ]);
        DB::table('sys_enum')->insert([
            'idenum' => 'layout',
            'value' => 'master',
            'name' => 'Master'
        ]);
        DB::table('sys_enum')->insert([
            'idenum' => 'layout',
            'value' => 'system',
            'name' => 'System'
        ]);
        DB::table('sys_enum')->insert([
            'idenum' => 'layout',
            'value' => 'report',
            'name' => 'Report'
        ]);
        DB::table('sys_enum')->insert([
            'idenum' => 'layout',
            'value' => 'transc',
            'name' => 'Transaction'
        ]);
        DB::table('sys_enum')->insert([
            'idenum' => 'layout',
            'value' => 'standr',
            'name' => 'Standard'
        ]);
        DB::table('sys_enum')->insert([
            'idenum' => 'layout',
            'value' => 'sublnk',
            'name' => 'Sub Link'
        ]);
        DB::table('sys_enum')->insert([
            'idenum' => 'source',
            'value' => 'int',
            'name' => 'Internal'
        ]);
        DB::table('sys_enum')->insert([
            'idenum' => 'source',
            'value' => 'ext',
            'name' => 'External'
        ]);
        DB::table('sys_enum')->insert([
            'idenum' => 'source',
            'value' => 'th4',
            'name' => 'Tahun 4 digit'
        ]);
        DB::table('sys_enum')->insert([
            'idenum' => 'source',
            'value' => 'th2',
            'name' => 'Tahun 2 Digit'
        ]);
        DB::table('sys_enum')->insert([
            'idenum' => 'source',
            'value' => 'bln',
            'name' => 'Bulan'
        ]);
        DB::table('sys_enum')->insert([
            'idenum' => 'source',
            'value' => 'tgl',
            'name' => 'Tanggal'
        ]);
        DB::table('sys_enum')->insert([
            'idenum' => 'source',
            'value' => 'cnt',
            'name' => 'Counter'
        ]);
        DB::table('sys_enum')->insert([
            'idenum' => 'position',
            'value' => '0',
            'name' => 'Standard'
        ]);
        DB::table('sys_enum')->insert([
            'idenum' => 'position',
            'value' => '1',
            'name' => 'Header'
        ]);
        DB::table('sys_enum')->insert([
            'idenum' => 'position',
            'value' => '2',
            'name' => 'Detail'
        ]);
        DB::table('sys_enum')->insert([
            'idenum' => 'position',
            'value' => '3',
            'name' => 'Left'
        ]);
        DB::table('sys_enum')->insert([
            'idenum' => 'position',
            'value' => '4',
            'name' => 'Right'
        ]);
        DB::table('sys_enum')->insert([
            'idenum' => 'type',
            'value' => 'char',
            'name' => 'Char'
        ]);
        DB::table('sys_enum')->insert([
            'idenum' => 'type',
            'value' => 'string',
            'name' => 'String'
        ]);
        DB::table('sys_enum')->insert([
            'idenum' => 'type',
            'value' => 'email',
            'name' => 'Email'
        ]);
        DB::table('sys_enum')->insert([
            'idenum' => 'type',
            'value' => 'enum',
            'name' => 'Select Option'
        ]);
        DB::table('sys_enum')->insert([
            'idenum' => 'type',
            'value' => 'image',
            'name' => 'Image'
        ]);
        DB::table('sys_enum')->insert([
            'idenum' => 'type',
            'value' => 'join',
            'name' => 'Join'
        ]);
        DB::table('sys_enum')->insert([
            'idenum' => 'type',
            'value' => 'number',
            'name' => 'Number'
        ]);
        DB::table('sys_enum')->insert([
            'idenum' => 'type',
            'value' => 'password',
            'name' => 'Password'
        ]);
        DB::table('sys_enum')->insert([
            'idenum' => 'type',
            'value' => 'report',
            'name' => 'Report'
        ]);
        DB::table('sys_enum')->insert([
            'idenum' => 'type',
            'value' => 'text',
            'name' => 'Text'
        ]);
        DB::table('sys_enum')->insert([
            'idenum' => 'type',
            'value' => 'hidden',
            'name' => 'Hidden'
        ]);
        DB::table('sys_enum')->insert([
            'idenum' => 'type',
            'value' => 'date',
            'name' => 'Date'
        ]);
        DB::table('sys_enum')->insert([
            'idenum' => 'type',
            'value' => 'date2',
            'name' => 'Date Between'
        ]);
        DB::table('sys_enum')->insert([
            'idenum' => 'type',
            'value' => 'file',
            'name' => 'File Upload'
        ]);
        DB::table('sys_enum')->insert([
            'idenum' => 'type',
            'value' => 'search',
            'name' => 'Modal Search'
        ]);
        DB::table('sys_enum')->insert([
            'idenum' => 'type',
            'value' => 'currency',
            'name' => 'Currency'
        ]);
        DB::table('sys_enum')->insert([
            'idenum' => 'type',
            'value' => 'sublink',
            'name' => 'Sub Link'
        ]);
        DB::table('sys_enum')->insert([
            'idenum' => 'primary',
            'value' => '1',
            'name' => 'YA'
        ]);
        DB::table('sys_enum')->insert([
            'idenum' => 'primary',
            'value' => '0',
            'name' => 'TIDAK'
        ]);
        DB::table('sys_enum')->insert([
            'idenum' => 'primary',
            'value' => '2',
            'name' => 'UNIQUE'
        ]);
        DB::table('sys_enum')->insert([
            'idenum' => 'tahun',
            'value' => '2024',
            'name' => '2024'
        ]);
        DB::table('sys_enum')->insert([
            'idenum' => 'tahun',
            'value' => '2025',
            'name' => '2025'
        ]);
        DB::table('sys_enum')->insert([
            'idenum' => 'tahun',
            'value' => '2026',
            'name' => '2026'
        ]);

        //insert tabel sys_app        
        DB::table('sys_app')->insert([
            'appid' => 'msjframework',
            'appname' => 'MSJFramework',
            'description' => 'Framework Pembuatan Aplikasi Baru',
            'company' => 'PT MULTI SPUNINDO JAYA Tbk',
            'address' => 'Desa Jabaran, Balongbendo 61263.',
            'city' => 'SIDOARJO',
            'province' => 'JAWA TIMUR',
            'country' => 'INDONESIA',
            'telephone' => '+62-31-897 1301, 897 5555',
            'fax' => '+62-31-897 6666'
        ]);

        // Get current timestamp for created_at and updated_at
        $now = Carbon::now();

        // Data extracted from the provided image
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

        // Prepare data for insertion by adding timestamps
        $insertData = array_map(function ($item) use ($now) {
            return array_merge($item, [
                'isactive' => 1,
                'created_at' => $now,
                'updated_at' => $now,
                'user_create' => 'Seeder',
                'user_update' => 'Seeder',
            ]);
        }, $data);

        // Insert data into the database
        DB::table('trs_bom_h')->insert($insertData);

        $now = Carbon::now();

        // Data from the second image, mapped to the migration schema.
        // NOTE: The 'fk_trs_bom_h_id' is an assumption based on the order of data from the previous seeder.
        // You may need to adjust these IDs if your header data is different.
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

        // Clean and prepare the data for insertion
        $insertData = array_map(function ($item) use ($now) {
            // Function to clean numeric values (remove letters, use dot for decimal)
            $cleanNumber = function ($value) {
                if (is_null($value)) return null;
                $cleaned = preg_replace('/[^\d,\.]/', '', $value);
                $cleaned = str_replace(',', '.', $cleaned);
                return is_numeric($cleaned) ? (float)$cleaned : null;
            };
            
            // Function to clean percentage values
            $cleanPercent = function ($value) {
                if (is_null($value)) return null;
                $cleaned = str_replace(['%', ','], ['', '.'], $value);
                return is_numeric($cleaned) ? (float)$cleaned : null;
            };

            return [
                'fk_trs_bom_h_id' => $item['fk_trs_bom_h_id'],
                'header_desc' => $item['header_desc'],
                'plant' => $item['plant'],
                'usage' => $item['usage'],
                'alt_bom_no' => $item['alt_bom_no'],
                'valid_from' => $item['valid_from'],
                'alternative_bom_text' => $item['alternative_bom_text'],
                'product_qty' => $cleanNumber($item['product_qty']),
                'base_uom_header' => $item['base_uom_header'],
                'item_number' => $item['item_number'],
                'type' => $item['type'],
                'comp_material_code' => $item['comp_material_code'],
                'comp_desc' => $item['comp_desc'],
                'comp_qty' => $cleanNumber($item['comp_qty']),
                'uom' => $item['uom'],
                'wip_material' => null, // Not in the image
                'length_per_unit' => $cleanNumber($item['length_per_unit']),
                'waste_jumbo' => $cleanPercent($item['waste_jumbo']),
                'remark' => $item['remark'],
                'gsm' => null, // Not in the image
                'extra_panjang' => null, // Not in the image
                'jumbo' => null, // Not in the image
                'rewind' => null, // Not in the image
                'berat_sfg' => null, // Not in the image
                'lebar' => $cleanNumber($item['lebar']),
                'isactive' => 1,
                'created_at' => $now,
                'updated_at' => $now,
                'user_create' => 'Seeder',
                'user_update' => 'Seeder',
            ];
        }, $data);

        // Insert the data into the database
        DB::table('trs_bom_d')->insert($insertData);

        //other seeder
        $this->call([
            tabel_users::class,
            tabel_tabel_menu::class,
            tabel_sys_gmenu::class,
            tabel_sys_dmenu::class,
            tabel_sys_enum::class,
            tabel_sys_id::class,
            tabel_sys_counter::class,
            tabel_sys_app::class,
            tabel_sys_role::class,
            tabel_sys_auth::class,
            tabel_rpt_syslog::class,
            menu_rpt_seeder::class,
            tabel_rpt_seeder::class,
            example_call_seed::class,
        ]);
    }
}
