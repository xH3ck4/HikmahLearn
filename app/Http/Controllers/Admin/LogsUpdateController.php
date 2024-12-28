<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LogsUpdate;
use Illuminate\Support\Facades\Validator;

class LogsUpdateController extends Controller
{
    public function index()
    {
        $logs = LogsUpdate::all();
        return response()->json($logs);
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
    
        if ($validator->fails()) {
                return response()->json(['message'=>'Gagal menambahkan log!','errors'=>$validator->errors()], 400);
        }
    
        $log = LogsUpdate::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);
    
        return response()->json(['message' => 'Log berhasil ditambahkan!', 'data' => $log]);
    }
    
    public function show(string $id)
    {
        $log = LogsUpdate::find($id);
    
        if (is_null($log)) {
            return response()->json(['message' => 'Log not found'], 404);
        }
    
        return response()->json($log);
    }
    
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['message'=>'Gagal mengubah data log!','errors'=>$validator->errors()], 400);
        }
    
        $log = LogsUpdate::find($id);
    
        if (is_null($log)) {
            return response()->json(['message' => 'Log tidak ditemukan!'], 404);
        }
    
        $log->update($request->all());
    
        return response()->json(['message' => 'Log berhasil diupdate!', 'data' => $log]);
    }
    
    public function destroy(string $id)
    {
        $log = LogsUpdate::find($id);
    
        if (is_null($log)) {
            return response()->json(['message' => 'Log tidak ditemukan!'], 404);
        }
    
        $log->delete();
    
        return response()->json(['message' => 'Log berhasil dihapus!']);
    }
}
