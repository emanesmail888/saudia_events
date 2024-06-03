<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;



class City extends Model
{
    use HasFactory;
    protected $table="cities";
    protected $fillable = [
        'region_id',
        'name_ar',
        'name_en'
    ];

    public function region():BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

}
