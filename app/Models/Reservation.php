<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
            'renter_name', 'renter_last_name', 'email_address', 'phone_number',
            'reservation_start_date', 'reservation_end_date', 'delivery_address', 'bill_id' , 'vessel_id'
        ];

    public function bill()
    {
        return $this->hasOne(Bill::class);
    }

    public function vessel()
    {
        return $this->belongsTo(Vessel::class);
    }

    public function addOns()
    {
        return $this->belongsToMany(AddOn::class, 'addon_reservation')
            ->withPivot('start_date', 'end_date')
            ->withTimestamps();
    }
}
