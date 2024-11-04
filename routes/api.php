<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WalletSoapController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|e
*/

Route::prefix('wallet')->controller(WalletSoapController::class)->group(function () {
   Route::post('registro', 'registroCliente');      // Registrar cliente
   Route::post('recarga', 'recargaBilletera');      // Recarga de billetera
   Route::post('pagar', 'pagar');                   // Iniciar pago
   Route::post('confirmar', 'confirmarPago');       // Confirmar pago
   Route::get('consultar', 'consultarSaldo');       // Consultar saldo
});
