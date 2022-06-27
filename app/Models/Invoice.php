<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{


    public $table = 'invoices';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'amount',
        'created_at',
        'updated_at',
        'deleted_at',
        'description'
        
    ];
  

    public function creator()
    {
        return $this->hasOne(\App\Models\User::class, 'id', 'creator_id');
    }






}
