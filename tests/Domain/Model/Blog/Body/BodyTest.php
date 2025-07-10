<?php

namespace Tests\Domain\Model\Blog\Body;

use Domain\Model\Blog\Body\Body;
use InvalidArgumentException;

describe('Body', function () {
  it('正常な本文でBodyを作成できる', function () {
    // Arrange
    $validBody = 'これはテスト用のブログ本文です。';
    $body = new Body($validBody);

    expect($body->getValue())->toBe($validBody);
  });

  it('空文字でBodyを作成しようとすると例外が発生する', function () {
    expect(fn() => new Body(''))->toThrow(
      InvalidArgumentException::class,
      '本文は空ではいけません'
    );
  });

  it('空白文字でBodyを作成しようとすると例外が発生する', function () {
    expect(fn() => new Body('   '))->toThrow(
      InvalidArgumentException::class,
      '本文は空ではいけません'
    );
  });

  it('0文字の本文でBodyを作成しようとすると例外が発生する', function () {
    expect(fn() => new Body(''))->toThrow(
      InvalidArgumentException::class,
      '本文は空ではいけません'
    );
  });

  it('10000文字を超える本文でBodyを作成しようとすると例外が発生する', function () {
    $tooLongBody = str_repeat('a', 10001);
    expect(fn() => new Body($tooLongBody))->toThrow(
      InvalidArgumentException::class,
      '本文は10000文字以内である必要があります'
    );
  });

  it('境界値の1文字の本文で正常に作成できる', function () {
    $oneCharBody = 'a';
    $body = new Body($oneCharBody);

    expect($body->getValue())->toBe($oneCharBody);
  });

  it('境界値の10000文字の本文で正常に作成できる', function () {
    $tenThousandCharBody = str_repeat('a', 10000);
    $body = new Body($tenThousandCharBody);

    expect($body->getValue())->toBe($tenThousandCharBody);
  });

  it('同じ値のBody同士は等しいと判定される', function () {
    $bodyValue = 'テスト用の本文';
    $body1 = new Body($bodyValue);
    $body2 = new Body($bodyValue);

    expect($body1->isEquals($body2))->toBeTrue();
  });

  it('異なる値のBody同士は等しくないと判定される', function () {
    $body1 = new Body('本文1');
    $body2 = new Body('本文2');

    expect($body1->isEquals($body2))->toBeFalse();
  });

  it('getValueメソッドで正しい値を取得できる', function () {
    $bodyValue = 'テスト用の本文';
    $body = new Body($bodyValue);

    expect($body->getValue())->toBe($bodyValue);
  });

  it('日本語の本文で正常に作成できる', function () {
    $japaneseBody = 'これは日本語のブログ本文です。長い文章でも問題ありません。';
    $body = new Body($japaneseBody);

    expect($body->getValue())->toBe($japaneseBody);
  });

  it('英数字の本文で正常に作成できる', function () {
    $englishBody = 'This is a test blog body with English text and numbers 123.';
    $body = new Body($englishBody);

    expect($body->getValue())->toBe($englishBody);
  });

  it('改行を含む本文で正常に作成できる', function () {
    $multilineBody = "これは\n複数行の\n本文です。";
    $body = new Body($multilineBody);

    expect($body->getValue())->toBe($multilineBody);
  });

  it('記号を含む本文で正常に作成できる', function () {
    $symbolBody = '本文に記号を含む：！@#$%^&*()_+-=[]{}|;:,.<>?';
    $body = new Body($symbolBody);

    expect($body->getValue())->toBe($symbolBody);
  });

  it('長い文章の本文で正常に作成できる', function () {
    $longBody = str_repeat('これは長い文章のテストです。', 100);
    $body = new Body($longBody);

    expect($body->getValue())->toBe($longBody);
  });

  it('HTMLタグを含む本文で正常に作成できる', function () {
    $htmlBody = '<p>これは<strong>HTMLタグ</strong>を含む本文です。</p>';
    $body = new Body($htmlBody);

    expect($body->getValue())->toBe($htmlBody);
  });
});
