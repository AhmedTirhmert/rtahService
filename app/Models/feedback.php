<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Service;
use App\Models\User;
use App\Models\ServiceRequest;

class feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_id',
        'service_request_id',
        'message',
        'rating',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function serviceRequest()
    {
        return $this->belongsTo(ServiceRequest::class);
    }
}
