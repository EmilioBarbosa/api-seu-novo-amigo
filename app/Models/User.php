<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'description'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * relação para retornar os telefones desse usuário
     */
    public function phones()
    {
        return $this->hasMany(PhoneNumber::class);
    }

    /**
     * relação para retornar o endereço desse usuário
     */
    public function address()
    {
        return $this->hasOne(Address::class);
    }

    /**
     * relação para retornar os animais que o usuário colocou para adoção
     */
    public function animals()
    {
        return $this->hasMany(Animal::class);
    }


}
