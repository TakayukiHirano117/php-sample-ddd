<?php

namespace Tests\Domain\Model\Author\AuthorName;

use Domain\Model\Author\AuthorName\AuthorName;
use InvalidArgumentException;

describe('AuthorName', function () {
  it('正常な著者名でAuthorNameを作成できる', function () {
    // Arrange
    $validAuthorName = 'テスト著者';
    $authorName = new AuthorName($validAuthorName);

    expect($authorName->getValue())->toBe($validAuthorName);
  });

  it('空文字でAuthorNameを作成しようとすると例外が発生する', function () {
    expect(fn() => new AuthorName(''))->toThrow(
      InvalidArgumentException::class,
      'AuthorNameは空ではいけません'
    );
  });

  it('空白文字でAuthorNameを作成しようとすると例外が発生する', function () {
    expect(fn() => new AuthorName('   '))->toThrow(
      InvalidArgumentException::class,
      'AuthorNameは空ではいけません'
    );
  });

  it('100文字を超える著者名でAuthorNameを作成しようとすると例外が発生する', function () {
    $tooLongAuthorName = str_repeat('a', 101);
    expect(fn() => new AuthorName($tooLongAuthorName))->toThrow(
      InvalidArgumentException::class,
      'AuthorNameは100文字以内である必要があります'
    );
  });

  it('境界値の1文字の著者名で正常に作成できる', function () {
    $oneCharAuthorName = 'a';
    $authorName = new AuthorName($oneCharAuthorName);

    expect($authorName->getValue())->toBe($oneCharAuthorName);
  });

  it('境界値の100文字の著者名で正常に作成できる', function () {
    $hundredCharAuthorName = str_repeat('a', 100);
    $authorName = new AuthorName($hundredCharAuthorName);

    expect($authorName->getValue())->toBe($hundredCharAuthorName);
  });

  it('同じ値のAuthorName同士は等しいと判定される', function () {
    $authorNameValue = 'テスト著者';
    $authorName1 = new AuthorName($authorNameValue);
    $authorName2 = new AuthorName($authorNameValue);

    expect($authorName1->isEquals($authorName2))->toBeTrue();
  });

  it('異なる値のAuthorName同士は等しくないと判定される', function () {
    $authorName1 = new AuthorName('著者1');
    $authorName2 = new AuthorName('著者2');

    expect($authorName1->isEquals($authorName2))->toBeFalse();
  });

  it('getValueメソッドで正しい値を取得できる', function () {
    $authorNameValue = 'テスト著者';
    $authorName = new AuthorName($authorNameValue);

    expect($authorName->getValue())->toBe($authorNameValue);
  });

  it('様々な文字種を含む著者名で正常に作成できる', function () {
    $complexAuthorName = 'John Doe 123 著者名！@#$%^&*()_-.';
    $authorName = new AuthorName($complexAuthorName);

    expect($authorName->getValue())->toBe($complexAuthorName);
  });
});
