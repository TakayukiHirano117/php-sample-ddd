<?php

namespace Infrastructures\Repositories;

use Domain\Model\Author\Author;
use Domain\Model\Author\AuthorId\AuthorId;
use Domain\Model\Author\AuthorName\AuthorName;
use Domain\Model\Author\Email\Email;
use Domain\Model\Author\Password\Password;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Domain\Repositories\Author\IAuthorRepository;

class AuthorRepository implements IAuthorRepository
{
  public function __construct(private Connection $connection) {}

  public function save(Author $author): void
  {
    try {
      $sql = 'INSERT INTO authors (id, name, email, password, created_at, updated_at) VALUES (:id, :name, :email, :password, :created_at, :updated_at)';

      $params = [
        'id' => $author->getId()->getValue(),
        'name' => $author->getName()->getValue(),
        'email' => $author->getEmail()->getValue(),
        'password' => $author->getPassword()->getValue(),
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ];

      $this->connection->executeStatement($sql, $params);
    } catch (Exception $e) {
      throw new \RuntimeException('Authorの保存に失敗しました: ' . $e->getMessage(), 0, $e);
    }
  }

  public function update(Author $author): void
  {
    $sql = 'UPDATE authors SET name = :name, email = :email, password = :password, updated_at = :updated_at WHERE id = :id';

    $params = [
      'id' => $author->getId()->getValue(),
      'name' => $author->getName()->getValue(),
      'email' => $author->getEmail()->getValue(),
      'password' => $author->getPassword()->getValue(),
      'updated_at' => date('Y-m-d H:i:s'),
    ];

    $this->connection->executeStatement($sql, $params);
  }

  public function findById(AuthorId $id): ?Author
  {
    $sql = 'SELECT id, name, email, password FROM authors WHERE id = :id';
    $row = $this->connection->fetchAssociative($sql, ['id' => $id->getValue()]);

    if (!$row) {
      return null;
    }

    return Author::reconstruct(
      new AuthorId($row['id']),
      new AuthorName($row['name']),
      new Password($row['password']),
      new Email($row['email'])
    );
  }

  public function delete(AuthorId $id): void
  {
    $sql = 'DELETE FROM authors WHERE id = :id';
    $this->connection->executeStatement($sql, ['id' => $id->getValue()]);
  }

  public function findByEmail(Email $email): ?Author
  {
    $sql = 'SELECT id, name, email, password FROM authors WHERE email = :email';
    $row = $this->connection->fetchAssociative($sql, ['email' => $email->getValue()]);

    if (!$row) {
      return null;
    }

    return Author::reconstruct(
      new AuthorId($row['id']),
      new AuthorName($row['name']),
      new Password($row['password']),
      new Email($row['email'])
    );
  }
}
