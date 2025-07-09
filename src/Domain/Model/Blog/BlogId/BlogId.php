<?php

namespace Domain\Model\Blog\BlogId;

use InvalidArgumentException;

final class BlogId
{
    private string $value;
    const MAX_LENGTH = 36;

    public function __construct(string $value)
    {
        $this->validate($value);
        $this->value = $value;
    }

    private function validate(string $value): void
    {
        if ($this->isEmpty($value)) {
            throw new InvalidArgumentException('BlogIdは空ではいけません');
        }

        if ($this->isTooLong($value)) {
            throw new InvalidArgumentException('BlogIdは100文字以内である必要があります');
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

    // TODO: 厳密な等価判定をするcomparatorを使いたい
    public function isEquals(BlogId $other): bool
    {
        return $this->value === $other->value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}