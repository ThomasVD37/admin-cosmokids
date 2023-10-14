<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "slug" => $this->slug,

            // ($request->path() !== 'api/login' && $request->path() !== 'api/register' && substr($request->path(), 0, 12) !== 'api/complete' && $request->path() !== 'api/activities')
            $this->mergeWhen(($request->path() === 'api/lessons'), [
                "image" => $this->image,
                "content" => $this->content,
                "associated_activities" => ActivityResource::collection($this->activities)
            ]),
        ];
    }
}
