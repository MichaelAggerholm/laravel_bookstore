<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Shoppingbasket;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // TODO: Probably do name and address here, phone specified to 8 from factory
        // TODO: And maybe url with 'www.' . fakeString(10) . '.com'
        Warehouse::factory()->create([
            'name' => 'Navn1',
            'address' => 'Adresse1',
            'phone' => '12345678',
            'url' => 'www.test.dk',
        ]);

//        // Shoppingbasket auto creates Customers on creation.
//        Shoppingbasket::factory()->count(15)->create();
//        // Book auto creates Publishers and Authors on creation.
//        Book::factory()->count(15)->create();
//        User::factory()->count(15)->create();
//
//        // Many-to-Many factory, randomly combines books with warehouses
//        $books = Book::all();
//        Warehouse::all()->each(function ($warehouse) use ($books) {
//            $warehouse->books()->attach(
//                $books->random(10)->pluck('id')->toArray()
//            );
//        });
//
//        // Many-to-Many factory, randomly combines books with shoppingbaskets
//        $books = Book::all();
//        Shoppingbasket::all()->each(function ($shoppingbasket) use ($books) {
//            $shoppingbasket->books()->attach(
//                $books->random(10)->pluck('id')->toArray()
//            );
//        });
    }
}
