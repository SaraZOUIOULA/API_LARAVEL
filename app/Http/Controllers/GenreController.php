<?php

namespace App\Http\Controllers;

use App\Http\Resources\GenreCollection;
use App\Http\Resources\GenreResource;
use Illuminate\Http\Request;

use App\Models\Genre;

class GenreController extends Controller
{  
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return new GenreCollection(Genre::Paginate(10));  //status 200 
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $newGenre = Genre::addGenre($request->all());
        return response()->json($newGenre, 201); // CODE HTTP 201 = created
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $genre = Genre::find($id);
        if($genre){
            return new GenreResource($genre);
        }else{
            return response()->json(['message' => 'Genre Not Found!'], 404);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Genre  $genre
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Genre $genre)
    {
        $updatedGenre = Genre::updateGenre($genre,$request->all());
        return response()->json($updatedGenre, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Genre  $genre
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Genre $genre)
    {
        $genre->delete;
        return response()->json('', 204);
    }
}