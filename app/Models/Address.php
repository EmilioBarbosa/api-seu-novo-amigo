<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = ['street', 'neighborhood', 'city_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * relação para retornar a cidade desse endereço
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

}
