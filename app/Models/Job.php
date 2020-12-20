<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Job extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = ['title', 'publish_start', 'publish_end', 'salary_min', 'salary_max', 'currency', 'description'];

    protected $hidden = [
//        'id', 'user_id',
//        'job_type_id', 'location_id',
//        'company_id', 'industry_id',
//        'salary_type_id', 'currency_id',
//        'created_at', 'updated_at', 'deleted_at'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function industry() {
        return $this->belongsTo(Industry::class);
    }

    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function jobType() {
        return $this->belongsTo(JobType::class);
    }

    public function salaryType() {
        return $this->belongsTo(SalaryType::class);
    }

    public function location() {
        return $this->belongsTo(Location::class);
    }

    public function currency() {
        return $this->belongsTo(Currency::class);
    }

    public function routeNotificationForSlack($notification)
    {
        return env('SLACK_NOTIFICATION_WEBHOOK');
    }
}
