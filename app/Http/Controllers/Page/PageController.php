<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\LogsUpdate;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Scriptotek\GoogleBooks\GoogleBooks;



function paginateArray($array, $page = 1, $perPage = 10) {
    // Hitung total item
    $totalItems = count($array);

    // Hitung offset (mulai dari indeks array)
    $offset = ($page - 1) * $perPage;

    // Ambil item sesuai halaman
    $pagedData = array_slice($array, $offset, $perPage);

    // Buat informasi pagination
    $pagination = [
        'current_page' => $page,
        'per_page' => $perPage,
        'total_items' => $totalItems,
        'total_pages' => ceil($totalItems / $perPage),
        'data' => $pagedData
    ];

    return $pagination;
}



class PageController extends Controller
{
    public function dashboard(Request $request)
    {
        $total_users = count(User::all());
        return Inertia::render('Page/Dashboard', [
            'title' => 'Dashboard',
            'totalUsers' => $total_users,
        ]);
    }

    public function docs(Request $request)
    {
        $apikey_user = Auth::user()->apikey;
        $apiLists = json_decode(file_get_contents('jsonAPI/docs.json'), true);
        return Inertia::render('Page/Docs', [
            'title' => 'Dokumentasi',
            'apiLists'=>$apiLists,
            'userApiKey' => $apikey_user
        ]);
    }

    public function logs(Request $request)
    {
        $logs = LogsUpdate::paginate(6);
        return Inertia::render('Page/Logs', [
            'title' => 'Logs Update',
            'logs' => $logs
        ]);
    }

    public function profile(Request $request)
    {
        return Inertia::render('Page/Profile', [
            'title' => 'Profile',
        ]);
    }
    
    public function profile_api(Request $request)
    {
        try{
            $user = auth()->user();
            unset($user->id);
            unset($user->is_dewa);
            unset($user->tgl_pembuatan);
            unset($user->email_verified_at);
            return response()->json([
                'data' => $user,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to get profile',
            ], 500);
        }
    }

    public function update_profile_api(Request $request)
    {
        $user = Auth::user();
        $validatedData = $request->validate([
            'nama' => ['required','regex:/^[A-Za-z\s]*$/','string','max:100'],
            'nohp' => ['required','regex:/^(\+62|62|0)8[1-9][0-9]{6,10}$/','string','min:9','max:14','unique:users,nohp,' . $user->id],
            'email' => 'required|string|email|max:100|unique:users,email,' . $user->id,
            // 'g-recaptcha-response' => 'required|captcha',
            'apikey' => 'required|min:32|max:32|string|unique:users,apikey,' . $user->id,
            'wlip'=> ['nullable','max:255','regex:/((25[0-5]|2[0-4]\d|[01]?\d\d?)\.(25[0-5]|2[0-4]\d|[01]?\d\d?)\.(25[0-5]|2[0-4]\d|[01]?\d\d?)\.(25[0-5]|2[0-4]\d|[01]?\d\d?)(,|,?$))/']

        ], [
            'nama.required' => 'Harap isi nama terlebih dahulu!',
            'nama.regex'=>'Nama hanya boleh huruf!',
            'nama.max' => 'Harap masukkan maximal 100 karakter!',
            'nohp.unique' => 'Mohon maaf No.HP telah terdaftar sebelumnya!',
            'nohp.min' => 'No HP minimal 10 angka!',
            'nohp.max' => 'No HP maximal 13 angka!',
            'nohp.regex' => 'Format No HP salah! [0878xxxxxxxx]',
            'email.required' => 'Harap mengisi email terlebih dahulu!',
            'email.email' => 'Email tidak valid!!',
            'email.unique' => 'Email sudah pernah terdaftar!',
            'email.max' => 'Harap masukkan maximal 100 karakter',
            // 'g-recaptcha-response.required' => 'Mohon untuk menyelesaikan captcha terlebih dahulu!',
            'apikey.min' => 'Harap masukkan minimamal 32',
            'apikey.max' => 'Harap masukkan maximal 32',
            'apikey.unique' => 'Error, API key sudah pernah terdaftar!',
            'wlip.regex' => 'Format IP salah!',
            'wlip.max' => 'IP terlalu banyak, max 255 karakter!'
        ]);

        if(!$validatedData) {
            return response()->json([
                'message' => 'Failed to update profile',
                'error' => $validatedData,
            ], 500);
        }

        $user->update([
            'nama' => $request->nama,
            'nohp' => $request->nohp,
            'email' => $request->email,
            'apikey' => $request->apikey,
            'wlip' => $request->wlip
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Profile berhasil diupdate!',
        ]);
    }

    public function saldo(Request $request) 
    {
        $user = auth()->user();
        $tagihans = Transaksi::where('user_id', $user->id)->paginate(5);
        return Inertia::render('Page/Saldo', [
            'title' => 'Saldo',
            'userSaldo' => $user->saldo,
            'tagihans' => $tagihans,
        ]);
    }

    public function books(Request $request)
    {
        $query = $request->query('q') ?? 'kisah sejarah nabi muhammad';
        $page = $request->query('page') ?? 1;
        $books = new GoogleBooks(['key' => env('GOOGLE_BOOKS_KEY')]);
        $bookshelf = [];
        foreach ($books->volumes->search($query) as $vol) {
            try {
            $thumbnail = $vol->imageLinks->thumbnail;
            } catch (\Exception $e) {
                $thumbnail = "https://placehold.co/200x300";

            }

            $bookshelf[] = ["title" => $vol->title, 'publisher' => $vol->publisher, 'description' => $vol->description, 'pageCount' => $vol->pageCount, 'thumbnail' => $thumbnail, 'previewLink' => $vol->previewLink];
        }

        $perPage = 10;
        $result = paginateArray($bookshelf, $page, $perPage);

        return Inertia::render('Page/Books', [
            'title' => 'Books',
            'books' => $result
        ]);
    }
}

