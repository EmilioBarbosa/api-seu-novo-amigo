<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'breed',
        'sex',
        'weight',
        'age',
        'picture_1',
        'picture_2',
        'description',
        'adopted',
        'animal_size_id',
        'species_id',
        'user_id',
        'address_id'
    ];

    /**
     * Retorna a pessoa que colocou o animal para adoção
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
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
