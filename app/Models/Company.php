<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Company extends Model
{
    use SoftDeletes, Notifiable;

    protected $fillable = [
            'name','description', 'logo', 'email','website','industry_id'
        ];

    protected $hidden = [
      'created_at', 'updated_at', 'deleted_at'
    ];

    public function industry() {
        return $this->belongsTo(Industry::class);
    }

    public function routeNotificationForSlack($notification)
    {
        return env('SLACK_NOTIFICATION_WEBHOOK');
    }
}
