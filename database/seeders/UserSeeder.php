<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'id' => Str::uuid(),
            'nama' => 'Hikmah Learn Admin',
            'email' => 'hikmahlearn@gmail.com',
            'nohp' => '082143012823',
            'password' => Hash::make('HikmahLearn098!!!'),
            'saldo' => 99999999,
            'tgl_pembuatan' => Carbon::now(),
            'email_verified_at' => Carbon::now(),
            'apikey' => Str::random(32),
            'wlip' => '',
            'is_dewa' => 1,
        ]);
    }
}
