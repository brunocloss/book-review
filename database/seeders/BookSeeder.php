<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Review;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Book::factory(34)->create()->each(function ($book) {
            $numberReviews = random_int(5,20);
    
            Review::factory()->count($numberReviews)
                ->good()
                ->for($book)
                ->create();
           });
    
           Book::factory(33)->create()->each(function ($book) {
            $numberReviews = random_int(5,20);
    
            Review::factory()->count($numberReviews)
                ->average()
                ->for($book)
                ->create();
           });
    
           Book::factory(33)->create()->each(function ($book) {
            $numberReviews = random_int(5,20);
    
            Review::factory()->count($numberReviews)
                ->bad()
                ->for($book)
                ->create();
           });
    }
}
