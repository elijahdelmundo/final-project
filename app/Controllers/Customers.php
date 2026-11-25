<?php

namespace App\Controllers;

use App\Models\CustomerModel;

class Customers extends BaseController
{
    public function index()
    {
        return view('customers/index', [
            'title' => 'Customers',
            'customers' => (new CustomerModel())->orderBy('full_name')->findAll(),
        ]);
    }

    public function createForm()
    {
        return view('customers/form', ['title' => 'Add Customer', 'customer' => [], 'mode' => 'create']);
    }

    public function create()
    {
        $rules = [
            'full_name' => 'required|min_length[2]|max_length[100]',
            'email' => 'required|valid_email|max_length[100]|is_unique[customers.email]',
            'phone' => 'permit_empty|max_length[20]',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        (new CustomerModel())->insert($this->request->getPost(['full_name', 'email', 'phone']));
        return redirect()->to('/customers')->with('success', 'Customer created.');
    }

    public function edit(int $id)
    {
        $customer = (new CustomerModel())->find($id);
        if (! $customer) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Customer not found.');
        }
        return view('customers/form', ['title' => 'Edit Customer', 'customer' => $customer, 'mode' => 'edit']);
    }

    public function update(int $id)
    {
        $model = new CustomerModel();
        $customer = $model->find($id);
        if (! $customer) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Customer not found.');
        }

        $rules = [
            'full_name' => 'required|min_length[2]|max_length[100]',
            'email' => "required|valid_email|max_length[100]|is_unique[customers.email,id,{$id}]",
            'phone' => 'permit_empty|max_length[20]',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model->update($id, $this->request->getPost(['full_name', 'email', 'phone']));
        return redirect()->to('/customers')->with('success', 'Customer updated.');
    }

    public function delete(int $id)
    {
        if (! (new CustomerModel())->find($id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Customer not found.');
        }
        (new CustomerModel())->delete($id);
        return redirect()->to('/customers')->with('success', 'Customer deleted.');
    }
}
