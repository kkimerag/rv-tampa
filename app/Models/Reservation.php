<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'renter_name', 'renter_last_name', 'reservation_start_date', 'reservation_end_date', 'delivery_address', 'bill_id'
    ];

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }
}
