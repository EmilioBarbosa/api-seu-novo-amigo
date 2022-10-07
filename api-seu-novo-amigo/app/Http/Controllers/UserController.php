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


    public function update(User $user,Request $request)
    {
        $user->fill([
            'name' =>$request->name,
            'email' =>$request->email,
            'password'=>$request->password
        ]);
        $user->save();
        return $user;
    }


    public function destroy($id)
    {
        //
    }
}
