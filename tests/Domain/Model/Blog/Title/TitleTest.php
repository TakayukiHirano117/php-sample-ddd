<?php

namespace Tests\Domain\Model\Blog\Title;

use Domain\Model\Blog\Title\Title;
use InvalidArgumentException;

describe('Title', function () {
  it('正常なタイトルでTitleを作成できる', function () {
    // Arrange
    $validTitle = 'テストタイトル';
    $title = new Title($validTitle);

    expect($title->getValue())->toBe($validTitle);
  });

  it('空文字でTitleを作成しようとすると例外が発生する', function () {
    expect(fn() => new Title(''))->toThrow(
      InvalidArgumentException::class,
      'タイトルは空ではいけません'
    );
  });

  it('空白文字でTitleを作成しようとすると例外が発生する', function () {
    expect(fn() => new Title('   '))->toThrow(
      InvalidArgumentException::class,
      'タイトルは空ではいけません'
    );
  });

  it('0文字のタイトルでTitleを作成しようとすると例外が発生する', function () {
    expect(fn() => new Title(''))->toThrow(
      InvalidArgumentException::class,
      'タイトルは空ではいけません'
    );
  });

  it('100文字を超えるタイトルでTitleを作成しようとすると例外が発生する', function () {
    $tooLongTitle = str_repeat('a', 101);
    expect(fn() => new Title($tooLongTitle))->toThrow(
      InvalidArgumentException::class,
      'タイトルは100文字以内である必要があります'
    );
  });

  it('境界値の1文字のタイトルで正常に作成できる', function () {
    $oneCharTitle = 'a';
    $title = new Title($oneCharTitle);

    expect($title->getValue())->toBe($oneCharTitle);
  });

  it('境界値の100文字のタイトルで正常に作成できる', function () {
    $hundredCharTitle = str_repeat('a', 100);
    $title = new Title($hundredCharTitle);

    expect($title->getValue())->toBe($hundredCharTitle);
  });

  it('同じ値のTitle同士は等しいと判定される', function () {
    $titleValue = 'テストタイトル';
    $title1 = new Title($titleValue);
    $title2 = new Title($titleValue);

    expect($title1->isEquals($title2))->toBeTrue();
  });

  it('異なる値のTitle同士は等しくないと判定される', function () {
    $title1 = new Title('タイトル1');
    $title2 = new Title('タイトル2');

    expect($title1->isEquals($title2))->toBeFalse();
  });

  it('getValueメソッドで正しい値を取得できる', function () {
    $titleValue = 'テストタイトル';
    $title = new Title($titleValue);

    expect($title->getValue())->toBe($titleValue);
  });

  it('日本語のタイトルで正常に作成できる', function () {
    $japaneseTitle = 'ブログのタイトルです';
    $title = new Title($japaneseTitle);

    expect($title->getValue())->toBe($japaneseTitle);
  });

  it('英数字のタイトルで正常に作成できる', function () {
    $englishTitle = 'Blog Title 123';
    $title = new Title($englishTitle);

    expect($title->getValue())->toBe($englishTitle);
  });

  it('記号を含むタイトルで正常に作成できる', function () {
    $symbolTitle = 'タイトル！@#$%^&*()';
    $title = new Title($symbolTitle);

    expect($title->getValue())->toBe($symbolTitle);
  });
});
