<?php

namespace CardzApp\Api\Collect\Presentation\Transformers;

use App\Models\Collect\Program;
use Illuminate\Database\Eloquent\Model;

class ProgramTransformer
{
    public function preview(Model|Program $model): array
    {
        return [
            'id' => $model->id,
            'company_id' => $model->company_id,
            'title' => $model->title,
            'description' => $model->description,
            'available' => $model->available
        ];
    }

    public function detail(Model|Program $model): array
    {
        return [
            ...$this->preview($model),
            'reward' => [
                'title' => $model->reward_title,
                'target' => $model->reward_target
            ]
        ];
    }
}
