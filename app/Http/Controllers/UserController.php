<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class UserController extends Controller
{
    public function __construct()
    {
        //Middleware não irá verificar o token na rota show e login
        $this->middleware('auth:sanctum')->except('show', 'login', 'store');
    }
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
            'password'=> Hash::make($request->password),
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
     * @param Request $request
     * Função para excluir um usuário
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function destroy(int $user, Request $request)
    {
        //Pega o token pelo header
        $header_token =  $request->header('authorization');
        $header_token = str_replace('Bearer ', '', $header_token);
        //Procura a model do token
        $token = PersonalAccessToken::findToken($header_token);
        //se o id do usuário desse token for igual ao id do parâmetro da requisição ele deleta o usuário e o token
        if($token->tokenable_id === $user){
            $token->delete();
            User::destroy($user);
            return response()->noContent();
        }
        return response()->json(['message' => 'Não autorizado'], 401);
    }

    public function login(Request $request)
    {
        $credentials = $request->all();
        //faz a verificação se o usuário existe e suas credenciais estão corretas
        if (Auth::attempt($credentials) === false){
            return response()->json(['message' => 'Não autorizado'], 401);
        }
        $user = Auth::user();
        //deleta o token anterior antes de criar o novo
        $user->tokens()->delete();
        //gera um token para o usuário
        $token = $user->createToken('token');

        return response()->json(["id" => Auth::id(), "token" => $token->plainTextToken]);
    }
}
