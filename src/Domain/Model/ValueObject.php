<?php

namespace Domain\Model;

abstract class ValueObject
{
    protected readonly mixed $value;

    public function __construct(mixed $value)
    {
        $this->validate($value);
        $this->value = $value;
    }

    protected abstract function validate(mixed $value): void;

    public function isEquals(ValueObject $other): bool
    {
        return $this->value === $other->value;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }
}