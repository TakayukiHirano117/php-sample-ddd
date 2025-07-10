<?php

namespace Tests\Domain\Model\User\Password;

use Domain\Model\User\Password\Password;
use InvalidArgumentException;

describe('Password', function () {
  it('正常なパスワードでPasswordを作成できる', function () {
    // Arrange
    $validPassword = 'password123';
    $password = new Password($validPassword);

    expect($password->getValue())->toBe($validPassword);
  });

  it('空文字でPasswordを作成しようとすると例外が発生する', function () {
    expect(fn() => new Password(''))->toThrow(
      InvalidArgumentException::class,
      'Passwordは空ではいけません'
    );
  });

  it('空白文字でPasswordを作成しようとすると例外が発生する', function () {
    expect(fn() => new Password('   '))->toThrow(
      InvalidArgumentException::class,
      'Passwordは空ではいけません'
    );
  });

  it('8文字未満のパスワードでPasswordを作成しようとすると例外が発生する', function () {
    $tooShortPassword = 'pass123';
    expect(fn() => new Password($tooShortPassword))->toThrow(
      InvalidArgumentException::class,
      'Passwordは8文字以上である必要があります'
    );
  });

  it('100文字を超えるパスワードでPasswordを作成しようとすると例外が発生する', function () {
    $tooLongPassword = str_repeat('a', 101);
    expect(fn() => new Password($tooLongPassword))->toThrow(
      InvalidArgumentException::class,
      'Passwordは100文字以内である必要があります'
    );
  });

  it('境界値の8文字のパスワードで正常に作成できる', function () {
    $boundaryPassword = 'password';
    $password = new Password($boundaryPassword);

    expect($password->getValue())->toBe($boundaryPassword);
  });

  it('境界値の100文字のパスワードで正常に作成できる', function () {
    $boundaryPassword = str_repeat('a', 100);
    $password = new Password($boundaryPassword);

    expect($password->getValue())->toBe($boundaryPassword);
  });

  it('同じ値のPassword同士は等しいと判定される', function () {
    $passwordValue = 'password123';
    $password1 = new Password($passwordValue);
    $password2 = new Password($passwordValue);

    expect($password1->isEquals($password2))->toBeTrue();
  });

  it('異なる値のPassword同士は等しくないと判定される', function () {
    $password1 = new Password('password1');
    $password2 = new Password('password2');

    expect($password1->isEquals($password2))->toBeFalse();
  });

  it('getValueメソッドで正しい値を取得できる', function () {
    $passwordValue = 'password123';
    $password = new Password($passwordValue);

    expect($password->getValue())->toBe($passwordValue);
  });

  it('様々な文字種を含むパスワードで正常に作成できる', function () {
    $complexPassword = 'MySecurePassword@2024! パスワード_123';
    $password = new Password($complexPassword);

    expect($password->getValue())->toBe($complexPassword);
  });
});
