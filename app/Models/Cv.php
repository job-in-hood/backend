<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cv extends Model
{
    use UsesUuid, HasFactory;

    protected $fillable = ['original_name', 'storage_path', 'extension'];

    protected $hidden = ['storage_path'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
