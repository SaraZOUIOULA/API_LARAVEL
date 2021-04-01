<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id"=> $this->id,
            "title"=> $this->title,
            "description"=> $this->description,
            "publication_year"=> $this->publication_year,
            "pages_nb"=> $this->pages_nb,
            "genres"=> GenreResource::collection($this->genres),
            "author"=> $this->author->name,
        ];
    }
}
