<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Book; // Assuming you meant Book, but using Boook as per your code
use App\Models\Review;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


      Book::factory(33)->create()->each(function($book){
    $numReviews = rand(1, 5); 
    Review::factory()->count($numReviews)->good()->for($book)->create();
     Review::factory()->count($numReviews)->bad()->for($book)->create();
      Review::factory()->count($numReviews)->average()->for($book)->create();
     
});

      Book::factory(33)->create()->each(function($book){
    $numReviews = rand(1, 5); 
    Review::factory()->count($numReviews)->good()->for($book)->create();
     Review::factory()->count($numReviews)->bad()->for($book)->create();
      Review::factory()->count($numReviews)->average()->for($book)->create();
     
});
      Book::factory(33)->create()->each(function($book){
    $numReviews = rand(1, 5); 
    Review::factory()->count($numReviews)->good()->for($book)->create();
     Review::factory()->count($numReviews)->bad()->for($book)->create();
      Review::factory()->count($numReviews)->average()->for($book)->create();
     
});


    }

    
}
