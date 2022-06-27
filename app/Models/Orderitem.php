<?php

namespace App\Models;

use Akaunting\Money\Currency;
use Akaunting\Money\Money;
use App\Models\TranslateAwareModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orderitem extends TranslateAwareModel
{
    use SoftDeletes;

   
       //Table Name
   
       protected $table = 'order_has_items';
   
       //Primary Key
   
       public $primaryKey = 'id';
   
   
       //Timestamps
   
       public $timestamps =true;
   
   public function order(){         
       return $this->belongsTo('App\Models\Order');   
   
   }
   public function item(){
       return $this->hasMany('App\Models\Items');   
   
   }
   
   
   
   }