<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Session\Store;

class UserController extends Controller
{
    //Retorna todos os usuários
    public function index()
    {
        return User::all();
    }

    /**
     * @param StoreUserRequest $request
     * Função para criar um usuário
     * Retorna o usuário criado
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'name' =>$request->name,
            'email' =>$request->email,
            'description'=>$request->description,
            'password'=>$request->password
        ]);

        $user->phones()->create([
            'phone_number'=>$request->phone_number,
            'whatsapp' => $request->phone_number_whatsapp
        ]);

        $user->address()->create([
            'street' => $request->street,
            'neighborhood' => $request->neighborhood,
            'city_id' => $request->city_id
        ]);

        $returnUser = User::with('phones', 'address.city.state')->find($user->id);

        return response()->json($returnUser, 201);
    }

    /**
     * @param int $user
     * Função para exibir um usuário específico
     * Retorna o usuário
     */
    public function show(int $user)
    {
        $user = User::with('phones', 'address.city.state')->find($user);
        if ($user === null){
            return response()->json(['message'=> 'usuário não encontrado'], 404);
        }
        return $user;
    }

    //Atualiza um usuário, recebe pârametros opcionais, e irá mudar somente o que receber
    //fazer o update com os dados que vierem no request
    public function update(User $user,Request $request)
    {
        $userData = $request->except(['phone_number', 'phone_number_whatsapp', 'street', 'neighborhood', 'city_id']);

        return $userData;

        $user->fill($userData);

        $user->phones()->update([
            'phone_number' => $request->phone_number,
            'whatsapp' => $request->phone_number_whatsapp
        ]);

        $user->address()->update([
            'street' => $request->street,
            'neighborhood' => $request->neighborhood,
            'city_id' => $request->city_id
        ]);


        return('ok');
    }

    //exclui um usuário
    public function destroy($user)
    {
        User::destroy($user);
        return response()->noContent();
    }
}
