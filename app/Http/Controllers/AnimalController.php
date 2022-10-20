<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnimalRequest;
use App\Models\Animal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Laravel\Sanctum\PersonalAccessToken;

class AnimalController extends Controller
{

    public function __construct()
    {
        //Middleware não irá verificar o token na rota index e show
        $this->middleware('auth:sanctum')->except('index', 'show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Animal::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(StoreAnimalRequest $request)
    {
        $user = User::find($request->user_id);

        //cria o animal com o usuário encontrado
        $createAnimal = $user->animals()->create([
            'name' => $request->name,
            'breed' => $request->breed,
            'sex' => $request->sex,
            'weight' => $request->weight,
            'age' => $request->age,
            'picture_1' => $request->picture_1,
            'picture_2' => $request->picture_2,
            'description' => $request->description,
            'adopted' => $request->adopted,
            'animal_size_id' => $request->animal_size_id,
            'species_id' => $request->species_id,
            'address_id' => $user->address()->first()->id

        ]);

        $returnAnimal = Animal::with('owner.address.city.state', 'animalSize', 'species')->find($createAnimal->id);

        return response()->json($returnAnimal, 201);
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     */
    public function show(int $id)
    {
        $animal = Animal::with('owner.address.city.state', 'animalSize', 'species')->find($id);
        if ($animal === null){
            return response()->json(['message'=> 'Animal não encontrado'], 404);
        }
        return response()->json($animal);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy(int $id, Request $request)
    {
//        //Pega o token pelo header
//        $header_token =  $request->header('authorization');
//        $header_token = str_replace('Bearer ', '', $header_token);
//        //Procura a model do token
//        $token = PersonalAccessToken::findToken($header_token);
//        //se o id do usuário desse token for igual ao id do parâmetro da requisição ele deleta o usuário e o token
//        if($token->tokenable_id === $user){
//            $token->delete();
//            User::destroy($user);
//            return response()->noContent();
//        }
//        return response()->json(['message' => 'Não autorizado'], 401);
    }
}
