<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;
    protected $fillable = ['price', 'is_paid'];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function charges()
    {
        return $this->hasMany(Charge::class);
    }
}
