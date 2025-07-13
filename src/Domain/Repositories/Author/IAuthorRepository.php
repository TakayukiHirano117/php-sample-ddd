<?php

namespace Domain\Repositories\Author;

use Domain\Model\Author\Author;
use Domain\Model\Author\AuthorId\AuthorId;
use Domain\Model\Author\Email\Email;

interface IAuthorRepository
{
  public function save(Author $author): void;
  public function findById(AuthorId $id): ?Author;
  public function findByEmail(Email $email): ?Author;
  public function delete(AuthorId $id): void;
}
