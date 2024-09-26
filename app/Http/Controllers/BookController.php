<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use App\Services\BookService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected $bookService;
    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::select('title', 'author', 'published_at', 'is_active')->orderBy('published_at')->paginate(5);
        return response()->json(
            [
                'status' => 'success',
                'message' => 'all book returned',
                'data' => $books
            ],
            'status' === 'success' ? 200 : 400
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        // dd($request);
        $validatedData = $request->validated();
        $result = $this->bookService->storeBook($validatedData);
        return response()->json(
            [
                'status' => $result['status'],
                'massege' => $result['massege'],
                'data' => $result['data']
            ],
            $result['status'] === 'success' ? 200 : 400
        );

    }

    /**
     * Display the specified resource.
     */
    public function show($bookId)
    {

        $response = $this->bookService->showBook($bookId);

        return response()->json($response, $response['status'] === 'success' ? 200 : ($response['message'] === 'Book not found' ? 404 : 500));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, $bookId)
    {
        $validatedData = $request->validated();
        $response = $this->bookService->updateBook($validatedData, $bookId);
        return response()->json(
            $response,
            $response['status'] === 'success' ? 200 : ($response['massege'] == 'bok not found' ? 404 : 500)
        );

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($bookId)
    {
        $response = $this->bookService->deleteBook($bookId);
        return response()->json($response, $response['status'] === 'success' ? 200 : ($response['massege'] == 'book not found' ? 404 : 500));
    }
}
