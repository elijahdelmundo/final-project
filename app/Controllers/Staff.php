<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\HTTP\Files\UploadedFile;

class Staff extends BaseController
{
    public function index()
    {
        return view('staff/index', [
            'title' => 'Staff',
            'staff' => (new UserModel())->orderBy('full_name')->findAll(),
        ]);
    }

    public function createForm()
    {
        return view('staff/form', ['title' => 'Add Staff', 'staffMember' => [], 'mode' => 'create']);
    }

    public function create()
    {
        $rules = [
            'username' => 'required|alpha_numeric_punct|min_length[3]|max_length[50]|is_unique[users.username]',
            'full_name' => 'required|min_length[2]|max_length[100]',
            'password' => 'required|min_length[8]|max_length[255]',
        ];
        $avatar = $this->request->getFile('avatar');
        if ($avatar && $avatar->getError() !== UPLOAD_ERR_NO_FILE) {
            $rules['avatar'] = 'uploaded[avatar]|is_image[avatar]|max_size[avatar,2048]|mime_in[avatar,image/jpg,image/jpeg,image/png,image/webp]';
        }
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->request->getPost(['username', 'full_name']);
        $data['password'] = password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT);
        if ($avatar && $avatar->isValid() && ! $avatar->hasMoved()) {
            $data['avatar'] = $this->storeAvatar($avatar);
        }
        (new UserModel())->insert($data);
        return redirect()->to('/staff')->with('success', 'Staff account created.');
    }

    public function edit(int $id)
    {
        $staffMember = (new UserModel())->find($id);
        if (! $staffMember) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Staff member not found.');
        }
        return view('staff/form', ['title' => 'Edit Staff', 'staffMember' => $staffMember, 'mode' => 'edit']);
    }

    public function update(int $id)
    {
        $model = new UserModel();
        $staffMember = $model->find($id);
        if (! $staffMember) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Staff member not found.');
        }

        $rules = [
            'username' => "required|alpha_numeric_punct|min_length[3]|max_length[50]|is_unique[users.username,id,{$id}]",
            'full_name' => 'required|min_length[2]|max_length[100]',
            'password' => 'permit_empty|min_length[8]|max_length[255]',
        ];
        $avatar = $this->request->getFile('avatar');
        if ($avatar && $avatar->getError() !== UPLOAD_ERR_NO_FILE) {
            $rules['avatar'] = 'uploaded[avatar]|is_image[avatar]|max_size[avatar,2048]|mime_in[avatar,image/jpg,image/jpeg,image/png,image/webp]';
        }
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->request->getPost(['username', 'full_name']);
        $password = (string) $this->request->getPost('password');
        if ($password !== '') {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }
        if ($avatar && $avatar->isValid() && ! $avatar->hasMoved()) {
            $data['avatar'] = $this->storeAvatar($avatar);
        }
        $model->update($id, $data);
        if (isset($data['avatar']) && $staffMember['avatar']) {
            $this->removeAvatar($staffMember['avatar']);
        }
        return redirect()->to('/staff')->with('success', 'Staff account updated.');
    }

    public function delete(int $id)
    {
        if ((int) session()->get('user_id') === $id) {
            return redirect()->to('/staff')->with('error', 'You cannot delete the account currently signed in.');
        }

        $model = new UserModel();
        $staffMember = $model->find($id);
        if (! $staffMember) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Staff member not found.');
        }
        if (db_connect()->table('sales')->where('sold_by', $id)->countAllResults() > 0) {
            return redirect()->to('/staff')->with('error', 'Staff accounts with sales history cannot be deleted.');
        }

        $model->delete($id);
        if ($staffMember['avatar']) {
            $this->removeAvatar($staffMember['avatar']);
        }
        return redirect()->to('/staff')->with('success', 'Staff account deleted.');
    }

    private function storeAvatar(UploadedFile $avatar): string
    {
        $directory = WRITEPATH . 'uploads' . DIRECTORY_SEPARATOR . 'avatars';
        if (! is_dir($directory) && ! mkdir($directory, 0750, true) && ! is_dir($directory)) {
            throw new \RuntimeException('Unable to prepare avatar storage.');
        }
        $name = $avatar->getRandomName();
        $avatar->move($directory, $name);
        return $name;
    }

    private function removeAvatar(string $name): void
    {
        $path = WRITEPATH . 'uploads' . DIRECTORY_SEPARATOR . 'avatars' . DIRECTORY_SEPARATOR . basename($name);
        if (is_file($path) && ! unlink($path)) {
            log_message('warning', 'Unable to remove old uploaded avatar: {path}', ['path' => $path]);
        }
    }
}
