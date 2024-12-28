<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $katakunci = $request->katakunci;
        $jumlahbaris = 10;
        if (strlen($katakunci)) {
            $data = User::where('nama', 'like', "%$katakunci%")
                ->orWhere('nama', 'like', "%$katakunci%")->orWhere('email', 'like', "%$katakunci%")->paginate($jumlahbaris);
        } else {
            $data = User::orderBy('nama', 'desc')->paginate($jumlahbaris);
        }

        if(!json_decode(json_encode($data), true)['data']) {
            return redirect()->to('/admin')->withErrors('Data tidak ditemukan!');
        }

        return Inertia::render('Page/Admin', [
            'users' => $data,
            'title' => 'Admin',
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(string $id)
    {
        $listUser = User::find($id);
        return response()->json([
            'status'=>200,
            'UserDetails'=>$listUser
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(
            [
                'nama' => 'required',
                'nohp' => 'required',
                'email' => 'required',
            ],
            [
                'nama.required' => 'Nama wajib diisi',
                'nohp.required' => 'No HP wajib diisi',
                'email.required' => 'Email wajib diisi',
            ]
        );

        $data = [
            'nama' => $request->nama,
            'nohp' => $request->nohp,
            'email' => $request->email,
            'is_dewa'=> $request->is_dewa,
            'saldo'=> $request->saldo,
        ];

        if($request->verifikasi)
        {
            $data['email_verified_at'] = now();
        } else {
            $data['email_verified_at'] = null;
        }

        User::where('id', $id)->update($data);
        
        return response()->json([
            'status'=>200,
            'message'=>'User Berhasil Diupdate'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::where('id', $id)->delete();
        return response()->json([
            'status'=>200,
            'message'=>'User Berhasil Dihapus'
        ]);
    }
}
