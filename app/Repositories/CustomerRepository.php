<?php

namespace App\Repositories;

use App\Models\Customer;

class CustomerRepository implements CustomerRepositoryInterface
{
   public function create(array $data)
   {
      return Customer::create($data);
   }

   public function findByDocumentAndPhone($document, $phone)
   {
      return Customer::where('documento', $document)->where('celular', $phone)->first();
   }

   public function updateBalance($customerId, $amount)
   {
      $customer = Customer::find($customerId);

      if (!$customer || !$customer->wallet) {
         return false;
      }

      $customer->wallet->saldo += $amount;
      $customer->wallet->save();

      return true;
   }

   public function findById($id)
   {
      return Customer::find($id);
   }
}
