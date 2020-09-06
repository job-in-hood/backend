<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;

    protected $fillable = [
            'name','description', 'logo', 'email','website','industry_id'
        ];

    public function industry() {
        return $this->belongsTo(Industry::class);
    }
}
