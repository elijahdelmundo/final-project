<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use App\Models\ProductModel;
use App\Models\SaleModel;

class Sales extends BaseController
{
    public function index()
    {
        $sales = db_connect()->table('sales')
            ->select('sales.id, sales.quantity, sales.total_price, sales.created_at, products.name AS product_name, customers.full_name AS customer_name, users.full_name AS staff_name')
            ->join('products', 'products.id = sales.product_id')
            ->join('customers', 'customers.id = sales.customer_id', 'left')
            ->join('users', 'users.id = sales.sold_by')
            ->orderBy('sales.created_at', 'DESC')
            ->get()
            ->getResultArray();

        return view('sales/index', ['title' => 'Sales History', 'sales' => $sales]);
    }

    public function new()
    {
        return view('sales/form', [
            'title' => 'Record Sale',
            'products' => (new ProductModel())->where('stock_quantity >', 0)->orderBy('name')->findAll(),
            'customers' => (new CustomerModel())->orderBy('full_name')->findAll(),
        ]);
    }

    public function create()
    {
        $rules = [
            'product_id' => 'required|is_natural_no_zero',
            'customer_id' => 'permit_empty|is_natural_no_zero',
            'quantity' => 'required|is_natural_no_zero|less_than_equal_to[1000000]',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $productId = (int) $this->request->getPost('product_id');
        $customerValue = $this->request->getPost('customer_id');
        $customerId = $customerValue === '' || $customerValue === null ? null : (int) $customerValue;
        $quantity = (int) $this->request->getPost('quantity');
        $db = db_connect();
        $product = (new ProductModel())->find($productId);
        if (! $product) {
            return redirect()->back()->withInput()->with('error', 'Please select a valid product.');
        }
        if ($customerId !== null && ! (new CustomerModel())->find($customerId)) {
            return redirect()->back()->withInput()->with('error', 'Please select a valid customer or leave the field blank.');
        }
        if ($quantity > (int) $product['stock_quantity']) {
            return redirect()->back()->withInput()->with('error', 'Not enough stock. Available quantity: ' . $product['stock_quantity'] . '.');
        }

        $priceParts = explode('.', (string) $product['price'], 2);
        $cents = ((int) $priceParts[0] * 100) + (int) str_pad(substr($priceParts[1] ?? '0', 0, 2), 2, '0');
        $totalCents = $cents * $quantity;
        $totalPrice = intdiv($totalCents, 100) . '.' . str_pad((string) ($totalCents % 100), 2, '0', STR_PAD_LEFT);

        $db->transBegin();
        $db->table('products')
            ->set('stock_quantity', 'stock_quantity - ' . $quantity, false)
            ->where('id', $productId)
            ->where('stock_quantity >=', $quantity)
            ->update();

        if ($db->affectedRows() !== 1) {
            $db->transRollback();
            $current = (new ProductModel())->find($productId);
            return redirect()->back()->withInput()->with('error', 'Sale rejected. Available stock is now ' . ($current['stock_quantity'] ?? 0) . '.');
        }

        (new SaleModel())->insert([
            'product_id' => $productId,
            'customer_id' => $customerId,
            'sold_by' => (int) session()->get('user_id'),
            'quantity' => $quantity,
            'total_price' => $totalPrice,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        if (! $db->transStatus()) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', 'The sale could not be saved. No stock was changed.');
        }
        $db->transCommit();

        return redirect()->to('/sales')->with('success', 'Sale recorded. Inventory has been updated.');
    }
}
