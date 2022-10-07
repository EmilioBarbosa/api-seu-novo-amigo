<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneNumber extends Model
{
    use HasFactory;

    //retorna o dono desse número de telefone
    public function owner()
    {
        return $this->belongsTo(User::class);
    }
}
