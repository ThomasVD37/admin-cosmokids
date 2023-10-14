<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    public function activities()
    {
        return $this->belongsToMany(Activity::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
