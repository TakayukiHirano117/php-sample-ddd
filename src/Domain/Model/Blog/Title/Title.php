<?php

namespace Domain\Model\Blog\Title;

use Domain\Model\ValueObject;
use InvalidArgumentException;

final class Title extends ValueObject
{
    const MAX_LENGTH = 100;
    const MIN_LENGTH = 1;

    public function __construct(string $value)
    {
        parent::__construct($value);
    }

    protected function validate(mixed $value): void
    {
        if (!is_string($value)) {
            throw new InvalidArgumentException('タイトルは文字列でなくてはいけません');
        }

        if ($this->isEmpty($value)) {
            throw new InvalidArgumentException('タイトルは空ではいけません');
        }

        if ($this->isTooShort($value)) {
            throw new InvalidArgumentException('タイトルは1文字以上である必要があります');
        }

        if ($this->isTooLong($value)) {
            throw new InvalidArgumentException('タイトルは100文字以内である必要があります');
        }
    }

    private function isEmpty(string $value): bool
    {
        return trim($value) === '';
    }

    private function isTooShort(string $value): bool
    {
        return strlen($value) < self::MIN_LENGTH;
    }

    private function isTooLong(string $value): bool
    {
        return strlen($value) > self::MAX_LENGTH;
    }
}