<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;

    /**
     * Retorna a pessoa que colocou o animal para adoção
     */
    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Retorna o porte do animal
     */
    public function animalSize()
    {
        return $this->belongsTo(AnimalSize::class);
    }

    /**
     * Retorna a espécie do animal
     */
    public function species()
    {
        return $this->belongsTo(Species::class);
    }
}
