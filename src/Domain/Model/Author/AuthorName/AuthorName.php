<?php

namespace Domain\Model\Author\AuthorName;

use Domain\Model\ValueObject;
use InvalidArgumentException;

final class AuthorName extends ValueObject
{
  const MAX_LENGTH = 100;
  const MIN_LENGTH = 1;

  public function __construct(string $value)
  {
    parent::__construct($value);
  }

  protected function validate(mixed $value): void
  {
    if ($this->isTooLong($value)) {
      throw new InvalidArgumentException('AuthorNameは100文字以内である必要があります');
    }
    
    if (!is_string($value)) {
      throw new InvalidArgumentException('AuthorNameは文字列でなくてはいけません');
    }

    if ($this->isEmpty($value)) {
      throw new InvalidArgumentException('AuthorNameは空ではいけません');
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


}