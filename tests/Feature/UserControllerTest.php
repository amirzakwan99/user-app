<?php

namespace Tests\Feature;

use App\Exports\UsersExport;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function index_displays_user_list()
    {
        $user = User::factory()->create();

        $response = $this->get(route('user.index'));

        $response->assertStatus(200);
        $response->assertViewIs('user.index');
    }

    /** @test */
    public function store_creates_new_user()
    {
        $this->withoutMiddleware(); // skip CSRF

        $data = [
            'name' => 'John Doe',
            'phone_number' => '+60123456789',
            'email' => 'john@example.com',
            'status' => User::STATUS_ACTIVE,
            'password' => 'password123'
        ];

        $response = $this->post(route('user.store'), $data);

        $response->assertRedirect(route('user.index'));
        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
            'name' => 'John Doe'
        ]);
    }

    /** @test */
    public function update_modifies_existing_user()
    {
        $this->withoutMiddleware(); // skip CSRF
        
        $user = User::factory()->create();

        $data = [
            'name' => 'Jane Doe',
            'phone_number' => $user->phone_number,
            'email' => $user->email,
            'status' => User::STATUS_ACTIVE,
            'password' => 'newpassword'
        ];

        $response = $this->put(route('user.update', $user->id), $data);

        $response->assertRedirect(route('user.index'));
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Jane Doe'
        ]);
    }

    /** @test */
    public function destroy_soft_deletes_user()
    {
        $this->withoutMiddleware(); // skip CSRF

        $user = User::factory()->create();

        $response = $this->delete(route('user.destroy', $user->id));

        $response->assertRedirect(route('user.index'));
        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }

    /** @test */
    public function destroy_bulk_soft_deletes_users()
    {
        $this->withoutMiddleware(); // skip CSRF

        $users = User::factory()->count(3)->create();

        $ids = $users->pluck('id')->toArray();

        $response = $this->delete(route('user.destroy-bulk'), ['ids' => $ids]);

        $response->assertRedirect(route('user.index'));
        foreach ($ids as $id) {
            $this->assertSoftDeleted('users', ['id' => $id]);
        }
    }

    /** @test */
    public function export_downloads_excel_file()
    {
        Excel::fake();

        $response = $this->get(route('user.export'));

        Excel::assertDownloaded('users.xlsx', function (UsersExport $export) {
            return true;
        });
    }
}
