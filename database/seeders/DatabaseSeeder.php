<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Size;
use App\Models\User;
use App\Models\Quality;
use App\Models\Setting;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            "name" => "admin",
            "email" => "admin@mail.com",
            "msisdn" => "09795864194",
            "city" => "Yangon",
            "shipping_address" => "No.28, Mya Street",
            "gender" => 'male',
            "password" => Hash::make('password')
        ]);

        Setting::create();

        $stickerCategory = Category::create([
            'id' => \Str::uuid(),
            "name" => "sticker",
        ]);

        Quality::insert([
            [
                'id' => \Str::uuid(),
                "name" => "Matte",
                "price" => 0,
                "category_id" => $stickerCategory->id
            ],
        ]);

        Size::insert([
            [
                'id' => \Str::uuid(),
                "name" => "Large",
                "price" => 2000,
                "size" => "6 x 6 inches",
                "category_id" => $stickerCategory->id
            ],
            [
                'id' => \Str::uuid(),
                "name" => "Medium",
                "price" => 1500,
                "size" => "4 x 4 inches",
                "category_id" => $stickerCategory->id
            ],
            [
                'id' => \Str::uuid(),
                "name" => "Normal",
                "price" => 500,
                "size" => "2 x 2.5 inches",
                "category_id" => $stickerCategory->id
            ]
        ]);

        $badgeCategory = Category::create([
            'id' => \Str::uuid(),
            "name" => "badge",
        ]);

        Quality::insert([
            [
                'id' => \Str::uuid(),
                "name" => "Matte",
                "price" => 0,
                "category_id" => $badgeCategory->id
            ],
            [
                'id' => \Str::uuid(),
                "name" => "Gloss",
                "price" => 0,
                "category_id" => $badgeCategory->id
            ]
        ]);

        Size::insert([
            [
                'id' => \Str::uuid(),
                "name" => "Large",
                "price" => 1700,
                "size" => "55 mm",
                "category_id" => $badgeCategory->id
            ],
            [
                'id' => \Str::uuid(),
                "name" => "Medium",
                "price" => 1250,
                "size" => "32 mm",
                "category_id" => $badgeCategory->id
            ],
            [
                'id' => \Str::uuid(),
                "name" => "Small",
                "price" => 1000,
                "size" => "25 mm",
                "category_id" => $badgeCategory->id
            ]
        ]);

        $posterCategory = Category::create([
            'id' => \Str::uuid(),
            "name" => "poster"
        ]);

        Quality::insert([
            [
                'id' => \Str::uuid(),
                "name" => "No Water Proof",
                "price" => 0,
                "category_id" => $posterCategory->id
            ],
            [
                'id' => \Str::uuid(),
                "name" => "Matte Water Proof",
                "price" => 1000,
                "category_id" => $posterCategory->id
            ],
            [
                'id' => \Str::uuid(),
                "name" => "Gloss Water Proof",
                "price" => 1000,
                "category_id" => $posterCategory->id
            ],
            [
                'id' => \Str::uuid(),
                "name" => "Cat Scratch Water Proof",
                "price" => 1500,
                "category_id" => $posterCategory->id
            ],
            [
                'id' => \Str::uuid(),
                "name" => "Diamond Water Proof",
                "price" => 2000,
                "category_id" => $posterCategory->id
            ],
        ]);

        Size::insert([
            [
                'id' => \Str::uuid(),
                "name" => "Normal",
                "price" => 2500,
                "size" => "A4",
                "category_id" => $posterCategory->id
            ],
            [
                'id' => \Str::uuid(),
                "name" => "Large",
                "price" => 4000,
                "size" => "12 x 12 inches",
                "category_id" => $posterCategory->id
            ]
        ]);
    }
}

