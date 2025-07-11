<?php

namespace Domain\Services\Author;

use Domain\Model\Author\IAuthorRepository;
use Domain\Model\Author\Email\Email;

class isDuplicateEmail
{
  public function __construct(private IAuthorRepository $authorRepository) {}

  public function execute(Email $email): bool
  {
    $author = $this->authorRepository->findByEmail($email);

    return $author !== null;
  }
}
