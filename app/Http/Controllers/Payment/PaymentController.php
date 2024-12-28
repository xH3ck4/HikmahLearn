<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;

Config::$serverKey = config('midtrans.server_key');
Config::$clientKey = config('midtrans.client_key');
Config::$isProduction = config('midtrans.is_production');
Config::$isSanitized = true;
Config::$is3ds = true;

class PaymentController extends Controller
{
    public function TopupSaldo(Request $request)
    {

        $request->validate([
            'saldo' => 'required|numeric|min:100|max:1000000',
        ],[
            'saldo.required'=>'Harap isi angka saldo',
            'saldo.numeric'=>'Saldo harus berupa angka!',
            'saldo.min'=>'Isi saldo minimal 100p!',
            'saldo.max'=>'Isi saldo maximal 1jt!',
        ]);


        $saldoNominal = $request->post('saldo');
        $uniqCode = substr(Str::uuid()->toString(), 0, 30);

        $customer_details = array(
            'first_name' => Auth::user()->nama,
            'last_name'=>'',
            'email' => Auth::user()->email,
            'phone' => Auth::user()->nohp,
        );

        $expired = array(             
            'start_time' => date("Y-m-d H:i:s T"),
            'unit' => 'minutes',
            'duration' => 30,
        );

        $transaksi_params = array(
            'transaction_details' => array(
                'order_id' => $uniqCode,
                'gross_amount' => intval($saldoNominal),
            ),
            'customer_details' => $customer_details,
            'expiry' => $expired
        );

        try {
            $snapToken = Snap::getSnapToken($transaksi_params);
            Transaksi::create([
                'id'=>$uniqCode,
                'user_id'=>Auth::user()->id,
                'jumlah'=>$saldoNominal,
                'servis'=>'midtrans',
                'status'=>'pending',
                'description'=>'Midtrans - Rp. '.$saldoNominal,
                'snap_token'=>$snapToken,
            ]);
            return response()->json(['success'=> true,'message'=>'Berhasil membuat transaksi baru!','snap_token' => $snapToken]);
        } catch (Exception $e) {
            return response()->json(['success'=> false, 'error' => $e->getMessage()], 500);
        }
    }

    public function TopUpSaldoBatal(Request $request)
    {
        try{
    
            $order_id = $request->id;
            $cekTransaksi = Transaksi::where('id',$order_id)->first();
            if($cekTransaksi->status == 'pending')
            {
                $cancel = Transaction::cancel($order_id);
                if(strval($cancel) === '200')
                {
                    Transaksi::where('id',$order_id)->update(['status'=>'canceled']);
                    return response()->json(['success'=> true,'message'=>'Berhasil membatalkan transaksi!']);
                }
            } else {
                return response()->json(['success'=> false,'message'=>'Transaksi tidak dapat dibatalkan!'], 400);
            }
        } catch(Exception $e) {
            // return $e->getMessage();
            return response()->json(['Gagal membatalkan transaksi!'], 400);

        }
    }

}
