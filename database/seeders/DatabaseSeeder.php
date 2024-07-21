<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Tag;
use App\Models\Post;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Storage::makeDirectory( 'posts' );        
        $this->call( UserSeeder::class );

        Category::factory( 10 )->create();
        Tag::factory( 10 )->create();
        
        $this->call( PostSeeder::class );
    }
}
