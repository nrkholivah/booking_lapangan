<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LapanganModel;

class Lapangan extends BaseController
{
    protected $LapanganModel;

    public function __construct()
    {
        $this->LapanganModel = new LapanganModel();
        helper(['form', 'url', 'filesystem']);
    }

    public function index()
    {
        $data = [
            'title'  => 'Manajemen Lapangan',
            'fields' => $this->LapanganModel->findAll(),
        ];
        return view('admin/fields/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Lapangan Baru',
        ];
        return view('admin/fields/form', $data);
    }

    public function store()
    {
        $rules = [
            'name'           => 'required|min_length[3]|max_length[100]',
            'description'    => 'permit_empty|max_length[500]',
            'price_per_hour' => 'required|numeric|greater_than[0]',
            'image'          => 'if_exist|uploaded[image]|max_size[image,2048]|is_image[image]',
            'status'         => 'required|in_list[available,maintenance,unavailable]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $imageName = null;
        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && ! $file->hasMoved()) {
            $imageName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/fields', $imageName);
            $imageName = 'uploads/fields/' . $imageName; // Path relatif untuk database
        }

        $data = [
            'name'           => $this->request->getPost('name'),
            'description'    => $this->request->getPost('description'),
            'price_per_hour' => $this->request->getPost('price_per_hour'),
            'image'          => $imageName,
            'status'         => $this->request->getPost('status'),
        ];

        if ($this->LapanganModel->insert($data)) {
            return redirect()->to(base_url('admin/fields'))->with('success', 'Lapangan berhasil ditambahkan.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan lapangan.');
        }
    }

    public function edit($id = null)
    {
        $field = $this->LapanganModel->find($id);

        if (! $field) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Lapangan tidak ditemukan: ' . $id);
        }

        $data = [
            'title' => 'Edit Lapangan: ' . $field['name'],
            'field' => $field,
        ];
        return view('admin/fields/form', $data);
    }

    public function update($id = null)
    {
        $field = $this->LapanganModel->find($id);
        if (! $field) {
            return redirect()->back()->with('error', 'Lapangan tidak ditemukan.');
        }

        $rules = [
            'name'           => 'required|min_length[3]|max_length[100]',
            'description'    => 'permit_empty|max_length[500]',
            'price_per_hour' => 'required|numeric|greater_than[0]',
            'image'          => 'if_exist|uploaded[image]|max_size[image,2048]|is_image[image]',
            'status'         => 'required|in_list[available,maintenance,unavailable]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $imageName = $field['image']; // Ambil nama gambar lama
        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && ! $file->hasMoved()) {
            // Hapus gambar lama jika ada
            if ($imageName && file_exists(ROOTPATH . 'public/' . $imageName)) {
                unlink(ROOTPATH . 'public/' . $imageName);
            }
            $imageName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/fields', $imageName);
            $imageName = 'uploads/fields/' . $imageName;
        }

        $data = [
            'name'           => $this->request->getPost('name'),
            'description'    => $this->request->getPost('description'),
            'price_per_hour' => $this->request->getPost('price_per_hour'),
            'image'          => $imageName,
            'status'         => $this->request->getPost('status'),
        ];

        if ($this->LapanganModel->update($id, $data)) {
            return redirect()->to(base_url('admin/fields'))->with('success', 'Lapangan berhasil diperbarui.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui lapangan.');
        }
    }

    public function delete($id = null)
    {
        $field = $this->LapanganModel->find($id);
        if (! $field) {
            return redirect()->back()->with('error', 'Lapangan tidak ditemukan.');
        }

        // Hapus gambar terkait jika ada
        if ($field['image'] && file_exists(ROOTPATH . 'public/' . $field['image'])) {
            unlink(ROOTPATH . 'public/' . $field['image']);
        }

        if ($this->LapanganModel->delete($id)) {
            return redirect()->to(base_url('admin/fields'))->with('success', 'Lapangan berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus lapangan.');
        }
    }
}
