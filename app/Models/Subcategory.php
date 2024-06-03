<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;



class Subcategory extends Model
{
    use HasFactory;
    protected $table="subcategories";
    protected $fillable = ['name','image','category_id'];



    public function category():BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function users():BelongsToMany
    {
        return $this->belongsToMany(User::class, 'subcategory_users');
    }
}
