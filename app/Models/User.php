<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'region_id',
        'google_id'

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_users');
    }

    public function subcategories(): BelongsToMany
    {
        return $this->belongsToMany(Subcategory::class, 'subcategory_users');
    }

    public function regions(): BelongsToMany
    {
        return $this->belongsToMany(Region::class, 'user_regions');
    }

    public function events(): BelongsToMany
    {
        //return $this->belongsToMany(Event::class,'user_events')->withPivot('is_sent')->withTimestamps();
        return $this->belongsToMany(Event::class, 'user_events')
        ->withPivot('is_sent', 'send_by_whats')
        ->withTimestamps()
        ->where('user_events.is_sent', true);

    }

    public function whats_events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'user_events')
                    ->withPivot('is_sent', 'send_by_whats')
                    ->withTimestamps()
                    ->where('user_events.send_by_whats', true);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'user_services')
            ->withPivot('communication_channels')
            ->withTimestamps();
    }


    // public function subscription()
    // {
    //     return $this->hasOne(Subscription::class);
    // }
    public function supscriptions()
    {
        return $this->hasMany(Supscription::class);
    }

    public function plan()
    {
        return $this->hasOneThrough(Plan::class, Subscription::class, 'user_id', 'id', 'id', 'plan_id');
    }
    
    public function profile(){
        return $this->hasOne(Profile::class,'user_id');
    }
}
