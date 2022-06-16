<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\ServiceRequest;

class Complain extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_request_id',
        'message',
    ];

    public function client()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function serviceRequest()
    {
        return $this->belongsTo(ServiceRequest::class);
    }
}
