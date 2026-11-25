<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use App\Models\ProductModel;
use App\Models\SaleModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $db = db_connect();
        $recentSales = $db->table('sales')
            ->select('sales.id, sales.quantity, sales.total_price, sales.created_at, products.name AS product_name, customers.full_name AS customer_name')
            ->join('products', 'products.id = sales.product_id')
            ->join('customers', 'customers.id = sales.customer_id', 'left')
            ->orderBy('sales.created_at', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();

        return view('dashboard', [
            'title' => 'Point of Sale',
            'productCount' => (new ProductModel())->countAllResults(),
            'customerCount' => (new CustomerModel())->countAllResults(),
            'staffCount' => (new UserModel())->countAllResults(),
            'salesCount' => (new SaleModel())->countAllResults(),
            'recentSales' => $recentSales,
        ]);
    }
}
