<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Midtrans\Transaction;

class CallbackController extends Controller
{
    public function callbackPay(Request $request)
    {
    
            $serverKey = config('midtrans.server_key');
            $hashedKey = hash('sha512', $request->post('order_id') . $request->post('status_code') . $request->post('gross_amount') . $serverKey);
    
            if ($hashedKey !== $request->post('signature_key')) {
                return response()->json(['message' => 'Signature key tidak dikenal!'], 403);
            }
            
            $transactionStatus = $request->post('transaction_status');
            $orderId = $request->post('order_id');
            $order = Transaksi::where('id',$orderId)->first();
    
            if (!$order) {
                return response()->json(['message' => 'Order tidak ditemukan!'], 404);
            }

            switch ($transactionStatus) {
                case 'capture':
                    if ($request->post('payment_type') === 'credit_card') {
                        if ($request->post('fraud_status') == 'challenge') {
                            $order->update(['status' => 'pending']);
                        } else {
                            // TAMBAH SALDO (TRANSAKSI SUKSES)
                            User::find($order['user_id'])->increment('saldo', intval($order['jumlah']));
                            $order->update(['status' => 'success']);
                        }
                    }
                    break;
                case 'settlement':
                    // TAMBAH SALDO (TRANSAKSI SUKSES)
                    User::find($order['user_id'])->increment('saldo', intval($order['jumlah']));
                    $order->update(['status' => 'success']);
                    break;
                case 'pending':
                    $order->update(['status' => 'pending']);
                    break;
                case 'deny':
                    $order->update(['status' => 'failed']);
                    break;
                case 'expire':
                    $order->update(['status' => 'expired']);
                    break;
                case 'cancel':
                    $order->update(['status' => 'canceled']);
                    break;
                default:
                    $order->update(['status' => 'unknown']);
                    break;
            }
    
            return response()->json(['message' => 'Callback sukses diterima!']);

        }
}
