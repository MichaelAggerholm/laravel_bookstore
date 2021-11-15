<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Publisher;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');

        return view('books.index', ['books' => Book::with(['author', 'publisher'])
            ->when($searchTerm, function ($query) use ($searchTerm) {
                $query->where('ISBN', 'LIKE', '%' . $searchTerm . '%');
                $query->orWhereHas('author', function($authorQuery) use ($searchTerm) {
                    $authorQuery->where('name', 'LIKE', '%'.$searchTerm.'%');
                });
                $query->orWhereHas('publisher', function($authorQuery) use ($searchTerm) {
                    $authorQuery->where('name', 'LIKE', '%'.$searchTerm.'%');
                });
                $query->orWhere('year', 'LIKE', '%' . $searchTerm . '%');
                $query->orWhere('title', 'LIKE', '%' . $searchTerm . '%');
                $query->orWhere('price', 'LIKE', '%' . $searchTerm . '%');
            })->sortable()->paginate(14)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $authors = Author::all();
        $selectedAuthor = Book::first()->author_id;

        $publishers = Publisher::all();
        $selectedPublisher = Book::first()->publisher_id;

        $warehouses = Warehouse::all();
        $selectedWarehouse = Book::first()->warehouse_id;

        return view('books.create', compact(['authors', 'publishers', 'warehouses'],
                        ['selectedAuthor', 'selectedPublisher', 'selectedWarehouse']
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'ISBN' => 'required',
            'author_id' => 'required',
            'publisher_id' => 'required',
            'year' => 'required',
            'title' => 'required',
            'price' => 'required',
        ]);

        try {
            $book = Book::create($request->all());

            // create relation to warehouses in the many-to-many relational table
            $book->warehouses()->sync($request->checked); // $request->checked must be an array

            return redirect()->route('books.index')
                ->with('success','Book created successfully.');

        } catch (\Illuminate\Database\QueryException $e) {
            var_dump($e->errorInfo);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        $warehouses = Warehouse::all();
        $selectedWarehouse = Book::first()->warehouse_id;

        return view('books.show', compact(['book', 'warehouses'], ['selectedWarehouse']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        $authors = Author::all();
        $selectedAuthor = Book::first()->author_id;

        $publishers = Publisher::all();
        $selectedPublisher = Book::first()->publisher_id;

        $warehouses = Warehouse::all();
        $selectedWarehouse = Book::first()->warehouse_id;

        return view('books.edit', compact(['book', 'authors', 'publishers', 'warehouses'],
                        ['selectedAuthor', 'selectedPublisher', 'selectedWarehouse']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Book $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'ISBN' => 'required',
            'publisher_id' => 'required',
            'author_id' => 'required',
            'year' => 'required',
            'title' => 'required',
            'price' => 'required',
        ]);

        try {
            $book->update($request->all());

            // Update relation to warehouses in the many-to-many relational table
            $book->warehouses()->sync($request->checked);

            return redirect()->route('books.index')
                ->with('success','Book updated successfully.');

        } catch (\Illuminate\Database\QueryException $e) {
            var_dump($e->errorInfo);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        // Delete a specific book
        $book->delete();

        return redirect()->route('books.index')
            ->with('success','Book deleted successfully');
    }
}
