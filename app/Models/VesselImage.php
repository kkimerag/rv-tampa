<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VesselImage extends Model
{
    use HasFactory;

    protected $fillable = ['vessel_id', 'image_path', /* other fields */];

    // Define the relationship to the Vessel model
    public function vessel()
    {
        return $this->belongsTo(Vessel::class);
    }
}
