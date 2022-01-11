<?php

namespace CardzApp\Api\Collect\Controllers\Achievement;

use App\Http\Controllers\Controller;
use CardzApp\Api\Shared\ControllerTrait;
use CardzApp\Modules\Collect\Application\Services\AchievementService;
use Illuminate\Http\Request;

class AddAchievementController extends Controller
{
    use ControllerTrait;

    public function __construct(
        private AchievementService $achievementService,
    )
    {
    }

    public function __invoke(Request $request)
    {
        $achievementId = $this->achievementService->addAchievement(
            $request->card, $request->task
        );

        return $this->successResponse([
            'id' => $achievementId
        ]);
    }
}
