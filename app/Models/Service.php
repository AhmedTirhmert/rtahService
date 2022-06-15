<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\User;
use App\Models\feedback;
use App\Models\ServiceRequest;
class Service extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'product_id',
        'years',
    ];
    

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function request()
    {
        return $this->hasMany(ServiceRequest::class);
    }
    public function feedback()
    {
        return $this->hasMany(feedback::class);
    }

}
