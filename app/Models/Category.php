<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;




class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name','image','name_ar'];


    public function subcategories(): HasMany
    {
        return $this->hasMany(Subcategory::class);
    }

    public function users():BelongsToMany
    {
        return $this->belongsToMany(User::class, 'category_users');
    }

}
