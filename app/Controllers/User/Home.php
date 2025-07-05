<?php
// app/Controllers/User/Home.php
// Controller untuk halaman utama user dan detail lapangan.

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\LapanganModel;

class Home extends BaseController
{
    protected $LapanganModel;

    public function __construct()
    {
        $this->LapanganModel = new LapanganModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        $data = [
            'title'  => 'Daftar Lapangan',
            'fields' => $this->LapanganModel->findAll(),
        ];
        return view('user/home', $data);
    }

    public function detail($id = null)
    {
        $field = $this->LapanganModel->find($id);

        if (! $field) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Lapangan tidak ditemukan: ' . $id);
        }

        $data = [
            'title' => 'Detail Lapangan: ' . $field['name'],
            'field' => $field,
        ];
        return view('user/detail_lapangan', $data);
    }
}
