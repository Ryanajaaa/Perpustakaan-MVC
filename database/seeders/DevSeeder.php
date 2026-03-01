<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DevSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('books')->insert([
            [
                'id' => 1,
                'book_code' => 'BK001',
                'title' => 'bumi',
                'author' => 'Tere Liye',
                'publisher' => 'Gramedia',
                'year' => 2014,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'book_code' => 'BK002',
                'title' => 'Bulan',
                'author' => 'Tere Liye',
                'publisher' => 'gramedia',
                'year' => 2015,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'book_code' => 'BK003',
                'title' => 'Matahari',
                'author' => 'Tere Liye',
                'publisher' => 'Gramedia',
                'year' => 2016,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'book_code' => 'BK004',
                'title' =>'matahari minor',
                'author' => 'Tere liye',
                'publisher' => 'Gramedia',
                'year' => 2023,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'book_code' => 'BK005',
                'title' => 'bintang',
                'author' => 'Tere liye',
                'publisher' => 'Gramedia',
                'year' => 2017,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
        ]);
        User::create(
            [
                'id' => 0,
                'school_id' => 6,
                'name' => 'ADMIN PERPUSTAKAAN',
                'class' => '',
                'major' => '',
                'username' => 'admin',
                'role' => 'admin',
                'password' => Hash::make('admin'),
                'email' => 'perpustakaan@smktelkom-jkt.sch.id',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        );
    }
}