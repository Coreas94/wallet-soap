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

//Registrar cliente
Route::post('wallet/registro', [WalletSoapController::class, 'registroCliente']);

// Recarga de billetera
Route::post('wallet/recarga', [WalletSoapController::class, 'recargaBilletera']);

// Iniciar pago
Route::post('wallet/pagar', [WalletSoapController::class, 'pagar']);

// Confirmar pago
Route::post('wallet/confirmar', [WalletSoapController::class, 'confirmarPago']);

// Consultar saldo
Route::get('wallet/consultar', [WalletSoapController::class, 'consultarSaldo']);
