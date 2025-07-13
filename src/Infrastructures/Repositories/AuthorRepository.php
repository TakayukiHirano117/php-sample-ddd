<?php

namespace Infrastructures\Repositories;

use Domain\Model\Author\Author;
use Domain\Model\Author\AuthorId\AuthorId;
use Domain\Model\Author\AuthorName\AuthorName;
use Domain\Model\Author\Email\Email;
use Domain\Model\Author\Password\Password;
use Doctrine\DBAL\Connection;
use Config\DbConnection;
use Domain\Repositories\Author\IAuthorRepository;

class AuthorRepository implements IAuthorRepository
{
  private Connection $connection;

  public function __construct()
  {
    $this->connection = DbConnection::getConnection();
  }

  public function save(Author $author): void
  {
    $this->connection->insert('authors', [
      'id' => $author->getId()->getValue(),
      'name' => $author->getName()->getValue(),
      'email' => $author->getEmail()->getValue(),
      'password' => $author->getPassword()->getValue(),
    ]);
  }

  public function findById(AuthorId $id): ?Author
  {
    $sql = 'SELECT * FROM authors WHERE id = :id';
    $row = $this->connection->fetchAssociative($sql, ['id' => $id->getValue()]);
    if (!$row) {
      return null;
    }
    return new Author(
      new AuthorId($row['id']),
      new AuthorName($row['name']),
      new Email($row['email']),
      new Password($row['password']),
    );
  }

  public function delete(AuthorId $id): void
  {
    $this->connection->delete('authors', ['id' => $id->getValue()]);
  }

  public function findByEmail(Email $email): ?Author
  {
    $sql = 'SELECT * FROM authors WHERE email = :email';
    $row = $this->connection->fetchAssociative($sql, ['email' => $email->getValue()]);
    if (!$row) {
      return null;
    }
    return new Author(
      new AuthorId($row['id']),
      new AuthorName($row['name']),
      new Email($row['email']),
      new Password($row['password']),
    );
  }
}
