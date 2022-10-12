<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Função para retornar todos os usuários
     */
    public function index()
    {
        return response()->json(User::all());
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
            return response()->json(['message'=> 'Usuário não encontrado'], 404);
        }
        return response()->json($user);
    }

    /**
     * @param UpdateUserRequest $request
     * Função para editar um usuário
     * Retorna o usuário editado
     */
    public function update(User $user, UpdateUserRequest $request)
    {
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'description' => $request->description,
        ]);

        $user->phones()->update([
            'phone_number' => $request->phone_number,
            'whatsapp' => $request->phone_number_whatsapp
        ]);

        $user->address()->update([
            'street' => $request->street,
            'neighborhood' => $request->neighborhood,
            'city_id' => $request->city_id
        ]);

        $returnUser = User::with('phones', 'address.city.state')->find($user->id);

        return response()->json($returnUser);
    }

    /**
     * @param int $user
     * Função para excluir um usuário
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $user)
    {
        User::destroy($user);
        return response()->noContent();
    }
}
