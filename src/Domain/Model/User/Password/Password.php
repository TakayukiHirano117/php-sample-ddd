<?php

namespace Domain\Model\User\Password;

use Domain\Model\ValueObject;
use InvalidArgumentException;

final class Password extends ValueObject
{
  const MAX_LENGTH = 100;
  const MIN_LENGTH = 8;

  public function __construct(string $value)
  {
    parent::__construct($value);
  }

  protected function validate(mixed $value): void
  {
    if (!is_string($value)) {
      throw new InvalidArgumentException('Passwordは文字列でなくてはいけません');
    }

    if ($this->isEmpty($value)) {
      throw new InvalidArgumentException('Passwordは空ではいけません');
    }

    if ($this->isTooShort($value)) {
      throw new InvalidArgumentException('Passwordは8文字以上である必要があります');
    }

    if ($this->isTooLong($value)) {
      throw new InvalidArgumentException('Passwordは100文字以内である必要があります');
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
