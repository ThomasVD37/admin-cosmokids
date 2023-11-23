<?php

namespace App\Http\Controllers;

use App\Http\Resources\ActivityResource;
use App\Http\Resources\LessonResource;
use App\Http\Resources\TypeResource;
use App\Models\Activity;
use App\Models\Lesson;
use App\Models\Type;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function index()
    {
        $activities = Activity::all();
        $lessons = Lesson::all();
        $types = Type::all();

        return response()->json([
            'activities' => ActivityResource::collection($activities->load('lessons')),
            'lessons' => LessonResource::collection($lessons->load('activities')),
            'types' => TypeResource::collection($types)
        ], 200);

    }
}
