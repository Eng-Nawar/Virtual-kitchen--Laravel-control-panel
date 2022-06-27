<?php

namespace App\Models;

use Akaunting\Money\Currency;
use Akaunting\Money\Money;
use App\Models\TranslateAwareModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orderstatus extends TranslateAwareModel
{
    use SoftDeletes;

   
       //Table Name
   
       protected $table = 'order_has_status';
   
       //Primary Key
   
       public $primaryKey = 'id';
   
   
       //Timestamps
   
       public $timestamps =true;
   
   public function order(){         
       return $this->belongsTo('App\Models\Order');   
   
   }
   public function status(){
       return $this->hasMany('App\Models\Status');   
   
   }
   
   public function user(){         
    return $this->belongsTo('App\Models\User');   

}
   
   
   }