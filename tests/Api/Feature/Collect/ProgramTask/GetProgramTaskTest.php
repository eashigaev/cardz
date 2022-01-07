<?php

namespace Tests\Api\Feature\Collect\ProgramTask;

use App\Models\Collect\ProgramTask;
use CardzApp\Api\Shared\Application\Actions;
use CardzApp\Api\Shared\Presentation\Routes;
use Tests\Api\Support\ModuleTestTrait;
use Tests\TestCase;

class GetProgramTaskTest extends TestCase
{
    private const ROUTE = Routes::COLLECT_GET_PROGRAM_TASK;

    use ModuleTestTrait;

    public function test_access()
    {
        $this->assertAuthenticatedRoute(self::ROUTE);
        $this->assertAuthorizedRoute(self::ROUTE, Actions::COLLECT_GET_PROGRAM_TASK);
    }

    public function test_action()
    {
        $task = ProgramTask::factory()->create();

        $this->actingAsSanctum($task->company->founder);

        $response = $this->callJsonRoute(self::ROUTE, parameters: [
            'task' => $task->id
        ]);
        $response->assertStatus(200);

        $response->assertJson([
            'id' => $task->id,
            'company_id' => $task->company->id,
            'program_id' => $task->program->id,
            'title' => $task->title,
            'description' => $task->description,
            'available' => $task->available
        ]);
    }
}
