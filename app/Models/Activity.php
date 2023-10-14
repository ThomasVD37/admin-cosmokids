<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activity extends Model
{
    use HasFactory;

    /**
     * Ajout de la relation qui recupère le type de la activité correspondante
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
