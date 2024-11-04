<?php

namespace App\Models;

use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
   use HasFactory;

   protected $table = 'customer';

   protected $fillable = ['documento', 'nombres', 'email', 'celular'];


   public function wallet()
   {
      return $this->hasOne(Wallet::class, 'cliente_id');
   }
}
