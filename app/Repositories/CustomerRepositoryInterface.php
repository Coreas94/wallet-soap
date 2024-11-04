<?php

namespace App\Repositories;

interface CustomerRepositoryInterface
{
   public function create(array $data);
   public function findByDocumentAndPhone($document, $phone);
   public function updateBalance($customerId, $amount);
}
