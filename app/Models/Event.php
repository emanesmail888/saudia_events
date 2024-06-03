<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Event extends Model
{
    use HasFactory;
    protected $table="events";

    public function category():BelongsTo
    {
        return($this->belongsTo(Category::class,'category_id'));
    }

    public function subCategories():BelongsTo
    {
        return($this->belongsTo(Subcategory::class,'subcategory_id'));

    }

    public function region():BelongsTo
    {
        return ($this->belongsTo(Region::class,'region_id'));
    }
    
    public function city():BelongsTo
    {
        return ($this->belongsTo(City::class,'city_id'));
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
