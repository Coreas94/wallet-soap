<?php

namespace App\Models;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
   use HasFactory;

   protected $table = 'wallet';
   protected $fillable = ['cliente_id', 'saldo'];


   public function customer()
   {
      return $this->belongsTo(Customer::class, 'cliente_id');
   }
}
