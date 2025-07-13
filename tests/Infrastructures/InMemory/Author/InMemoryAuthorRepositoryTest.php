<?php

namespace Tests\Infrastructures\InMemory\Author;

use Domain\Model\Author\Author;
use Domain\Model\Author\AuthorId\AuthorId;
use Domain\Model\Author\AuthorName\AuthorName;
use Domain\Model\Author\Password\Password;
use Domain\Model\Author\Email\Email;
use Exception;
use Infrastructures\InMemory\Author\InMemoryAuthorRepository;

describe('InMemoryAuthorRepository', function () {
  beforeEach(function () {
    $this->repository = new InMemoryAuthorRepository();
  });

  it('saveでAuthorを保存できる', function () {
    // Arrange
    $authorId = new AuthorId('550e8400-e29b-41d4-a716-446655440000');
    $authorName = new AuthorName('テスト著者');
    $password = new Password('password123');
    $email = new Email('test@example.com');
    $author = Author::create($authorId, $authorName, $password, $email);

    // Act
    $this->repository->save($author);

    // Assert
    expect($this->repository->DB)->toHaveKey($authorId->getValue());
    expect($this->repository->DB[$authorId->getValue()])->toBe($author);
  });

  it('findByIdで保存されたAuthorを取得できる', function () {
    // Arrange
    $authorId = new AuthorId('550e8400-e29b-41d4-a716-446655440000');
    $authorName = new AuthorName('テスト著者');
    $password = new Password('password123');
    $email = new Email('test@example.com');
    $author = Author::create($authorId, $authorName, $password, $email);
    $this->repository->save($author);

    // Act
    $foundAuthor = $this->repository->findById($authorId);

    // Assert
    expect($foundAuthor)->toBe($author);
  });

  it('findByIdで存在しないAuthorIdの場合はnullを返す', function () {
    // Arrange
    $nonExistentId = new AuthorId('550e8400-e29b-41d4-a716-446655440001');

    // Act
    $foundAuthor = $this->repository->findById($nonExistentId);

    // Assert
    expect($foundAuthor)->toBeNull();
  });

  it('findByEmailで保存されたAuthorを取得できる', function () {
    // Arrange
    $authorId = new AuthorId('550e8400-e29b-41d4-a716-446655440000');
    $authorName = new AuthorName('テスト著者');
    $password = new Password('password123');
    $email = new Email('test@example.com');
    $author = Author::create($authorId, $authorName, $password, $email);
    $this->repository->save($author);

    // Act
    $foundAuthor = $this->repository->findByEmail($email);

    // Assert
    expect($foundAuthor)->toBe($author);
  });

  it('findByEmailで存在しないEmailの場合はnullを返す', function () {
    // Arrange
    $nonExistentEmail = new Email('nonexistent@example.com');

    // Act
    $foundAuthor = $this->repository->findByEmail($nonExistentEmail);

    // Assert
    expect($foundAuthor)->toBeNull();
  });

  it('deleteで保存されたAuthorを削除できる', function () {
    // Arrange
    $authorId = new AuthorId('550e8400-e29b-41d4-a716-446655440000');
    $authorName = new AuthorName('テスト著者');
    $password = new Password('password123');
    $email = new Email('test@example.com');
    $author = Author::create($authorId, $authorName, $password, $email);
    $this->repository->save($author);

    // Act
    $this->repository->delete($authorId);

    // Assert
    expect($this->repository->DB)->not->toHaveKey($authorId->getValue());
    expect($this->repository->findById($authorId))->toBeNull();
  });

  it('複数のAuthorを保存して個別に取得できる', function () {
    // Arrange
    $authorId1 = new AuthorId('550e8400-e29b-41d4-a716-446655440000');
    $authorName1 = new AuthorName('著者1');
    $password1 = new Password('password123');
    $email1 = new Email('author1@example.com');
    $author1 = Author::create($authorId1, $authorName1, $password1, $email1);

    $authorId2 = new AuthorId('550e8400-e29b-41d4-a716-446655440001');
    $authorName2 = new AuthorName('著者2');
    $password2 = new Password('password456');
    $email2 = new Email('author2@example.com');
    $author2 = Author::create($authorId2, $authorName2, $password2, $email2);

    $this->repository->save($author1);
    $this->repository->save($author2);

    // Act & Assert
    expect($this->repository->findById($authorId1))->toBe($author1);
    expect($this->repository->findById($authorId2))->toBe($author2);
    expect($this->repository->findByEmail($email1))->toBe($author1);
    expect($this->repository->findByEmail($email2))->toBe($author2);
  });

  it('同じAuthorIdで上書き保存できる', function () {
    // Arrange
    $authorId = new AuthorId('550e8400-e29b-41d4-a716-446655440000');
    $authorName1 = new AuthorName('元の著者');
    $password1 = new Password('password123');
    $email1 = new Email('original@example.com');
    $author1 = Author::create($authorId, $authorName1, $password1, $email1);

    $authorName2 = new AuthorName('更新された著者');
    $password2 = new Password('newpassword123');
    $email2 = new Email('updated@example.com');
    $author2 = Author::create($authorId, $authorName2, $password2, $email2);

    $this->repository->save($author1);

    // Act
    $this->repository->save($author2);

    // Assert
    expect($this->repository->findById($authorId))->toBe($author2);
    expect($this->repository->findById($authorId))->not->toBe($author1);
  });

  it('存在しないAuthorIdを削除してもエラーが発生しない', function () {
    // Arrange
    $nonExistentId = new AuthorId('550e8400-e29b-41d4-a716-446655440001');

    // Act & Assert
    expect(fn() => $this->repository->delete($nonExistentId))->not->toThrow(Exception::class);
  });
});
