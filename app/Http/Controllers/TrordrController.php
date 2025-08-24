<?php

namespace App\Http\Controllers;

use App\Helpers\Format_Helper;
use App\Helpers\Function_Helper;
use App\Models\User;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class TrordrController extends Controller
{
    public function index($data)
    {
        // function helper
        $data['format'] = new Format_Helper;

        // Ambil data orders dengan join ke customer untuk mendapatkan nama
        $data['table_detail_h'] = DB::table('trs_orders as o')
            ->join('mst_customer as c', 'o.fk_cust_id', '=', 'c.cust_id')
            ->select(
                'o.trordr_id',
                DB::raw("CONCAT(c.cust_name) as nama_customer"),
                'o.ordr_order_date',
                'o.ordr_total_amount',
                'o.isactive'
            )
            ->where('o.isactive', '1')
            ->get();

        //list data table untuk detail (kosong dulu, akan diisi via ajax)
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

        // Ambil detail order items berdasarkan trordr_id
        $data['table_detail_d_ajax'] = DB::table('trs_orders_item as oi')
            ->join('mst_produk as p', 'oi.fk_pdrk_id', '=', 'p.pdrk_id')
            ->select(
                'oi.trordr_it_id',
                'oi.fk_trordr_id',
                'p.pdrk_name',
                'oi.ordr_it_quantity',
                'oi.ordr_it_price',
                'oi.ordr_it_subtotal',
                'oi.isactive'
            )
            ->where('oi.fk_trordr_id', $id)
            ->where('oi.isactive', '1')
            ->get();

        // Set encrypt primary key untuk detail
        $data['encrypt_primary'] = array();
        foreach ($data['table_detail_d_ajax'] as $detail) {
            array_push($data['encrypt_primary'], encrypt($detail->trordr_it_id));
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

        //check athorization access add
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
        // function helper
        $syslog = new Function_Helper;

        try {
            DB::beginTransaction();

            // Validasi input dasar
            request()->validate([
                'fk_cust_id' => 'required|exists:mst_customer,cust_id',
                'ordr_order_date' => 'required|date',
                'ordr_total_amount' => 'required|numeric|min:1',
                'products' => 'required|array|min:1',
                'products.*.fk_pdrk_id' => 'required|exists:mst_produk,pdrk_id',
                'products.*.ordr_it_quantity' => 'required|integer|min:1',
                'products.*.ordr_it_price' => 'required|numeric|min:1',
                'products.*.ordr_it_subtotal' => 'required|numeric|min:1'
            ], [
                'required' => ':attribute tidak boleh kosong',
                'exists' => ':attribute tidak valid',
                'min' => ':attribute minimal :min',
                'numeric' => ':attribute harus berupa angka',
                'integer' => ':attribute harus berupa bilangan bulat',
                'array' => ':attribute harus berupa array'
            ]);

            // Validasi stock untuk setiap produk
            $products = request('products');
            foreach ($products as $index => $product) {
                $produkData = DB::table('mst_produk')
                    ->where('pdrk_id', $product['fk_pdrk_id'])
                    ->where('isactive', '1')
                    ->first();

                if (!$produkData) {
                    throw new \Exception("Produk dengan ID {$product['fk_pdrk_id']} tidak ditemukan");
                }

                if ($produkData->pdrk_stock < $product['ordr_it_quantity']) {
                    throw new \Exception("Stock produk {$produkData->pdrk_name} tidak mencukupi. Stock tersedia: {$produkData->pdrk_stock}, quantity diminta: {$product['ordr_it_quantity']}");
                }
            }

            // Insert ke tabel trs_orders
            $orderId = DB::table('trs_orders')->insertGetId([
                'fk_cust_id' => request('fk_cust_id'),
                'ordr_order_date' => request('ordr_order_date'),
                'ordr_total_amount' => request('ordr_total_amount'),
                'user_create' => session('username'),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Insert ke tabel trs_orders_item dan update stock
            foreach ($products as $product) {
                // Insert order item
                DB::table('trs_orders_item')->insert([
                    'fk_trordr_id' => $orderId,
                    'fk_pdrk_id' => $product['fk_pdrk_id'],
                    'ordr_it_quantity' => $product['ordr_it_quantity'],
                    'ordr_it_price' => $product['ordr_it_price'],
                    'ordr_it_subtotal' => $product['ordr_it_subtotal'],
                    'user_create' => session('username'),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                // Update stock produk
                DB::table('mst_produk')
                    ->where('pdrk_id', $product['fk_pdrk_id'])
                    ->decrement('pdrk_stock', $product['ordr_it_quantity']);
            }

            DB::commit();

            // Log success
            $syslog->log_insert('C', $data['dmenu'], 'Created Order: ' . $orderId, '1');

            // Set success message
            Session::flash('message', 'Order berhasil dibuat!');
            Session::flash('class', 'success');
            Session::flash('idtrans', $orderId);

            return redirect($data['url_menu']);
        } catch (\Exception $e) {
            DB::rollback();

            // Log error
            $syslog->log_insert('E', $data['dmenu'], 'Create Order Error: ' . $e->getMessage(), '0');

            // Set error message
            Session::flash('message', 'Error: ' . $e->getMessage());
            Session::flash('class', 'danger');

            return redirect()->back()->withInput();
        }
    }
    /**
     * Display the specified resource.
     */
    public function show($data)
    {
        // function helper
        $syslog = new Function_Helper;

        //check decrypt
        try {
            $id = decrypt($data['idencrypt']);
        } catch (DecryptException $e) {
            $id = "";
        }

        if (empty($id)) {
            //if decrypt failed
            $data['url_menu'] = 'error';
            $data['title_group'] = 'Error';
            $data['title_menu'] = 'Error';
            $data['errorpages'] = 'Invalid ID!';
            //return error page
            return view("pages.errorpages", $data);
        }

        // Ambil data order item berdasarkan trordr_it_id
        $orderItem = DB::table('trs_orders_item as oi')
            ->join('mst_produk as p', 'oi.fk_pdrk_id', '=', 'p.pdrk_id')
            ->select('oi.*', 'p.pdrk_name', 'p.pdrk_price')
            ->where('oi.trordr_it_id', $id)
            ->where('oi.isactive', '1')
            ->first();

        if (!$orderItem) {
            //if order item not found
            $data['url_menu'] = 'error';
            $data['title_group'] = 'Error';
            $data['title_menu'] = 'Error';
            $data['errorpages'] = 'Order item tidak ditemukan!';
            //return error page
            return view("pages.errorpages", $data);
        }

        // Ambil data order dengan join customer berdasarkan fk_trordr_id
        $order = DB::table('trs_orders as o')
            ->join('mst_customer as c', 'o.fk_cust_id', '=', 'c.cust_id')
            ->select('o.*', 'c.cust_name', 'c.cust_email', 'c.cust_phone', 'c.cust_address')
            ->where('o.trordr_id', $orderItem->fk_trordr_id)
            ->where('o.isactive', '1')
            ->first();

        if (!$order) {
            //if order not found
            $data['url_menu'] = 'error';
            $data['title_group'] = 'Error';
            $data['title_menu'] = 'Error';
            $data['errorpages'] = 'Order tidak ditemukan!';
            //return error page
            return view("pages.errorpages", $data);
        }

        // Ambil semua order items dari order yang sama
        $orderItems = DB::table('trs_orders_item as oi')
            ->join('mst_produk as p', 'oi.fk_pdrk_id', '=', 'p.pdrk_id')
            ->select('oi.*', 'p.pdrk_name', 'p.pdrk_price')
            ->where('oi.fk_trordr_id', $orderItem->fk_trordr_id)
            ->where('oi.isactive', '1')
            ->get();

        // Set data untuk view
        $data['order'] = $order;
        $data['orderItems'] = $orderItems;
        $data['currentOrderItem'] = $orderItem; // Item yang sedang dilihat

        // Log access
        $syslog->log_insert('V', $data['dmenu'], 'View Order Item Detail: ' . $id, '1');

        // return page menu
        return view($data['url'], $data);
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

        if (empty($id)) {
            //if decrypt failed
            $data['url_menu'] = 'error';
            $data['title_group'] = 'Error';
            $data['title_menu'] = 'Error';
            $data['errorpages'] = 'Invalid ID!';
            //return error page
            return view("pages.errorpages", $data);
        }

        // Ambil data order item berdasarkan trordr_it_id
        $orderItem = DB::table('trs_orders_item as oi')
            ->join('mst_produk as p', 'oi.fk_pdrk_id', '=', 'p.pdrk_id')
            ->select('oi.*', 'p.pdrk_name', 'p.pdrk_price', 'p.pdrk_stock')
            ->where('oi.trordr_it_id', $id)
            ->where('oi.isactive', '1')
            ->first();

        if (!$orderItem) {
            //if order item not found
            $data['url_menu'] = 'error';
            $data['title_group'] = 'Error';
            $data['title_menu'] = 'Error';
            $data['errorpages'] = 'Order item tidak ditemukan!';
            //return error page
            return view("pages.errorpages", $data);
        }

        // Ambil data order dengan join customer berdasarkan fk_trordr_id
        $order = DB::table('trs_orders as o')
            ->join('mst_customer as c', 'o.fk_cust_id', '=', 'c.cust_id')
            ->select('o.*', 'c.cust_name', 'c.cust_email', 'c.cust_phone', 'c.cust_address')
            ->where('o.trordr_id', $orderItem->fk_trordr_id)
            ->where('o.isactive', '1')
            ->first();

        if (!$order) {
            //if order not found
            $data['url_menu'] = 'error';
            $data['title_group'] = 'Error';
            $data['title_menu'] = 'Error';
            $data['errorpages'] = 'Order tidak ditemukan!';
            //return error page
            return view("pages.errorpages", $data);
        }

        //check authorization access edit
        if ($data['authorize']->edit == '1') {
            // Set data untuk view
            $data['order'] = $order;
            $data['orderItem'] = $orderItem; // Item yang akan diedit

            // Log access
            $syslog->log_insert('V', $data['dmenu'], 'Edit Order Item: ' . $id, '1');

            // return page menu
            return view($data['url'], $data);
        } else {
            //if not authorize
            $data['url_menu'] = $data['url_menu'];
            $data['title_group'] = 'Error';
            $data['title_menu'] = 'Error';
            $data['errorpages'] = 'Not Authorized!';
            //insert log
            $syslog->log_insert('E', $data['url_menu'], 'Not Authorized!' . ' - Edit -' . $data['url_menu'], '0');
            //return error page
            return view("pages.errorpages", $data);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($data)
    {
        // function helper
        $syslog = new Function_Helper;

        try {
            DB::beginTransaction();

            // Validasi input dasar
            request()->validate([
                'trordr_it_id' => 'required|integer',
                'fk_pdrk_id' => 'required|exists:mst_produk,pdrk_id',
                'ordr_it_quantity' => 'required|integer|min:1',
                'ordr_it_price' => 'required|numeric|min:1',
                'ordr_it_subtotal' => 'required|numeric|min:1'
            ], [
                'required' => ':attribute tidak boleh kosong',
                'exists' => ':attribute tidak valid',
                'min' => ':attribute minimal :min',
                'numeric' => ':attribute harus berupa angka',
                'integer' => ':attribute harus berupa bilangan bulat'
            ]);

            //check decrypt
            try {
                $itemId = decrypt($data['idencrypt']);
            } catch (DecryptException $e) {
                throw new \Exception("Invalid item ID");
            }

            // Get existing order item data
            $existingItem = DB::table('trs_orders_item as oi')
                ->join('mst_produk as p', 'oi.fk_pdrk_id', '=', 'p.pdrk_id')
                ->select('oi.*', 'p.pdrk_name as old_product_name')
                ->where('oi.trordr_it_id', $itemId)
                ->where('oi.isactive', '1')
                ->first();

            if (!$existingItem) {
                throw new \Exception("Order item tidak ditemukan");
            }

            // Validasi produk baru
            $newProduct = DB::table('mst_produk')
                ->where('pdrk_id', request('fk_pdrk_id'))
                ->where('isactive', '1')
                ->first();

            if (!$newProduct) {
                throw new \Exception("Produk baru tidak ditemukan");
            }

            $oldQuantity = $existingItem->ordr_it_quantity;
            $newQuantity = request('ordr_it_quantity');
            $oldProductId = $existingItem->fk_pdrk_id;
            $newProductId = request('fk_pdrk_id');

            // Validasi stock
            if ($oldProductId == $newProductId) {
                // Produk sama, hitung stock tersedia (stock saat ini + quantity lama)
                $availableStock = $newProduct->pdrk_stock + $oldQuantity;
                if ($newQuantity > $availableStock) {
                    throw new \Exception("Stock produk {$newProduct->pdrk_name} tidak mencukupi. Stock tersedia: {$availableStock}, quantity diminta: {$newQuantity}");
                }
            } else {
                // Produk berbeda, cek stock produk baru
                if ($newQuantity > $newProduct->pdrk_stock) {
                    throw new \Exception("Stock produk {$newProduct->pdrk_name} tidak mencukupi. Stock tersedia: {$newProduct->pdrk_stock}, quantity diminta: {$newQuantity}");
                }
            }

            // Update order item
            DB::table('trs_orders_item')
                ->where('trordr_it_id', $itemId)
                ->update([
                    'fk_pdrk_id' => $newProductId,
                    'ordr_it_quantity' => $newQuantity,
                    'ordr_it_price' => request('ordr_it_price'),
                    'ordr_it_subtotal' => request('ordr_it_subtotal'),
                    'user_update' => session('username'),
                    'updated_at' => now()
                ]);

            // Update stock
            if ($oldProductId == $newProductId) {
                // Produk sama, hanya update quantity
                $quantityDiff = $newQuantity - $oldQuantity;
                if ($quantityDiff > 0) {
                    // Quantity bertambah, kurangi stock
                    DB::table('mst_produk')
                        ->where('pdrk_id', $newProductId)
                        ->decrement('pdrk_stock', $quantityDiff);
                } elseif ($quantityDiff < 0) {
                    // Quantity berkurang, tambah stock
                    DB::table('mst_produk')
                        ->where('pdrk_id', $newProductId)
                        ->increment('pdrk_stock', abs($quantityDiff));
                }
            } else {
                // Produk berbeda
                // Kembalikan stock produk lama
                DB::table('mst_produk')
                    ->where('pdrk_id', $oldProductId)
                    ->increment('pdrk_stock', $oldQuantity);

                // Kurangi stock produk baru
                DB::table('mst_produk')
                    ->where('pdrk_id', $newProductId)
                    ->decrement('pdrk_stock', $newQuantity);
            }

            // Hitung ulang total amount order
            $newTotalAmount = DB::table('trs_orders_item')
                ->where('fk_trordr_id', $existingItem->fk_trordr_id)
                ->where('isactive', '1')
                ->sum('ordr_it_subtotal');

            // Update total amount di order header
            DB::table('trs_orders')
                ->where('trordr_id', $existingItem->fk_trordr_id)
                ->update([
                    'ordr_total_amount' => $newTotalAmount,
                    'user_update' => session('username'),
                    'updated_at' => now()
                ]);

            DB::commit();

            // Log success
            $syslog->log_insert('U', $data['dmenu'], 'Updated Order Item: ' . $itemId . ' | Product: ' . $newProduct->pdrk_name . ' | Quantity: ' . $newQuantity . ' | New Total: ' . $newTotalAmount, '1');

            // Set success message
            Session::flash('message', 'Item order berhasil diupdate! Total order diupdate menjadi Rp ' . number_format($newTotalAmount, 0, ',', '.'));
            Session::flash('class', 'success');
            Session::flash('idtrans', $existingItem->fk_trordr_id);

            return redirect($data['url_menu']);
        } catch (\Exception $e) {
            DB::rollback();

            // Log error
            $syslog->log_insert('E', $data['dmenu'], 'Update Order Item Error: ' . $e->getMessage(), '0');

            // Set error message
            Session::flash('message', 'Error: ' . $e->getMessage());
            Session::flash('class', 'danger');

            return redirect()->back()->withInput();
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($data)
    {
        // function helper
        $syslog = new Function_Helper;

        try {
            DB::beginTransaction();

            //check decrypt
            try {
                $id = decrypt($data['idencrypt']);
            } catch (DecryptException $e) {
                throw new \Exception("Invalid ID!");
            }

            // Ambil data order item yang akan dihapus
            $orderItem = DB::table('trs_orders_item as oi')
                ->join('mst_produk as p', 'oi.fk_pdrk_id', '=', 'p.pdrk_id')
                ->select('oi.*', 'p.pdrk_name')
                ->where('oi.trordr_it_id', $id)
                ->where('oi.isactive', '1')
                ->first();

            if (!$orderItem) {
                throw new \Exception("Order item tidak ditemukan atau sudah dihapus!");
            }

            // Ambil data order header
            $order = DB::table('trs_orders')
                ->where('trordr_id', $orderItem->fk_trordr_id)
                ->where('isactive', '1')
                ->first();

            if (!$order) {
                throw new \Exception("Order tidak ditemukan!");
            }

            // Kembalikan stock produk
            DB::table('mst_produk')
                ->where('pdrk_id', $orderItem->fk_pdrk_id)
                ->increment('pdrk_stock', $orderItem->ordr_it_quantity);

            // Soft delete order item
            DB::table('trs_orders_item')
                ->where('trordr_it_id', $id)
                ->update([
                    'isactive' => '0',
                    'user_update' => session('username'),
                    'updated_at' => now()
                ]);

            // Hitung ulang total amount dari semua item yang masih aktif
            $remainingItems = DB::table('trs_orders_item')
                ->where('fk_trordr_id', $orderItem->fk_trordr_id)
                ->where('isactive', '1')
                ->get();

            $newTotalAmount = $remainingItems->sum('ordr_it_subtotal');

            // Update total amount di order header
            DB::table('trs_orders')
                ->where('trordr_id', $orderItem->fk_trordr_id)
                ->update([
                    'ordr_total_amount' => $newTotalAmount,
                    'user_update' => session('username'),
                    'updated_at' => now()
                ]);

            // Jika tidak ada item yang tersisa, soft delete order header juga
            if ($remainingItems->count() == 0) {
                DB::table('trs_orders')
                    ->where('trordr_id', $orderItem->fk_trordr_id)
                    ->update([
                        'isactive' => '0',
                        'user_update' => session('username'),
                        'updated_at' => now()
                    ]);

                $message = "Item order dan order header berhasil dihapus (tidak ada item tersisa)!";
            } else {
                $message = "Item order berhasil dihapus! Total amount diupdate menjadi Rp " . number_format($newTotalAmount, 0, ',', '.');
            }

            DB::commit();

            //insert sys_log
            $syslog->log_insert('D', $data['dmenu'], 'Deleted Order Item: ' . $id . ' | Product: ' . $orderItem->pdrk_name . ' | Quantity Returned: ' . $orderItem->ordr_it_quantity . ' | New Total: ' . $newTotalAmount, '1');

            // Set success message
            Session::flash('message', $message);
            Session::flash('class', 'success');
            Session::flash('idtrans', $orderItem->fk_trordr_id);

            return redirect($data['url_menu']);
        } catch (\Exception $e) {
            DB::rollback();

            //insert sys_log
            $syslog->log_insert('D', $data['dmenu'], 'Delete Order Item Error: ' . $e->getMessage(), '0');

            // Set error message
            Session::flash('message', 'Error: ' . $e->getMessage());
            Session::flash('class', 'danger');

            return redirect($data['url_menu']);
        }
    }
}
