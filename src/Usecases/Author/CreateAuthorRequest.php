<?php

namespace Usecases\Author;

use Domain\Model\Author\Author;

class CreateAuthorRequest
{
  public function __construct(
    public readonly string $name,
    public readonly string $email,
    public readonly string $password,
  ) {}
}
