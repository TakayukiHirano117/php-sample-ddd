<?php

namespace Domain\Services\Author;

use Domain\Model\Author\Email\Email;
use Domain\Repositories\Author\IAuthorRepository;

class isDuplicateEmail
{
  public function __construct(private IAuthorRepository $authorRepository) {}

  public function execute(Email $email): bool
  {
    $author = $this->authorRepository->findByEmail($email);

    return $author !== null;
  }
}
