<?php

namespace Infrastructures\InMemory\Author;

use Domain\Model\Author\Author;
use Domain\Model\Author\AuthorId\AuthorId;
use Domain\Model\Author\Email\Email;
use Domain\Repositories\Author\IAuthorRepository;

class InMemoryAuthorRepository implements IAuthorRepository
{

  public array $DB = [];

  public function save(Author $author): void
  {
    $this->DB[$author->getId()->getValue()] = $author;
  }

  public function findById(AuthorId $id): ?Author
  {
    return $this->DB[$id->getValue()] ?? null;
  }

  public function findByEmail(Email $email): ?Author
  {
    foreach ($this->DB as $author) {
      if ($author->getEmail()->isEquals($email)) {
        return $author;
      }
    }
    return null;
  }

  public function delete(AuthorId $id): void
  {
    unset($this->DB[$id->getValue()]);
  }
}
