<?php

namespace Domain\Model\Blog\Body;

use Domain\Model\ValueObject;
use InvalidArgumentException;

final class Body extends ValueObject
{
  const MAX_LENGTH = 10000;
  const MIN_LENGTH = 1;

  public function __construct(string $value)
  {
    parent::__construct($value);
  }

  protected function validate(mixed $value): void
  {
    if (!is_string($value)) {
      throw new InvalidArgumentException('本文は文字列でなくてはいけません');
    }

    if ($this->isEmpty($value)) {
      throw new InvalidArgumentException('本文は空ではいけません');
    }

    if ($this->isTooShort($value)) {
      throw new InvalidArgumentException('本文は1文字以上である必要があります');
    }

    if ($this->isTooLong($value)) {
      throw new InvalidArgumentException('本文は10000文字以内である必要があります');
    }
  }

  private function isEmpty(string $value): bool
  {
    return trim($value) === '';
  }

  private function isTooLong(string $value): bool
  {
    return strlen($value) > self::MAX_LENGTH;
  }

  private function isTooShort(string $value): bool
  {
    return strlen($value) < self::MIN_LENGTH;
  }
}
