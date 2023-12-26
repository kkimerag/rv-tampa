<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddOn extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'description', 'daily_price'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reservations()
    {
        return $this->belongsToMany(Reservation::class, 'addon_reservation')
            ->withPivot('start_date', 'end_date')
            ->withTimestamps();
    }
}