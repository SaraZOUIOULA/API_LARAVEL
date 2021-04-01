<?php

namespace App\Http\Controllers;

use App\Http\Resources\AuthorCollection;
use App\Http\Resources\AuthorResource;
use Illuminate\Http\Request;

use App\Models\Author;

class AuthorController extends Controller
{
    /**
     * @OA\Get(
     *      path="/authors",
     *      operationId="getAllAuthors",
     *      tags={"Authors"},

     *      summary="Get List Of authors",
     *      description="Returns all authors",
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {   
        return new AuthorCollection(Author::orderBy('name','asc')->paginate(20));  //status 200 
    }
    /**
     * @OA\Post(
     *      path="/authors",
     *      operationId="AddAuthor",
     *      tags={"Authors"},

     *      summary="Add a new author",
     *      description="Returns infos on the new added author.",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      ),
     *      @OA\Parameter(
     *        name="name",
     *        in="path",
     *        description="name",
     *        required=true
     *      ),
     *),
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
        $newAuthor = Author::addAuthor($request->all());
        return response()->json($newAuthor, 201); // CODE HTTP 201 = created
    }

    /**
     * @OA\Get(
     *      path="/authors/id",
     *      operationId="getOneAuthor",
     *      tags={"Authors"},
     *      summary="Get the author using it's id",
     *      description="Returns the author. author must be the author_slug from /authors.",
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
        $author = Author::find($id);
        if($author){
            return new AuthorResource($author);
        }else{
            return response()->json(['message' => 'Author Not Found!'], 404);
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
     *      path="/authors/id",
     *      operationId="UpdateAuthor",
     *      tags={"Authors"},
     *      summary="update an existent author",
     *      description="Returns the modified author. author must be the author_slug from /authors/id.",
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
     *        name="name",
     *        in="path",
     *        description="name ",
     *        required=true
     *      ),
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Author  $author
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Author $author)
    {
        $updatedAuthor = Author::updateAuthor($author,$request->all());
        return response()->json($updatedAuthor, 200);
    }
    /**
     * @OA\Delete(
     *      path="/authors/id",
     *      operationId="deleteOneAuthor",
     *      tags={"Authors"},
     *      summary="delete an author using it's id",
     *      description="Returns nothing . author must be the author_slug from /authors.",
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
     * @param  Author  $author
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Author $author)
    {
        $author->delete;
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
        $author= Author::where('name','like',"%{$request->name}%")->get();
        
        if(count($author)){
            return new AuthorCollection($author);
        }else{ return response()->json(['message' => 'Author Not Found!'], 404); }
    }
    
}
