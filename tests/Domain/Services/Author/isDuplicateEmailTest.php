<?php

namespace Tests\Domain\Services\Author;

use Domain\Services\Author\isDuplicateEmail;
use Domain\Model\Author\Email\Email;
use Domain\Model\Author\Author;
use Domain\Model\Author\AuthorId\AuthorId;
use Domain\Model\Author\AuthorName\AuthorName;
use Domain\Model\Author\Password\Password;
use Infrastructures\InMemory\Author\InMemoryAuthorRepository;

describe('isDuplicateEmail', function () {
  beforeEach(function () {
    $this->repository = new InMemoryAuthorRepository();
    $this->service = new isDuplicateEmail($this->repository);
  });

  it('存在するEmailの場合はtrueを返す', function () {
    // Arrange
    $email = new Email('test@example.com');
    $authorId = new AuthorId('550e8400-e29b-41d4-a716-446655440000');
    $authorName = new AuthorName('テスト著者');
    $password = new Password('password123');
    $author = Author::create($authorId, $authorName, $password, $email);
    $this->repository->save($author);

    // Act
    $result = $this->service->execute($email);

    // Assert
    expect($result)->toBe(true);
  });

  it('存在しないEmailの場合はfalseを返す', function () {
    // Arrange
    $nonExistentEmail = new Email('nonexistent@example.com');

    // Act
    $result = $this->service->execute($nonExistentEmail);

    // Assert
    expect($result)->toBe(false);
  });

  it('異なるEmailの場合はfalseを返す', function () {
    // Arrange
    $existingEmail = new Email('existing@example.com');
    $differentEmail = new Email('different@example.com');
    $authorId = new AuthorId('550e8400-e29b-41d4-a716-446655440000');
    $authorName = new AuthorName('テスト著者');
    $password = new Password('password123');
    $author = Author::create($authorId, $authorName, $password, $existingEmail);
    $this->repository->save($author);

    // Act
    $result = $this->service->execute($differentEmail);

    // Assert
    expect($result)->toBe(false);
  });

  it('空のリポジトリの場合はfalseを返す', function () {
    // Arrange
    $email = new Email('test@example.com');

    // Act
    $result = $this->service->execute($email);

    // Assert
    expect($result)->toBe(false);
  });
});
