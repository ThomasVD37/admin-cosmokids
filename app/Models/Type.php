<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Type extends Model
{
    use HasFactory;

     /**
     * Ajout de la relation qui récupère les types de l'activity
     */
    public function activity(): HasMany
    {
        return $this->hasMany(Activity::class);
    }
}
