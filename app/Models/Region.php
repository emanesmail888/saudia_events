<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Region extends Model
{
    use HasFactory;
    protected $table="regions";

    protected $fillable = [
        'code',
        'name_ar',
        'name_en'
    ];

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    public function events():HasMany
    {
        return $this->hasMany(Event::class);
    }

}
