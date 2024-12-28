<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AlquranSurah;
use App\Models\User;
use Illuminate\Http\Request;

class AlquranSurahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $apikeyheaders = $request->header('apikey');
        $userApiKey = User::where('apikey', $apikeyheaders)->first();
        $Alldata = AlquranSurah::all();
        $id = $request->input("id");
        User::where('apikey',$apikeyheaders)->decrement('saldo',intval(env('VITE_PAY_AMOUNT')));
        if(!$id)
        {
            return response()->json(['pesan'=>'sukses | masukkan nomor surah | [GET] contoh request : /api/alquran/surah?id=1',
            'status'=>200,
            'nama_apikey'=>$userApiKey->nama,
            'saldo'=>$userApiKey->saldo,
            'data'=>$Alldata], 200);
        } else {
            $findSurah = AlquranSurah::find($id);
            $apikeyheaders = $request->header('apikey');
            $userApiKey = User::where('apikey', $apikeyheaders)->first();
            if(!$findSurah) {
                return response()->json(['pesan'=>'gagal',
                'status'=>404,
                'nama_apikey'=>$userApiKey->nama,
                'data'=>'Data tidak ditemukan :('], 404);
            } else {
                User::where('apikey',$apikeyheaders)->decrement('saldo',intval(env('VITE_PAY_AMOUNT')));
                return response()->json(['pesan'=>'sukses',
                'status'=>200,
                'saldo'=>$userApiKey->saldo,
                'nama_apikey'=>$userApiKey->nama,
                'data'=>$findSurah], 200);
            }
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
