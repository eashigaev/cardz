<?php

namespace CardzApp\Api\Collect\Domain;

class ProgramTaskFeature
{
    private bool $repeatable;

    public static function of(bool $repeatable)
    {
        $self = new self();
        $self->repeatable = $repeatable;
        return $self;
    }

    public function isRepeatable()
    {
        return $this->repeatable;
    }
}
