<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\City;
use App\Models\PhoneNumber;
use App\Models\State;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * Action_Verb_WhoOrWhatToDo_ExpectedBehavior
     */

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->state = State::factory()->create();
        $this->city = City::factory()->create();
        $this->user = Sanctum::actingAs(
            User::factory()
            ->has(PhoneNumber::factory(), 'phones')
            ->has(Address::factory(), 'address')->create(),
            ['*']
        );
    }


    public function test_check_if_user_can_see_another_user_profile()
    {
        //action
        $response = $this->getJson(route('users.show', ['user' => 1]));

        //assertion
        $response->assertStatus(200);
        $this->assertEquals($response->json()['name'],$this->user->name);
    }

    public function test_check_if_user_can_signUp()
    {
        //action
        $response = $this->postJson(route('users.store'), [
            'name' => 'emilio barbosa',
            'email' => 'emilio@email.com',
            'email_confirmation' => 'emilio@email.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
            'phone_number' => '48984189420',
            'phone_number_whatsapp' => 1,
            'street' => 'rua jaime bianchini',
            'neighborhood' => 'pontal',
            'city_id' => 1
        ]);

        //assert
        $response->assertStatus(201);
        $this->assertEquals('emilio barbosa', $response->json()['name']);
        $this->assertDatabaseHas('users', ['name'=>'emilio barbosa']);
    }

    public function test_assure_that_user_cant_signUp_without_required_field()
    {
        $this->withExceptionHandling();

        //action
        $response = $this->postJson(route('users.store'), [
            'name' => '',
            'email' => 'emilio@email.com',
            'password' => '12345678',
            'phone_number' => '48984189420',
            'phone_number_whatsapp' => 1,
            'street' => 'rua jaime bianchini',
            'neighborhood' => 'pontal',
            'city_id' => 1
        ]);

        //assert
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);
    }

    public function test_check_if_user_can_update_his_profile()
    {
        //action
        $response = $this->putJson(route('users.update', ['user' => 1]), [
            'name' => 'João Silva',
            'email' => $this->user->email,
            'phone_number' => '48984189420',
            'phone_number_whatsapp' => 1,
            'street' => 'rua jaime bianchini',
            'neighborhood' => 'pontal',
            'city_id' => 1
        ]);

        //assert
        $response->assertStatus(200);
        $this->assertEquals('João Silva', $response->json()['name']);
    }

    public function test_check_if_user_can_delete_his_account()
    {
        //action
        $response = $this->deleteJson(route('users.destroy', ['user' => 1]));
        $users = count(User::all());

        //assert
        $response->assertStatus(204);
        $this->assertEquals(0, $users);
    }

    public function test_assert_that_user_cant_update_his_email_with_one_being_used()
    {
        $this->withExceptionHandling();

        //action
        $userTest = User::factory()
            ->has(PhoneNumber::factory(), 'phones')
            ->has(Address::factory(), 'address')->create();

        $response = $this->putJson(route('users.update', ['user' => 1]), [
            'name' => $this->user->name,
            'email' => $userTest->email,
            'phone_number' => '48984189420',
            'phone_number_whatsapp' => 1,
            'street' => 'rua jaime bianchini',
            'neighborhood' => 'pontal',
            'city_id' => 1
        ]);

        //assert
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);

    }

    public function test_assure_that_user_cant_update_his_profile_without_required_field()
    {
        $this->withExceptionHandling();

        //action
        $response = $this->putJson(route('users.update',['user' => 1]),[
            'name' => $this->user->name,
            'email' => '',
            'phone_number' => '48984189420',
            'phone_number_whatsapp' => 1,
            'street' => 'rua jaime bianchini',
            'neighborhood' => 'pontal',
            'city_id' => 1
        ]);

        //assert
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }


}
