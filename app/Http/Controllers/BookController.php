<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookCollection;
use App\Http\Resources\BookResource;

use Illuminate\Http\Request;

use App\Models\Book;

class BookController extends Controller
{
    /**
     * @OA\Get(
     *      path="/books",
     *      operationId="getAllBook",
     *      tags={"Books"},

     *      summary="Get List Of Books",
     *      description="Returns all Books and associated authors and genres. No slug is used during this request",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     * @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     * @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *  )
     */
    
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $genreFilter=$request->query->get('genre');
        if($genreFilter){
            $books=Book::whereHas('genres', function ($query) use($genreFilter) {
                $query->where('genres.id', '=', $genreFilter);
            });
            return new BookCollection($books->simplePaginate(10));
        }else{
            return new BookCollection(Book::orderBy('title')->paginate(10));
        }
    }
   
    /**
     * @OA\Post(
     *      path="/books",
     *      operationId="AddBook",
     *      tags={"Books"},

     *      summary="Add a new Book",
     *      description="Returns infos on the new added book with the author and genres associated.",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      ),
     *      @OA\Parameter(
     *        name="title",
     *        in="path",
     *        description="title ",
     *        required=true
     *      ),
     *      @OA\Parameter(
     *        name="description",
     *        in="path",
     *        description="description",
     *        required=true
     *      ),
     *      @OA\Parameter(
     *        name="publication_year",
     *        in="path",
     *        description="publication year",
     *        required=true
     *      ),
     *      @OA\Parameter(
     *        name="pages_nb",
     *        in="path",
     *        description="numbre of pages",
     *        required=true
     *      ),
     *      @OA\Parameter(
     *        name="author_id",
     *        in="path",
     *        description="author's id",
     *        required=true
     *      ),
     *      @OA\Parameter(
     *        name="genre_id",
     *        in="path",
     *        description="genre's id",
     *        required=true
     *      ),
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     * @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     * @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *  )
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $newBook = Book::addBook($request->all());
        return response()->json($newBook, 201); // created
    }

    /**
     * @OA\Get(
     *      path="/books/id",
     *      operationId="getOneBook",
     *      tags={"Books"},
     *      summary="Get the book using it's id",
     *      description="Returns the book. Book must be the book_slug from /books.",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     * )
     *      ),
     *        @OA\Parameter(
     *        name="id",
     *        in="path",
     *        description="search by book id",
     *        required=true
     *      ),
     *
     *    
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     * @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     * @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *  )
     */
    
     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $book = Book::find($id);
        if($book){
            return new BookResource($book);
        }else{
            return response()->json(['message' => 'Book Not Found!'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }
    /**
     * @OA\Patch(
     *      path="/books/id",
     *      operationId="UpdateBook",
     *      tags={"Books"},
     *      summary="update an existent book",
     *      description="Returns the modified book. Book must be the book_slug from /books/id.",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     * )
     *      ),
     *        @OA\Parameter(
     *        name="id",
     *        in="path",
     *        description="search by book id",
     *        required=true
     *      ),
     *      @OA\Parameter(
     *        name="title",
     *        in="path",
     *        description="title ",
     *        required=true
     *      ),
     *      @OA\Parameter(
     *        name="description",
     *        in="path",
     *        description="description",
     *        required=true
     *      ),
     *      @OA\Parameter(
     *        name="publication_year",
     *        in="path",
     *        description="publication year",
     *        required=true
     *      ),
     *      @OA\Parameter(
     *        name="pages_nb",
     *        in="path",
     *        description="numbre of pages",
     *        required=true
     *      ),
     *      @OA\Parameter(
     *        name="author_id",
     *        in="path",
     *        description="author's id",
     *        required=true
     *      ),
     *      @OA\Parameter(
     *        name="genre_id",
     *        in="path",
     *        description="genre's id",
     *        required=true
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     * @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     * @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *  )
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Book  $book
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request,Book $book)
    {
        $updatedBook = Book::updateBook($book,$request->all());
        return response()->json($updatedBook, 200);
    }
    /**
     * @OA\Delete(
     *      path="/books/id",
     *      operationId="deleteOneBook",
     *      tags={"Books"},
     *      summary="delete a book using it's id",
     *      description="Returns nothing . Book must be the book_slug from /books.",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     * )
     *      ),
     *        @OA\Parameter(
     *        name="id",
     *        in="path",
     *        description="search by book id",
     *        required=true
     *      ),
     *
     *    
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     * @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     * @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *  )
     */
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  Book  $book
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Book $book)
    {
        $book->delete;
        return response()->json('', 204);
    }

    /**
     * Search the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $book= Book::where('title','like',"%{$request->title}%")->get();
        
        if($book){
            return new BookCollection($book);
        }else{ return response()->json(['message' => 'Book Not Found!'], 404); }
    }


}
