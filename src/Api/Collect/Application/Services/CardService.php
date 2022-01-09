<?php

namespace CardzApp\Api\Collect\Application\Services;

use App\Models\Collect\Card;
use App\Models\Collect\Program;
use CardzApp\Api\Account\Application\Services\UserService;
use CardzApp\Api\Collect\Domain\CardStatus;
use CardzApp\Api\Collect\Domain\Exceptions;
use Codderz\YokoLite\Domain\Uuid\UuidGenerator;
use Codderz\YokoLite\Shared\Exception;

class CardService
{
    public function __construct(
        private UuidGenerator $uuidGenerator,
        private UserService   $userService
    )
    {
    }

    public function issueCard(string $programId, string $holderId, string $comment)
    {
        $program = Program::query()->findOrFail($programId);

        if (!$program->active) {
            throw Exceptions::programIsNotActive();
        }

        $holder = $this->userService->getUser($holderId);

        $card = Card::make();

        $card->id = $this->uuidGenerator->getNextValue();
        $card->status = CardStatus::ACTIVE->value;
        $card->balance = 0;
        $card->comment = $comment;
        $card->company()->associate($program->company_id);
        $card->program()->associate($program->id);
        $card->holder()->associate($holder->id);

        $card->save();

        return $card->id;
    }

    public function updateCard(string $cardId, string $comment)
    {
        $card = Card::query()->findOrFail($cardId);

        $card->comment = $comment;

        return $card->save();
    }

    public function rewardCard(string $cardId)
    {
        $card = Card::query()
            ->with('program')
            ->where('status', CardStatus::ACTIVE->value)
            ->findOrFail($cardId);

        if (!$card->program->active) {
            throw Exception::of('Card program is not active');
        }

        if ($card->balance < $card->program->reward_target) {
            throw Exception::of('Card balance is not enough');
        }

        $card->status = CardStatus::REWARDED->value;

        return $card->save();
    }

    public function rejectCard(string $cardId)
    {
        return Card::query()
            ->where('status', CardStatus::ACTIVE->value)
            ->findOrFail($cardId)
            ->setAttribute('status', CardStatus::REWARDED)
            ->save();
    }

    public function cancelCard(string $cardId)
    {
        return Card::query()
            ->where('status', CardStatus::ACTIVE->value)
            ->findOrFail($cardId)
            ->setAttribute('status', CardStatus::CANCELLED)
            ->save();
    }

    //

    public function getCards(string $programId)
    {
        return Card::query()
            ->with('program')
            ->where('program', $programId)
            ->limit(100)
            ->get();
    }

    public function getCard(string $cardId)
    {
        return Card::query()
            ->findOrFail($cardId);
    }
}
