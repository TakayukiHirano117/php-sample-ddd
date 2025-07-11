<?php

namespace Tests\Domain\Model\Author;

use Domain\Model\Author\Author;
use Domain\Model\Author\AuthorId\AuthorId;
use Domain\Model\Author\AuthorName\AuthorName;
use Domain\Model\Author\Password\Password;
use Domain\Model\Author\Email\Email;

describe('Author', function () {
  it('createでAuthorを生成できる', function () {
    $id = new AuthorId('550e8400-e29b-41d4-a716-446655440000');
    $name = new AuthorName('テスト著者');
    $password = new Password('password123');
    $email = new Email('test@example.com');
    $author = Author::create($id, $name, $password, $email);
    expect($author->getId())->toBe($id);
    expect($author->getName())->toBe($name);
    expect($author->getPassword())->toBe($password);
    expect($author->getEmail())->toBe($email);
  });

  it('reconstructでAuthorを復元できる', function () {
    $id = new AuthorId('550e8400-e29b-41d4-a716-446655440000');
    $name = new AuthorName('テスト著者');
    $password = new Password('password123');
    $email = new Email('test@example.com');
    $author = Author::reconstruct($id, $name, $password, $email);
    expect($author->getId())->toBe($id);
    expect($author->getName())->toBe($name);
    expect($author->getPassword())->toBe($password);
    expect($author->getEmail())->toBe($email);
  });

  it('changeNameで著者名を変更できる', function () {
    $id = new AuthorId('550e8400-e29b-41d4-a716-446655440000');
    $name = new AuthorName('テスト著者');
    $password = new Password('password123');
    $email = new Email('test@example.com');
    $author = Author::create($id, $name, $password, $email);
    $newName = new AuthorName('新しい著者名');
    $author->changeName($newName);
    expect($author->getName())->toBe($newName);
  });

  it('changePasswordでパスワードを変更できる', function () {
    $id = new AuthorId('550e8400-e29b-41d4-a716-446655440000');
    $name = new AuthorName('テスト著者');
    $password = new Password('password123');
    $email = new Email('test@example.com');
    $author = Author::create($id, $name, $password, $email);
    $newPassword = new Password('newpassword123');
    $author->changePassword($newPassword);
    expect($author->getPassword())->toBe($newPassword);
  });

  it('changeEmailでメールアドレスを変更できる', function () {
    $id = new AuthorId('550e8400-e29b-41d4-a716-446655440000');
    $name = new AuthorName('テスト著者');
    $password = new Password('password123');
    $email = new Email('test@example.com');
    $author = Author::create($id, $name, $password, $email);
    $newEmail = new Email('new@example.com');
    $author->changeEmail($newEmail);
    expect($author->getEmail())->toBe($newEmail);
  });
});
