<?php

namespace App\Http\Resources\Blog;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $images = [];
        foreach ($this->images as $image){
            $images[] = asset('storage/'.$image);
        }
        return [
            "id" => $this->id,
            "title" => $this->title,
            "slug" => $this->slug,
            "image" =>asset('storage/'. $this->image),
            "images" => $images,
            "content" => $this->content,
            "created_at" => Carbon::parse($this->created_at)->format('d F,Y'),
        ];
    }
}
