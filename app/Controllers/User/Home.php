<?php
// app/Controllers/User/Home.php
// Controller untuk halaman utama user dan detail lapangan.

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\LapanganModel; // Changed from FieldModel

class Home extends BaseController
{
    protected $lapanganModel; // Changed from fieldModel

    public function __construct()
    {
        $this->lapanganModel = new LapanganModel(); // Changed from FieldModel
        helper(['form', 'url']);
    }

    public function index()
    {
        $data = [
            'title'  => 'Daftar Lapangan',
            'lapangans' => $this->lapanganModel->findAll(), // Changed from fields
        ];
        return view('user/home', $data);
    }

    public function detail($id = null)
    {
        $lapangan = $this->lapanganModel->find($id); // Changed from field

        if (! $lapangan) { // Changed from field
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Lapangan tidak ditemukan: ' . $id);
        }

        $data = [
            'title' => 'Detail Lapangan: ' . $lapangan['name'], // Changed from field
            'lapangan' => $lapangan, // Changed from field
        ];
        return view('user/lapangan_detail', $data); // Changed from field_detail
    }
}
