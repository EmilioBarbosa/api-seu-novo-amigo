<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //Retorna todos os usuários
    public function index()
    {
        return User::all();
    }

    //Salva um usuário, recebe como parâmetro nome, email e senha
    public function store(Request $request)
    {
        $user = User::create([
            'name' =>$request->name,
            'email' =>$request->email,
            'password'=>$request->password
        ]);

        if ($request->phone_number){
            $user->phones()->create([
                'phone_number'=>$request->phone_number,
                'whatsapp' => $request->whatsapp
            ]);
        }

        return response()->json($user, 201);
    }

    //Retorna 1 usuário, com seus números de telefones, recebe id do usuário como parâmetro
    public function show(int $user)
    {
        $user = User::with('phones')->find($user);
        if ($user === null){
            return response()->json(['message'=> 'usuário não encontrado'], 404);
        }
        return $user;
    }

    //Atualiza um usuário, recebe pârametros opcionais, e irá mudar somente o que receber
    public function update(User $user,Request $request)
    {
        $user->fill($request->all());
        $user->save();
        return $user;
    }

    //exclui um usuário
    public function destroy($user)
    {
        User::destroy($user);
        return response()->noContent();
    }
}
