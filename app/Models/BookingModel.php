<?php
// app/Models/BookingModel.php
// Model untuk tabel 'bookings'.

namespace App\Models;

use CodeIgniter\Model;

class BookingModel extends Model
{
    protected $table            = 'bookings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'lapangan_id',
        'booking_date',
        'start_time',
        'end_time',
        'total_price',
        'payment_status',
        'booking_status',
        'payment_proof',
        'admin_notes'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'user_id'        => 'required|integer',
        'lapangan_id'        => 'required|integer',
        'booking_date'   => 'required|valid_date',
        'start_time'     => 'required', // Format HH:MM:SS
        'end_time'       => 'required', // Format HH:MM:SS
        'total_price'    => 'required|numeric|greater_than[0]',
        'payment_status' => 'in_list[pending,paid,approved,rejected]',
        'booking_status' => 'in_list[pending,approved,rejected,completed,cancelled]',
        'payment_proof'  => 'permit_empty|max_length[255]',
        'admin_notes'    => 'permit_empty|max_length[500]',
    ];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $cleanValidationRules = true;

    /**
     * Mendapatkan detail booking dengan informasi user dan lapangan.
     *
     * @param int|null $id
     * @return array|null
     */
    public function getBookingDetails($id = null)
    {
        $this->select('bookings.*, users.username, users.email, lapangan.name as lapangan_name, lapangan.price_per_hour');
        $this->join('users', 'users.id = bookings.user_id');
        $this->join('lapangan', 'lapangan.id = bookings.lapangan_id');

        if ($id) {
            return $this->find($id);
        }

        return $this->findAll();
    }

    /**
     * Mengecek ketersediaan lapangan pada waktu tertentu.
     *
     * @param int $lapanganId
     * @param string $bookingDate (Y-m-d)
     * @param string $startTime (H:i:s)
     * @param string $endTime (H:i:s)
     * @param int|null $excludeBookingId (untuk edit booking)
     * @return bool
     */
    public function isLapanganAvailable(int $lapanganId, string $bookingDate, string $startTime, string $endTime, ?int $excludeBookingId = null): bool
    {
        $query = $this->where('lapangan_id', $lapanganId)
            ->where('booking_date', $bookingDate)
            ->where('booking_status !=', 'cancelled') // Jangan cek booking yang dibatalkan
            ->groupStart()
            ->where('start_time <', $endTime)
            ->where('end_time >', $startTime)
            ->groupEnd();

        if ($excludeBookingId) {
            $query->where('id !=', $excludeBookingId);
        }

        return $query->countAllResults() === 0;
    }
}
