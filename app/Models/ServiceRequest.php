<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Service;
use App\Models\feedback;
use App\Models\Complain;

class ServiceRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'service_id',
        'user_id',
        'pending',
        'accepted',
    ];


    public function service(){
        return $this->belongsTo(Service::class);
    }
    public function client(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function feedback()
    {
        return $this->hasMany(feedback::class);
    }
    public function complain()
    {
        return $this->hasMany(Complain::class);
    }

    
}
