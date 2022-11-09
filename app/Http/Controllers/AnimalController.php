<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnimalRequest;
use App\Http\Requests\UpdateAnimalRequest;
use App\Models\Animal;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Laravel\Sanctum\PersonalAccessToken;

class AnimalController extends Controller
{

    public function __construct()
    {
        //Middleware não irá verificar o token na rota index e show
        $this->middleware('auth:sanctum')->except('index', 'show', 'store');
    }

    /**
     * Mostra todos os animais para adoção
     *
     * @return Animal
     */
    public function index()
    {
        return Animal::all();
    }

    /**
     * Adiciona um animal
     * @param StoreAnimalRequest $request
     * @return JsonResponse
     */
    public function store(StoreAnimalRequest $request)
    {
        $user = User::find($request->user_id);

        //salva as fotos do animal
        $images = $request->file('images');
        $imagesNames = [];
        foreach ($images as $image){
            $path = $image->storePublicly('/images/animals');
            $imagesNames[] = $path;
        }

        //cria o animal com o usuário encontrado
        $createAnimal = $user->animals()->create([
            'name' => $request->name,
            'breed' => $request->breed,
            'sex' => $request->sex,
            'weight' => $request->weight,
            'age' => $request->age,
            'picture_1' => $imagesNames[0],
            'picture_2' => count($imagesNames) > 1 ? $imagesNames[1] : null,
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
     * Mostra um animal específico.
     * @param  int  $id
     * @return JsonResponse
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
     * Atualiza um animal
     * @param UpdateAnimalRequest $request
     * @param Animal $animal
     * @return JsonResponse
     */
    public function update(UpdateAnimalRequest $request, Animal $animal)
    {
        $animal->update([
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
        ]);

        $returnAnimal = Animal::with('owner.address.city.state', 'animalSize', 'species')->find($animal->id);

        return response()->json($returnAnimal);
    }

    /**
     * Deleta um animal
     * @param  Animal  $animal
     * @param Request $request
     */
    public function destroy(Animal $animal, Request $request)
    {
        $ownerId = $animal->owner->id;
        //Pega o token pelo header
        $header_token =  $request->header('authorization');
        $header_token = str_replace('Bearer ', '', $header_token);
        //Procura a model do token
        $token = PersonalAccessToken::findToken($header_token);
        //se o id do usuário desse token for igual ao id do dono do animal ele deleta o animal
        if($token->tokenable_id === $ownerId){
            Animal::destroy($animal->id);
            return response()->noContent();
        }
        return response()->json(['message' => 'Não autorizado'], 401);
    }
}
