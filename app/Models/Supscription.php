<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supscription extends Model
{
    use HasFactory;
    protected $table="supscriptions";

    protected $fillable = [
        'user_id','service_id','starts_at','ends_at','total','amount','subscription_id','checkout_id',
        'payment_status','paymentType','currency','descriptor','code','description','clearingInstituteName',
        'bin','lastDigits','holder','expiryMonth','expiryYear','bank','type','level','country','maxPanLength','binType','regulatedFlag','ip','ipCountry','value','eci','SHOPPER_EndToEndIdentity',
        'CTPE_DESCRIPTOR_TEMPLATE','score','buildNumber','timestamp','ndc','data','trackable_data','brand',
        'status'];
      

   

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

   
}