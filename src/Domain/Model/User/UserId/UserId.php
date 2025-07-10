<?php

namespace Domain\Model\User\UserId;

use Domain\Model\ValueObject;
use InvalidArgumentException;

final class UserId extends ValueObject
{
    const LENGTH = 36;

    public function __construct(string $value)
    {
        parent::__construct($value);
    }

    protected function validate(mixed $value): void
    {
        if (!is_string($value)) {
            throw new InvalidArgumentException('UserIdは文字列でなくてはいけません');
        }

        if ($this->isEmpty($value)) {
            throw new InvalidArgumentException('UserIdは空ではいけません');
        }

        if ($this->isLengthInvalid($value)) {
            throw new InvalidArgumentException('UserIdは36文字である必要があります');
        }

        if (!$this->isUuidV4($value)) {
            throw new InvalidArgumentException('UserIdはUUIDでなくてはいけません');
        }
    }

    private function isUuidV4(string $value): bool
    {
        return preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i', $value) === 1;
    }

    private function isEmpty(string $value): bool
    {
        return trim($value) === '';
    }

    private function isLengthInvalid(string $value): bool
    {
        return strlen($value) !== self::LENGTH;
    }
}
