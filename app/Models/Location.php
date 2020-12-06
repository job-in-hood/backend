<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'display_name', 'latitude', 'longitude'];

    public function locationType() {
        return $this->belongsTo(LocationType::class);
    }

}
