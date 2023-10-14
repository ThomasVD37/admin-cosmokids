<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            "email" => $this->email,
            "pseudo" => $this->pseudo,
            "profile_image" => $this->profile_image,
            $this->mergeWhen(($request->path() !== 'api/editUser'), [
                "completed_activities" => ActivityResource::collection($this->activities),
                "completed_lessons" => LessonResource::collection($this->lessons),
            ])
        ];
    }
}
