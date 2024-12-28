<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AlquranAyatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $apikeyheaders = $request->header('apikey');
        $userApiKey = User::where('apikey', $apikeyheaders)->first();
        $allAyat = json_decode(file_get_contents("jsonAPI/alquran_ayat.json"), true);
        User::where('apikey',$apikeyheaders)->decrement('saldo',intval(env('VITE_PAY_AMOUNT')));
        $id = $request->input("id");
        if(!$id)
        {
            return response()->json(['pesan'=>'sukses | masukkan nomor surah untuk menampilkan ayat | [GET] contoh request : /api/alquran/ayat?id=1',
            'status'=>200,
            'nama_apikey'=>$userApiKey->nama,
            'saldo'=>$userApiKey->saldo,
            'data'=>$allAyat], 200);
        } else {
            if($id >= 1 && $id <= 114) {
                User::where('apikey',$apikeyheaders)->decrement('saldo',intval(env('VITE_PAY_AMOUNT')));
                return response()->json(['pesan'=>'sukses',
                'status'=>200,
                'nama_apikey'=>$userApiKey->nama,
                'saldo'=>$userApiKey->saldo,
                'data'=>$allAyat[$id-1]], 200);
            } else {
                return response()->json(['pesan'=>'gagal',
                'status'=>404,
                'nama_apikey'=>$userApiKey->nama,
                'data'=>'Data tidak ditemukan :('], 404);
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
