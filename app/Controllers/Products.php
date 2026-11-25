<?php

namespace App\Controllers;

use App\Models\ProductModel;
use CodeIgniter\HTTP\Files\UploadedFile;

class Products extends BaseController
{
    public function index()
    {
        return view('products/index', [
            'title' => 'Products',
            'products' => (new ProductModel())->orderBy('name')->findAll(),
        ]);
    }

    public function createForm()
    {
        return view('products/form', ['title' => 'Add Product', 'product' => [], 'mode' => 'create']);
    }

    public function create()
    {
        $rules = [
            'name' => 'required|min_length[2]|max_length[100]',
            'price' => 'required|decimal|greater_than[0]',
            'stock_quantity' => 'required|integer|greater_than_equal_to[0]',
        ];
        $image = $this->request->getFile('image');
        if ($image && $image->getError() !== UPLOAD_ERR_NO_FILE) {
            $rules['image'] = 'uploaded[image]|is_image[image]|max_size[image,2048]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]';
        }
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->request->getPost(['name', 'price', 'stock_quantity']);
        if ($image && $image->isValid() && ! $image->hasMoved()) {
            $data['image'] = $this->storeImage($image, 'products');
        }
        (new ProductModel())->insert($data);

        return redirect()->to('/products')->with('success', 'Product added to inventory.');
    }

    public function edit(int $id)
    {
        $product = (new ProductModel())->find($id);
        if (! $product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Product not found.');
        }
        return view('products/form', ['title' => 'Edit Product', 'product' => $product, 'mode' => 'edit']);
    }

    public function update(int $id)
    {
        $model = new ProductModel();
        $product = $model->find($id);
        if (! $product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Product not found.');
        }

        $rules = [
            'name' => 'required|min_length[2]|max_length[100]',
            'price' => 'required|decimal|greater_than[0]',
            'stock_quantity' => 'required|integer|greater_than_equal_to[0]',
        ];
        $image = $this->request->getFile('image');
        if ($image && $image->getError() !== UPLOAD_ERR_NO_FILE) {
            $rules['image'] = 'uploaded[image]|is_image[image]|max_size[image,2048]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]';
        }
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->request->getPost(['name', 'price', 'stock_quantity']);
        if ($image && $image->isValid() && ! $image->hasMoved()) {
            $data['image'] = $this->storeImage($image, 'products');
        }
        $model->update($id, $data);
        if (isset($data['image']) && $product['image']) {
            $this->removeImage('products', $product['image']);
        }

        return redirect()->to('/products')->with('success', 'Product details updated.');
    }

    public function delete(int $id)
    {
        $model = new ProductModel();
        $product = $model->find($id);
        if (! $product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Product not found.');
        }
        if (db_connect()->table('sales')->where('product_id', $id)->countAllResults() > 0) {
            return redirect()->to('/products')->with('error', 'Products with sales history cannot be deleted.');
        }

        $model->delete($id);
        if ($product['image']) {
            $this->removeImage('products', $product['image']);
        }
        return redirect()->to('/products')->with('success', 'Product deleted.');
    }

    private function storeImage(UploadedFile $image, string $type): string
    {
        $directory = WRITEPATH . 'uploads' . DIRECTORY_SEPARATOR . $type;
        if (! is_dir($directory) && ! mkdir($directory, 0750, true) && ! is_dir($directory)) {
            throw new \RuntimeException('Unable to prepare product image storage.');
        }
        $name = $image->getRandomName();
        $image->move($directory, $name);
        return $name;
    }

    private function removeImage(string $type, string $name): void
    {
        $path = WRITEPATH . 'uploads' . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR . basename($name);
        if (is_file($path) && ! unlink($path)) {
            log_message('warning', 'Unable to remove old uploaded image: {path}', ['path' => $path]);
        }
    }
}
