<?php

namespace App\Services;
use App\Models\Book;
use Exception;
use Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class BookService
{

    public function storeBook($data)
    {
        try {
            $book = new Book();
            $book->title = $data['title'];
            $book->author = $data['author'];
            $book->published_at = $data['published_at'];

            $book->save();
            return [
                'status' => 'success',
                'massege' => 'book stored succesfuly',
                'data' => $book->only('title', 'author', 'published_at')
            ];
        } catch (\Exception $e) {
            log::error('Error creating book :' . $e->getMessage());
            return [
                'status' => 'faild',
                'massege' => 'an error ouccerd when creating book retray sotre it agine',
                'data' => null
            ];
        }
    }


    public function showBook($data)
    {
        try {

            $book = Book::findOrFail($data);
            return [
                'status' => 'success',
                'message' => 'This is the book',
                'data' => $book,
            ];
        } catch (ModelNotFoundException $e) {
            return [
                'status' => 'failed',
                'message' => 'Book not found',
                'data' => null,
            ];
        } catch (\Exception $e) {
            Log::error('Error fetching book: ' . $e->getMessage());
            return [
                'status' => 'failed',
                'message' => 'An error occurred while fetching the book',
                'data' => null,
            ];
        }
    }

    public function updateBook($data, $bookId)
    {

        try {
            // dd($data);
            $book = Book::findOrFail($bookId);
            $book->update($data);
            return [
                'status' => 'success',
                'massege' => 'book updated succesfuly',
                'data' => $book
            ];
        } catch (ModelNotFoundException $e) {
            return [
                'status' => 'faild',
                'massege' => 'book not found',
                'data' => null
            ];
        } catch (\Exception $e) {
            log::error('Error updating book' . $e->getMessage());
            return [
                'status' => 'faild',
                'massege' => 'some error occuer whene updating book',
                'data' => null
            ];
        }
    }

    public function deleteBook($bookId)
    {
        try {
            $book = Book::findOrFail($bookId);
            $book->delete();
            return [
                'status' => 'success',
                'massege' => 'book deleted succsefily',
                'data' => null,
            ];
        } catch (ModelNotFoundException $e) {
            return [
                'status' => 'faild',
                'massege' => 'book not found',
                'data' => null,
            ];
        } catch (\Exception $e) {
            log::error('Error delete book' . $e->getMessage());
            return [
                'status' => 'faild',
                'massege' => 'some error occuer whene deleting book',
                'data' => null
            ];
        }
    }

}
