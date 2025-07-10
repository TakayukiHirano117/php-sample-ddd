<?php

namespace Tests\Domain\Model\User;

use Domain\Model\User\User;
use Domain\Model\User\UserId\UserId;
use Domain\Model\User\UserName\UserName;
use Domain\Model\User\Password\Password;
use Domain\Model\User\Email\Email;

describe('User', function () {
  it('createでUserを生成できる', function () {
    $id = new UserId('550e8400-e29b-41d4-a716-446655440000');
    $name = new UserName('テストユーザー');
    $password = new Password('password123');
    $email = new Email('test@example.com');
    $user = User::create($id, $name, $password, $email);
    expect($user->getId())->toBe($id);
    expect($user->getName())->toBe($name);
    expect($user->getPassword())->toBe($password);
    expect($user->getEmail())->toBe($email);
  });

  it('reconstructでUserを復元できる', function () {
    $id = new UserId('550e8400-e29b-41d4-a716-446655440000');
    $name = new UserName('テストユーザー');
    $password = new Password('password123');
    $email = new Email('test@example.com');
    $user = User::reconstruct($id, $name, $password, $email);
    expect($user->getId())->toBe($id);
    expect($user->getName())->toBe($name);
    expect($user->getPassword())->toBe($password);
    expect($user->getEmail())->toBe($email);
  });

  it('changeNameでユーザー名を変更できる', function () {
    $id = new UserId('550e8400-e29b-41d4-a716-446655440000');
    $name = new UserName('テストユーザー');
    $password = new Password('password123');
    $email = new Email('test@example.com');
    $user = User::create($id, $name, $password, $email);
    $newName = new UserName('新しいユーザー名');
    $user->changeName($newName);
    expect($user->getName())->toBe($newName);
  });

  it('changePasswordでパスワードを変更できる', function () {
    $id = new UserId('550e8400-e29b-41d4-a716-446655440000');
    $name = new UserName('テストユーザー');
    $password = new Password('password123');
    $email = new Email('test@example.com');
    $user = User::create($id, $name, $password, $email);
    $newPassword = new Password('newpassword123');
    $user->changePassword($newPassword);
    expect($user->getPassword())->toBe($newPassword);
  });

  it('changeEmailでメールアドレスを変更できる', function () {
    $id = new UserId('550e8400-e29b-41d4-a716-446655440000');
    $name = new UserName('テストユーザー');
    $password = new Password('password123');
    $email = new Email('test@example.com');
    $user = User::create($id, $name, $password, $email);
    $newEmail = new Email('new@example.com');
    $user->changeEmail($newEmail);
    expect($user->getEmail())->toBe($newEmail);
  });
});
