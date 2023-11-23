<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //dump($this);
        return [
            "id" => $this->id,
            "title" => $this->title,
            "slug" => $this->slug,
            // Si la requete porte sur l'user ou la completion, ne pas tout renvoyer des activités

            //($request->path() !== 'api/login' && $request->path() !== 'api/register' && substr($request->path(), 0, 12) !== 'api/complete' && $request->path() !== 'api/lessons')

            $this->mergeWhen(($request->path() === 'api/data'), [
                "image" => $this->image,
                "rules" => $this->rules,
                "description" => $this->description,
                "duration" => $this->duration,
                "type" => new TypeResource($this->type),
                "associated_lessons" => $this->lessons,
                ],
            ),
        ];

    }
}
