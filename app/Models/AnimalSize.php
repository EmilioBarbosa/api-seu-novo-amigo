<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimalSize extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * Função de relacionamento com a classe Animal
     * Retorn os animais de determinado porte
     */
    public function animals()
    {
        return $this->hasMany(Animal::class);
    }
}
