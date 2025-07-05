<?php
// app/Controllers/Admin/Reports.php
// Controller untuk laporan dan grafik oleh admin.

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BookingModel;
use App\Models\LapanganModel;

class Reports extends BaseController
{
    protected $bookingModel;
    protected $LapanganModel;

    public function __construct()
    {
        $this->bookingModel = new BookingModel();
        $this->LapanganModel = new LapanganModel();
    }

    public function index()
    {
        // Data untuk grafik penggunaan lapangan
        $fieldUsageData = $this->bookingModel
            ->select('fields.name as field_name, COUNT(bookings.id) as total_bookings')
            ->join('fields', 'fields.id = bookings.field_id')
            ->groupBy('fields.name')
            ->findAll();

        $fieldNames = [];
        $bookingCounts = [];
        foreach ($fieldUsageData as $data) {
            $fieldNames[] = $data['field_name'];
            $bookingCounts[] = $data['total_bookings'];
        }

        // Data untuk laporan daftar booking (contoh sederhana)
        $allBookings = $this->bookingModel->getBookingDetails();

        $data = [
            'title'         => 'Laporan & Grafik',
            'field_names'   => json_encode($fieldNames), // Untuk Chart.js
            'booking_counts' => json_encode($bookingCounts), // Untuk Chart.js
            'all_bookings'  => $allBookings,
        ];
        return view('admin/reports/index', $data);
    }
}
