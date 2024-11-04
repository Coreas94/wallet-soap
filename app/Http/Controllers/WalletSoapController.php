<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use App\Services\WalletService;
use App\Http\Requests\RegisterCustomerRequest;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\BalanceRequest;
use App\Http\Requests\RechargeWalletRequest;
use App\Http\Requests\MakePaymentRequest;
use App\Http\Requests\ConfirmPaymentRequest;

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

   public function recargaBilletera(RechargeWalletRequest $request)
   {
      $response = $this->walletService->rechargeWallet(
         $request->input('documento'),
         $request->input('celular'),
         $request->input('valor')
      );

      return response()->json($response);
   }

   public function pagar(MakePaymentRequest $request)
   {
      $response = $this->walletService->initiatePayment(
         $request->input('documento'),
         $request->input('celular'),
         $request->input('monto')
      );

      return response()->json($response);
   }

   public function confirmarPago(ConfirmPaymentRequest $request)
   {
      $response = $this->walletService->confirmPayment(
         $request->input('sessionId'),
         $request->input('token')
      );

      return response()->json($response);
   }

   public function consultarSaldo(BalanceRequest $request)
   {
      $response = $this->walletService->getBalance(
         $request->input('documento'),
         $request->input('celular')
      );

      return response()->json($response);
   }
}
