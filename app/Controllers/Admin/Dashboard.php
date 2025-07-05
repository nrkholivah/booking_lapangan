<?php
// app/Controllers/Admin/Dashboard.php
// Controller untuk dashboard admin.

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BookingModel;
use App\Models\LapanganModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    protected $bookingModel;
    protected $LapanganModel;
    protected $userModel;

    public function __construct()
    {
        $this->bookingModel = new BookingModel();
        $this->LapanganModel = new LapanganModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title'             => 'Dashboard Admin',
            'total_users'       => $this->userModel->countAllResults(),
            'total_fields'      => $this->LapanganModel->countAllResults(),
            'total_bookings'    => $this->bookingModel->countAllResults(),
            'pending_payments'  => $this->bookingModel->where('payment_status', 'paid')->countAllResults(),
            'recent_bookings'   => $this->bookingModel->orderBy('created_at', 'DESC')->limit(5)->getBookingDetails(),
        ];
        return view('admin/dashboard', $data);
    }
}
