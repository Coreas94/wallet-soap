<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use App\Services\WalletService;
use App\Http\Requests\RegisterCustomerRequest;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class WalletSoapController extends Controller
{
   protected $walletService;

   public function __construct(WalletService $walletService)
   {
      $this->walletService = $walletService;
   }

   public function registroCliente(RegisterCustomerRequest $request)
   {
      $data = $request->validated();
      $response = $this->walletService->registerCustomer($data);

      return response()->json($response);
   }

   public function recargaBilletera(Request $request)
   {
      $documento = $request->input('documento');
      $celular = $request->input('celular');
      $valor = $request->input('valor');

      $response = $this->walletService->rechargeWallet($documento, $celular, $valor);

      return response()->json($response);
   }

   public function pagar(Request $request)
   {
      $documento = $request->input('documento');
      $celular = $request->input('celular');
      $monto = $request->input('monto');

      $response = $this->walletService->initiatePayment($documento, $celular, $monto);

      return response()->json($response);
   }

   public function confirmarPago(Request $request)
   {
      $sessionId = $request->input('sessionId');
      $token = $request->input('token');

      $response = $this->walletService->confirmPayment($sessionId, $token);

      return response()->json($response);
   }

   public function consultarSaldo(Request $request)
   {
      $documento = $request->input('documento');
      $celular = $request->input('celular');

      $response = $this->walletService->getBalance($documento, $celular);

      return response()->json($response);
   }
}
