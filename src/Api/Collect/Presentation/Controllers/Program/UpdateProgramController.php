<?php

namespace CardzApp\Api\Collect\Presentation\Controllers\Program;

use App\Http\Controllers\Controller;
use CardzApp\Api\Collect\Application\Services\ProgramService;
use CardzApp\Api\Collect\Domain\ProgramProfile;
use CardzApp\Api\Collect\Domain\ProgramReward;
use CardzApp\Api\Shared\Presentation\ControllerTrait;
use Illuminate\Http\Request;

class UpdateProgramController extends Controller
{
    use ControllerTrait;

    public function __construct(
        private ProgramService $programService
    )
    {
    }

    public function __invoke(Request $request)
    {
        $profile = ProgramProfile::of(
            $request->title, $request->description
        );

        $reward = ProgramReward::of(
            $request->reward_title, $request->reward_target
        );

        $this->programService->updateProgram(
            $request->program, $profile, $reward
        );

        return $this->successResponse();
    }
}
