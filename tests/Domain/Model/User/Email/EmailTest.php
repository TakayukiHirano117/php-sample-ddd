<?php

namespace Tests\Domain\Model\User\Email;

use Domain\Model\User\Email\Email;
use InvalidArgumentException;

describe('Email', function () {
  it('正常なメールアドレスでEmailを作成できる', function () {
    // Arrange
    $validEmail = 'test@example.com';
    $email = new Email($validEmail);

    expect($email->getValue())->toBe($validEmail);
  });

  it('空文字でEmailを作成しようとすると例外が発生する', function () {
    expect(fn() => new Email(''))->toThrow(
      InvalidArgumentException::class,
      'Emailは空ではいけません'
    );
  });

  it('空白文字でEmailを作成しようとすると例外が発生する', function () {
    expect(fn() => new Email('   '))->toThrow(
      InvalidArgumentException::class,
      'Emailは空ではいけません'
    );
  });

  it('5文字未満のメールアドレスでEmailを作成しようとすると例外が発生する', function () {
    $tooShortEmail = 'a@b';
    expect(fn() => new Email($tooShortEmail))->toThrow(
      InvalidArgumentException::class,
      'Emailは5文字以上である必要があります'
    );
  });

  it('254文字を超えるメールアドレスでEmailを作成しようとすると例外が発生する', function () {
    $tooLongEmail = str_repeat('a', 250) . '@example.com';
    expect(fn() => new Email($tooLongEmail))->toThrow(
      InvalidArgumentException::class,
      'Emailは254文字以内である必要があります'
    );
  });

  it('@記号がないメールアドレスでEmailを作成しようとすると例外が発生する', function () {
    $invalidEmail = 'testexample.com';
    expect(fn() => new Email($invalidEmail))->toThrow(
      InvalidArgumentException::class,
      'Emailの形式が正しくありません'
    );
  });

  it('@記号が複数あるメールアドレスでEmailを作成しようとすると例外が発生する', function () {
    $invalidEmail = 'test@example@com';
    expect(fn() => new Email($invalidEmail))->toThrow(
      InvalidArgumentException::class,
      'Emailの形式が正しくありません'
    );
  });

  it('ローカル部分が空のメールアドレスでEmailを作成しようとすると例外が発生する', function () {
    $invalidEmail = '@example.com';
    expect(fn() => new Email($invalidEmail))->toThrow(
      InvalidArgumentException::class,
      'Emailの形式が正しくありません'
    );
  });

  it('ドメイン部分が空のメールアドレスでEmailを作成しようとすると例外が発生する', function () {
    $invalidEmail = 'test@';
    expect(fn() => new Email($invalidEmail))->toThrow(
      InvalidArgumentException::class,
      'Emailの形式が正しくありません'
    );
  });

  it('ドメインにドットがないメールアドレスでEmailを作成しようとすると例外が発生する', function () {
    $invalidEmail = 'test@examplecom';
    expect(fn() => new Email($invalidEmail))->toThrow(
      InvalidArgumentException::class,
      'Emailの形式が正しくありません'
    );
  });

  it('ドメインがドットで終わるメールアドレスでEmailを作成しようとすると例外が発生する', function () {
    $invalidEmail = 'test@example.';
    expect(fn() => new Email($invalidEmail))->toThrow(
      InvalidArgumentException::class,
      'Emailの形式が正しくありません'
    );
  });

  it('境界値の5文字のメールアドレスで正常に作成できる', function () {
    $boundaryEmail = 'a@b.c';
    $email = new Email($boundaryEmail);

    expect($email->getValue())->toBe($boundaryEmail);
  });

  it('境界値の254文字のメールアドレスで正常に作成できる', function () {
    $localPart = str_repeat('a', 64);
    $domainPart = str_repeat('b', 185) . '.com';
    $boundaryEmail = $localPart . '@' . $domainPart;
    expect(strlen($boundaryEmail))->toBe(254);
    $email = new Email($boundaryEmail);
    expect($email->getValue())->toBe($boundaryEmail);
  });

  it('同じ値のEmail同士は等しいと判定される', function () {
    $emailValue = 'test@example.com';
    $email1 = new Email($emailValue);
    $email2 = new Email($emailValue);

    expect($email1->isEquals($email2))->toBeTrue();
  });

  it('異なる値のEmail同士は等しくないと判定される', function () {
    $email1 = new Email('test1@example.com');
    $email2 = new Email('test2@example.com');

    expect($email1->isEquals($email2))->toBeFalse();
  });

  it('getValueメソッドで正しい値を取得できる', function () {
    $emailValue = 'test@example.com';
    $email = new Email($emailValue);

    expect($email->getValue())->toBe($emailValue);
  });

  it('特殊文字を含むメールアドレスで正常に作成できる', function () {
    $specialEmail = 'test+tag.name@example-domain.com';
    $email = new Email($specialEmail);

    expect($email->getValue())->toBe($specialEmail);
  });

  it('大文字小文字が混在したメールアドレスで正常に作成できる', function () {
    $mixedCaseEmail = 'Test.User@Example.COM';
    $email = new Email($mixedCaseEmail);

    expect($email->getValue())->toBe($mixedCaseEmail);
  });
});
