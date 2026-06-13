<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Page;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Page::insert([
    [
        'title' => 'Terms And Conditions',
        'slug' => 'terms-and-conditions',
        'content' => '',
        'status' => 1,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'title' => 'Privacy Policy',
        'slug' => 'privacy-policy',
        'content' => '',
        'status' => 1,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'title' => 'Help And Support',
        'slug' => 'help-and-support',
        'content' => '',
        'status' => 1,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'title' => 'Refund And Cancellation Policy',
        'slug' => 'refund-and-cancellation-policy',
        'content' => '',
        'status' => 1,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'title' => 'About Us',
        'slug' => 'about-us',
        'content' => '',
        'status' => 1,
        'created_at' => now(),
        'updated_at' => now(),
    ],
]);
    }
}
