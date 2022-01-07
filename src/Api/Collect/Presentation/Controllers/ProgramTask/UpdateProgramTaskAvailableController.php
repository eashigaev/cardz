<?php

namespace CardzApp\Api\Collect\Presentation\Controllers\ProgramTask;

use App\Http\Controllers\Controller;
use CardzApp\Api\Collect\Application\Services\ProgramTaskService;
use CardzApp\Api\Shared\Presentation\ControllerTrait;
use Illuminate\Http\Request;

class UpdateProgramTaskAvailableController extends Controller
{
    use ControllerTrait;

    public function __construct(
        private ProgramTaskService $programTaskService,
    )
    {
    }

    public function __invoke(Request $request)
    {
        $this->programTaskService->updateProgramTaskAvailable(
            $request->task, $request->value
        );

        return $this->successResponse();
    }
}
