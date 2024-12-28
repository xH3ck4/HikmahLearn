<?php

namespace Database\Seeders;

use App\Models\Transaksi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Transaksi::create([
            'id'=>'xxxxxxxxx',
            'user_id'=>'ccdd3523-0fd0-48d1-bfdc-a6376d3e02aa',
            'jumlah'=>'1000',
            'servis'=>'midtrans',
            'status'=>'pending',
            'description'=>'test 1',
        ]);

        Transaksi::create([
            'id'=>'xxxxxxxxxxxxx',
            'user_id'=>'ccdd3523-0fd0-48d1-bfdc-a6376d3e02aa',
            'jumlah'=>'500',
            'servis'=>'midtrans',
            'snap_token'=>'',
            'status'=>'success',
            'description'=>'test 2',
        ]);
    }
}
