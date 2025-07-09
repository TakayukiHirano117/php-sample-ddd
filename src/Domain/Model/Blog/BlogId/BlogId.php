<?php

namespace Domain\Model\Blog\BlogId;

use Domain\Model\ValueObject;
use InvalidArgumentException;

final class BlogId extends ValueObject
{
    const MAX_LENGTH = 36;

    public function __construct(string $value)
    {
        parent::__construct($value);
    }

    // TODO: validateをcomparatorに変える
    protected function validate(mixed $value): void
    {
        if (!is_string($value)) {
            throw new InvalidArgumentException('BlogIdは文字列でなくてはいけません');
        }

        if ($this->isEmpty($value)) {
            throw new InvalidArgumentException('BlogIdは空ではいけません');
        }

        if ($this->isTooLong($value)) {
            throw new InvalidArgumentException('BlogIdは36文字以内である必要があります');
        }

        if (!$this->isUuidV4($value)) {
            throw new InvalidArgumentException('BlogIdはUUIDでなくてはいけません');
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

    private function isTooLong(string $value): bool
    {
        return strlen($value) > self::MAX_LENGTH;
    }
}