<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Image;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::factory( 100 )->create()->each( function( Post $post ){

            Image::factory( 4 )->create([
                'imageable_id'      => $post->id,
                'imageable_type'    => Post::class,
            ]);

            $post->tags()->attach([
                rand( 1, 10 ),
                rand( 5, 8 )
            ]);
        });
    }
}
