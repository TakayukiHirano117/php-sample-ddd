<?php

namespace Tests\Domain\Model\User\UserName;

use Domain\Model\User\UserName\UserName;
use InvalidArgumentException;

describe('UserName', function () {
  it('正常なユーザー名でUserNameを作成できる', function () {
    // Arrange
    $validUserName = 'テストユーザー';
    $userName = new UserName($validUserName);

    expect($userName->getValue())->toBe($validUserName);
  });

  it('空文字でUserNameを作成しようとすると例外が発生する', function () {
    expect(fn() => new UserName(''))->toThrow(
      InvalidArgumentException::class,
      'UserNameは空ではいけません'
    );
  });

  it('空白文字でUserNameを作成しようとすると例外が発生する', function () {
    expect(fn() => new UserName('   '))->toThrow(
      InvalidArgumentException::class,
      'UserNameは空ではいけません'
    );
  });

  it('100文字を超えるユーザー名でUserNameを作成しようとすると例外が発生する', function () {
    $tooLongUserName = str_repeat('a', 101);
    expect(fn() => new UserName($tooLongUserName))->toThrow(
      InvalidArgumentException::class,
      'UserNameは100文字以内である必要があります'
    );
  });

  it('境界値の1文字のユーザー名で正常に作成できる', function () {
    $oneCharUserName = 'a';
    $userName = new UserName($oneCharUserName);

    expect($userName->getValue())->toBe($oneCharUserName);
  });

  it('境界値の100文字のユーザー名で正常に作成できる', function () {
    $hundredCharUserName = str_repeat('a', 100);
    $userName = new UserName($hundredCharUserName);

    expect($userName->getValue())->toBe($hundredCharUserName);
  });

  it('同じ値のUserName同士は等しいと判定される', function () {
    $userNameValue = 'テストユーザー';
    $userName1 = new UserName($userNameValue);
    $userName2 = new UserName($userNameValue);

    expect($userName1->isEquals($userName2))->toBeTrue();
  });

  it('異なる値のUserName同士は等しくないと判定される', function () {
    $userName1 = new UserName('ユーザー1');
    $userName2 = new UserName('ユーザー2');

    expect($userName1->isEquals($userName2))->toBeFalse();
  });

  it('getValueメソッドで正しい値を取得できる', function () {
    $userNameValue = 'テストユーザー';
    $userName = new UserName($userNameValue);

    expect($userName->getValue())->toBe($userNameValue);
  });

  it('様々な文字種を含むユーザー名で正常に作成できる', function () {
    $complexUserName = 'John Doe 123 ユーザー名！@#$%^&*()_-.';
    $userName = new UserName($complexUserName);

    expect($userName->getValue())->toBe($complexUserName);
  });
});
