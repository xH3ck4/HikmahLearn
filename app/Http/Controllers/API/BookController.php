<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
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

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $apikeyheaders = $request->header('apikey');
        $userApiKey = User::where('apikey', $apikeyheaders)->first();

        $page = $request->query('page');
        $query = $request->query('q');

        if(!$page || !$query)
        {
            return response()->json(['pesan'=>'harap masukkan query dan page | [GET] contoh request : /api/book?q=Harry Potter&page=1',
            'status'=>200,
            'nama_apikey'=>$userApiKey->nama,
            'saldo'=>$userApiKey->saldo,]);
        }

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

        
        User::where('apikey',$apikeyheaders)->decrement('saldo',intval(env('VITE_PAY_AMOUNT')));
        
        return response()->json(['pesan'=>'sukses',
        'status'=>200,
        'nama_apikey'=>$userApiKey->nama,
        'saldo'=>$userApiKey->saldo,
        'data'=>$result], 200);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
