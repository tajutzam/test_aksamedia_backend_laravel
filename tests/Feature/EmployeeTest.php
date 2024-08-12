<?php

namespace Tests\Feature;

use App\Models\Division;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class EmployeeTest extends TestCase
{

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }


    public function test_it_stores_employee_successfully(): void
    {

        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        // Create a division for the employee
        $division = Division::factory()->create();

        // Fake the storage
        Storage::fake('public');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/employees', [
            'image' => UploadedFile::fake()->image('employee.jpg'),
            'name' => 'John Doe',
            'phone' => '1234567890',
            'division' => $division->id,
            'position' => 'Developer',
        ]);

        // Assert: Check the response and database
        $response->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'message' => 'Employee successfully created.'
            ]);

        $this->assertDatabaseHas('employees', [
            'name' => 'John Doe',
            'phone' => '1234567890',
            'division_id' => $division->id,
            'position' => 'Developer',
        ]);
    }

    public function test_it_stores_employee_unauthenticated()
    {
        $division = Division::factory()->create();
        Storage::fake('public');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ',
        ])->postJson('/api/employees', [
            'image' => UploadedFile::fake()->image('employee.jpg'),
            'name' => 'John Doe',
            'phone' => '1234567890',
            'division' => $division->id,
            'position' => 'Developer',
        ]);
        $response->assertStatus(401);
    }


    public function test_it_fetches_employees_successfully()
    {

        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        $division = Division::factory()->create();
        Storage::fake('public'); // Fake the storage

        $employee = Employee::factory()->create([
            'name' => 'John Doe',
            'image' => UploadedFile::fake()->image('employee.jpg')->store('images', 'public'),
            'division_id' => $division->id,
        ]);

        $employee2 = Employee::factory()->create([
            'name' => 'Jane Smith',
            'image' => UploadedFile::fake()->image('employee2.jpg')->store('images', 'public'),
            'division_id' => $division->id,
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->getJson('/api/employees?per_page=10&page=1');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'employees' => [
                        '*' => [
                            'id',
                            'name',
                            'image',
                            'phone',
                            'position',
                            'division' => [
                                'id',
                                'name',
                            ]
                        ],
                    ],
                ],
                'pagination' => [
                    'total',
                    'per_page',
                    'current_page',
                    'last_page',
                    'next_page_url',
                    'prev_page_url',
                    'last_page_url',
                    'first_page_url'
                ],
            ]);
    }

    public function test_it_deletes_employee_successfully()
    {

        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        $employee = Employee::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->deleteJson('/api/employees/' . $employee->id);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Success delete employee',
            ]);

        $this->assertDatabaseMissing('employees', [
            'id' => $employee->id,
        ]);
    }

    public function test_it_returns_error_when_employee_not_found()
    {
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;
        $nonExistentEmployeeId = 'non-existent-id';

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->deleteJson('/api/employees/' . $nonExistentEmployeeId);
        $response->assertStatus(404)
            ->assertJson([
                'status' => 'error',
                'message' => 'Failed to delete, employee not found',
            ]);
    }


    public function test_it_updates_employee_successfully()
    {

        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        $division = Division::factory()->create();
        $employee = Employee::factory()->create(['division_id' => $division->id]);

        Storage::fake('public');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '  . $token
        ])->putJson('/api/employees/' . $employee->id, [
            'name' => 'Updated Name',
            'phone' => '0987654321',
            'position' => 'Updated Position',
            'division' => $division->id,
            'image' => UploadedFile::fake()->image('updated_employee.jpg'),
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Employee successfully updated.'
            ]);

        $this->assertDatabaseHas('employees', [
            'id' => $employee->id,
            'name' => 'Updated Name',
            'phone' => '0987654321',
            'position' => 'Updated Position',
            'division_id' => $division->id,
        ]);
    }


    public function test_it_returns_error_if_employee_not_found()
    {

        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->putJson('/api/employees/non-existing-id', [
                'name' => 'Non-existing Employee',
                'phone' => '0000000000',
                'position' => 'Non-existing Position',
                'division' => Division::factory()->create()->id,
            ]);

        // Assert: Check the response
        $response->assertStatus(404)
            ->assertJson([
                'status' => 'error',
                'message' => 'Failed to update, employee not found',
            ]);
    }


    public function test_it_updates_employee_without_image()
    {

        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        $division = Division::factory()->create();
        $employee = Employee::factory()->create(['division_id' => $division->id]);


        $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->putJson('/api/employees/' . $employee->id, [
                'name' => 'Updated Name Without Image',
                'phone' => '1111111111',
                'position' => 'Updated Position Without Image',
                'division' => $division->id,
            ]);

        // Assert: Check the response and database
        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Employee successfully updated.'
            ]);

        $this->assertDatabaseHas('employees', [
            'id' => $employee->id,
            'name' => 'Updated Name Without Image',
            'phone' => '1111111111',
            'position' => 'Updated Position Without Image',
            'division_id' => $division->id,
        ]);
    }
}
