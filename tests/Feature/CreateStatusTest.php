<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\TaskStatus;
use App\Models\User;
use Tests\TestCase;

class CreateStatusTest extends TestCase
{
	public User $user;
	public TaskStatus $status;
	
	public function setUp(): void
    {
		parent::setUp();
		$this->user = User::factory()->create();
		$this->status = TaskStatus::factory()->create();
    }
	
	public function testIndex(): void
	{
		 $response = $this->get(route('task_statuses.index'));
		 $response->assertOk();

	}
	
    public function testCreate(): void
    {
        $response = $this->actingAs($this->user)->get(route('task_statuses.create'));
        $response->assertOk();
    }
	
	public function testStore(): void
    {	
		$newstatus = 'Новый статус';
        $response = $this->actingAs($this->user)->post(route('task_statuses.store'),
		['name' => $newstatus]
		);
		$response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('task_statuses', [
            'name' => $newstatus,
        ]);
    }
	public function testEdit(): void
    {
        $response = $this->actingAs($this->user)->get(route('task_statuses.edit', $this->status->id));
        $response->assertOk();
    }

}
