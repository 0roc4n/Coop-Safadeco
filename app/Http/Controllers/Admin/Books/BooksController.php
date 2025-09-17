<?php

namespace App\Http\Controllers\Admin\Books;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Book;
use Illuminate\Support\Facades\Validator;

class BooksController extends Controller
{
    public function index()
    {
        $books = Book::orderBy('DateCreated', 'desc')->get();
        
        return Inertia::render('Admin/Books/Index', [
            'books' => $books,
            'flash' => [
                'success' => session('success')
            ]
        ]);
    }
    
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'Description' => 'required|max:32',
            'DateFrom' => 'required|date',
            'DateTo' => 'nullable|date|after:DateFrom',
            'Closing' => 'nullable|date',
            'Purging' => 'nullable|date',
        ])->validate();
        
        $validated['DateCreated'] = now();
        
        Book::create($validated);
        
        return redirect()->route('admin.book-journals.index')->with('success', 'Book created successfully');
    }
    
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        
        $validated = Validator::make($request->all(), [
            'Description' => 'required|max:32',
            'DateFrom' => 'required|date',
            'DateTo' => 'nullable|date|after:DateFrom',
            'Closing' => 'nullable|date',
            'Purging' => 'nullable|date',
        ])->validate();
        
        $book->update($validated);
        
        return redirect()->route('admin.book-journals.index')->with('success', 'Book updated successfully');
    }
    
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        
        return redirect()->route('admin.book-journals.index')->with('success', 'Book deleted successfully');
    }
}
