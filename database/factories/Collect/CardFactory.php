<?php

namespace Database\Factories\Collect;

use App\Models\Collect\Card;
use App\Models\Collect\Program;
use App\Models\Company;
use App\Models\User;
use CardzApp\Api\Collect\Domain\CardStatus;
use Codderz\YokoLite\Domain\Uuid\UuidTestTrait;
use Illuminate\Database\Eloquent\Factories\Factory;

class CardFactory extends Factory
{
    use UuidTestTrait;

    public $model = Card::class;

    public function definition()
    {
        $company = Company::factory()->create();

        return [
            'id' => $this->uuidGenerator()->getNextValue(),
            'company_id' => $company,
            'program_id' => Program::factory()->for($company),
            'holder_id' => User::factory(),
            'balance' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->realText(),
            'status' => $this->faker->randomElement(CardStatus::cases())->value
        ];
    }

    public function withStatus(CardStatus $status)
    {
        return $this->state(fn() => [
            'status' => $status->value
        ]);
    }
}
