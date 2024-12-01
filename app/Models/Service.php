<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Service extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'service_type','image','price','details'];


    public function users():BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_services')
            ->withPivot('communication_channels')->withTimestamps();
    }
    
  

    public function isFreePlan()
    {
        return $this->service_type === 'free';
    }

    public function isPremiumPlan()
    {
        return $this->service_type === 'premium';
    }

    
}
