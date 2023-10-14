<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\ActivityResource;
use App\Http\Resources\LessonResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // ***************************
        // UNUSED FOR NOW
        // ***************************
        $users = User::all();
        return response()->json($users, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }


    /**
     * Display a listing of the resource found by the user request.
     * NO LONGER USED
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $foundActivities = DB::table('activities')
            ->where('title', 'like', '%' . $request->userInput . '%')->get();

        $foundLessons = DB::table('lessons')
            ->where('title', 'like', '%' . $request->userInput . '%')->get();

        $searchResult = [];

        foreach ($foundActivities as $activity) {
            $searchResult[] = [
                "Activity" => $activity,
            ];
        }

        foreach ($foundLessons as $lesson) {
            $searchResult[] = [
                "lesson" => $lesson,
            ];
        }

        //$searchResult = [...$foundActivities, ...$foundLessons];
        $searchResult === [] && $searchResult = 'No result has been found';

        return response()->json($searchResult, 200);
    }


    /**
     * List the user's completed activities
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function listUserActivities(Request $request)
    {
        $user = $request->user();

        // ***************************
        // UNUSED FOR NOW
        // ***************************

        if (!$user) {
            return response('User not found', 404);
        }

        $completedActivities = [];
        foreach ($user->activities as $activity) {
            $completedActivities[] = [
                "id" => $activity->id,
                "title" => $activity->title,
                "slug" => $activity->slug,
                "type" => $activity->type->name,
            ];
        }

        return response()->json($completedActivities, 200);
    }

    /**
     * Complete an activity by its id
     *
     * @param Request $request
     * @param int Activity $id
     * @return \Illuminate\Http\Response
     */
    public function completeActivity(Request $request, $id)
    {

        $activity = DB::table('activities')->where("id", $id)->exists();

        if (!$activity) {
            return response()->json('Activity not found', 404);
        }

        $user = $request->user();

        // Pas opti de refaire une requete a la bdd
        $completed = DB::table('activities')->where("id", $id)->get();

        foreach ($user->activities as $activity) {

            if ($activity->id === intval($id)) {
                return response()->json('Activity already completed', 422);
            };
        };

        $user->activities()->attach($id);

        return response()->json([
            "completed_activity" => [
                "id" => $completed[0]->id,
                "title" => $completed[0]->title,
                "slug" => $completed[0]->slug,
            ]
        ], 200);
    }


    /**
     * Complete an lesson by its id
     *
     * @param Request $request
     * @param int Lesson $id
     * @return \Illuminate\Http\Response
     */
    public function completeLesson(Request $request, $id)
    {

        $lesson = DB::table('lessons')->where("id", $id)->exists();

        if (!$lesson) {
            return response()->json('Lesson not found', 404);
        }

        $user = $request->user();

        // Pas opti de refaire une requete a la bdd
        $completed = DB::table('lessons')->where("id", $id)->get();

        foreach ($user->lessons as $lesson) {

            if ($lesson->id === intval($id)) {
                return response()->json('Lesson already completed', 422);
            };
        };

        $user->lessons()->attach($id);

        return response()->json([
            "completed_lesson" => [
                "id" => $completed[0]->id,
                "title" => $completed[0]->title,
                "slug" => $completed[0]->slug,
            ]
        ], 200);
    }


    public function login(Request $request)
    {

        //dump($request->email);
        if (!Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            return response()->json([
                'message' => 'Identifiants invalides'
            ], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();
        //dump($user);
        $token = $user->createToken('auth_token')->plainTextToken;


        // Regenere la session, a priori besoin uniquement en back office
        // $request->session()->regenerate();
        // $user->load('activities', 'lessons')

        return response()->json([
            'message' => 'User connected',
            'user' => new UserResource($user),
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json('User disconnected', 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validate([
            'email' => 'bail|required|email|unique:users|max:128',
            'pseudo' => ['bail', 'required', 'string', 'unique:users', 'min:4', 'max:64'],
            'password' => [
                'required',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
            'profile_image' => 'nullable|string|max:128'
        ]);

        //dump($validated);

        $user = User::create([
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'pseudo' => $validated['pseudo'],
            'profile_image' => $validated['profile_image'],
        ]);

        //Le Hash utilise l'algorythme bcrypt

        $token = $user->createToken('auth_token')->plainTextToken;

        if ($user) {
            return response()->json([
                'message' => 'User has been successfully created',
                'user' => new UserResource($user),
                'access_token' => $token,
                'token_type' => 'Bearer',
            ], 201);
        } else {
            return response(null, 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $userId
     * @return \Illuminate\Http\Response
     */
    public function show(int $userId)
    {

        // ***************************
        // UNUSED FOR NOW
        // ***************************

        // Il est possible de directement faire un $request->user() avec le token a priori, a creuser plus tard

        $user = User::find($userId);

        if (!$user) {
            return response('User not found', 404);
        }

        return response()->json($user->load('activities', 'lessons'), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    // La methode PUT crée un soucis, si l'on veut par exemple que modifier son email, car pas adaptée au patch partiel

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json("User not found", 404);
        }

        $validated = $request->validate([
            'email' => [
                'required',
                Rule::unique('users')->ignore($user->id),
                'email',
                'max:128'
            ],
            'pseudo' => [
                'required',
                'string',
                Rule::unique('users')->ignore($user->id),
                'min:4',
                'max:64'
            ],
            'profile_image' => 'nullable|string|max:128'
        ]);


        $validated['pseudo'] && $user->pseudo = $validated['pseudo'];
        $validated['email'] && $user->email = $validated['email'];
        $validated['profile_image'] && $user->profile_image = $validated['profile_image'];

        if ($user->save()) {
            return response()->json(new UserResource($user), 200);
        } else {
            return response('Erreur lors de la modification', 500);
        }
    }


    /**
     * Update the users's password.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function editPassword(UpdateUserRequest $request)
    {

        $user = $request->user();

        if (!$user) {
            return response()->json("User not found", 404);
        }

        $validated = $request->validate([
            'old_password' => 'required|current_password',
            'password' => [
                'required',
                Rule::unique('users')->ignore($user->id),
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
        ]);

        $validated['password'] && $user->password = Hash::make($validated['password']);

        if ($user->save()) {
            return response()->json('Password updated', 200);
        } else {
            return response('Erreur lors de la modification', 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * //@param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(UpdateUserRequest $request)
    {
        //dump($request, $userId);
        if (!Auth::guard("web")->attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            return response()->json([
                'message' => 'Identifiants invalides'
            ], 401);
        }

        $user = $request->user();

        if (!$user) {
            return response()->json("User not found", 404);
        }

        if ($user->delete()) {
            $request->user()->currentAccessToken()->delete();
            return response()->json('user successfully deleted', 200);
        } else {
            return response(null, 500);
        }
    }
}
