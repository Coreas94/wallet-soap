<?php

namespace App\Services;

use App\Repositories\CustomerRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\ConfirmacionPagoMail;

class WalletService
{
   protected $customerRepo;

   public function __construct(CustomerRepositoryInterface $customerRepo)
   {
      $this->customerRepo = $customerRepo;
   }

   public function registerCustomer(array $data)
   {
      $cliente = $this->customerRepo->create($data);

      $cliente->wallet()->create(['saldo' => 0]);

      return [
         'success' => true,
         'cod_error' => '00',
         'message_error' => 'Cliente y billetera registrados exitosamente',
         'data' => $cliente
      ];
   }

   public function rechargeWallet($documento, $celular, $valor)
   {
      $cliente = $this->customerRepo->findByDocumentAndPhone($documento, $celular);

      if (!$cliente) {
         return [
            'success' => false,
            'cod_error' => '02',
            'message_error' => 'Cliente no encontrado',
            'data' => null
         ];
      }

      $this->customerRepo->updateBalance($cliente->id, $valor);

      return [
         'success' => true,
         'cod_error' => '00',
         'message_error' => 'Recarga exitosa',
         'data' => ['saldo' => $cliente->wallet->saldo]
      ];
   }

   public function initiatePayment($documento, $celular, $monto)
   {
      $cliente = $this->customerRepo->findByDocumentAndPhone($documento, $celular);

      if (!$cliente) {
         return [
            'success' => false,
            'cod_error' => '02',
            'message_error' => 'Cliente no encontrado',
            'data' => null
         ];
      }

      if ($cliente->wallet->saldo < $monto) {
         return [
            'success' => false,
            'cod_error' => '03',
            'message_error' => 'Saldo insuficiente',
            'data' => null
         ];
      }
      
      $token = rand(100000, 999999);
      $sessionId = Str::uuid();

      Cache::put($sessionId, ['token' => $token, 'monto' => $monto, 'cliente_id' => $cliente->id], now()->addMinutes(10));

      Mail::to($cliente->email)->send(new ConfirmacionPagoMail($token));

      return [
         'success' => true,
         'cod_error' => '00',
         'message_error' => 'Token de confirmación enviado al email',
         'data' => ['session_id' => $sessionId]
      ];
   }

   public function confirmPayment($sessionId, $token)
   {
      $sessionData = Cache::get($sessionId);

      if (!$sessionData || $sessionData['token'] != $token) {
         return [
            'success' => false,
            'cod_error' => '04',
            'message_error' => 'Token de confirmación inválido',
            'data' => null
         ];
      }

      $cliente = $this->customerRepo->findById($sessionData['cliente_id']);
      $this->customerRepo->updateBalance($cliente->id, -$sessionData['monto']);

      Cache::forget($sessionId);

      return [
         'success' => true,
         'cod_error' => '00',
         'message_error' => 'Pago confirmado y saldo descontado',
         'data' => null
      ];
   }

   public function getBalance($documento, $celular)
   {
      $cliente = $this->customerRepo->findByDocumentAndPhone($documento, $celular);

      if (!$cliente) {
         return [
            'success' => false,
            'cod_error' => '02',
            'message_error' => 'Cliente no encontrado',
            'data' => null
         ];
      }

      return [
         'success' => true,
         'cod_error' => '00',
         'message_error' => 'Consulta de saldo exitosa',
         'data' => ['saldo' => $cliente->wallet->saldo]
      ];
   }
}
