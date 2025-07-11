<?php

namespace Tests\Domain\Model\Author\AuthorId;

use Domain\Model\Author\AuthorId\AuthorId;
use InvalidArgumentException;

describe('AuthorId', function () {
  it('正常なUUID v4でAuthorIdを作成できる', function () {
    // Arrange
    $validUuid = '550e8400-e29b-41d4-a716-446655440000';
    $authorId = new AuthorId($validUuid);

    expect($authorId->getValue())->toBe($validUuid);
  });

  it('空文字でAuthorIdを作成しようとすると例外が発生する', function () {
    expect(fn() => new AuthorId(''))->toThrow(
      InvalidArgumentException::class,
      'AuthorIdは空ではいけません'
    );
  });

  it('空白文字でAuthorIdを作成しようとすると例外が発生する', function () {
    expect(fn() => new AuthorId('   '))->toThrow(
      InvalidArgumentException::class,
      'AuthorIdは空ではいけません'
    );
  });

  it('無効なUUID形式でAuthorIdを作成しようとすると例外が発生する', function () {
    $invalidUuid = 'invalid-uuid-format';
    expect(fn() => new AuthorId($invalidUuid))->toThrow(
      InvalidArgumentException::class,
      'AuthorIdは36文字である必要があります'
    );
  });

  it('UUID v4以外の形式でAuthorIdを作成しようとすると例外が発生する', function () {
    // UUID v1形式（4番目の部分が4で始まらない）
    $uuidV1 = '550e8400-e29b-11d4-a716-446655440000';
    expect(fn() => new AuthorId($uuidV1))->toThrow(
      InvalidArgumentException::class,
      'AuthorIdはUUIDでなくてはいけません'
    );
  });

  it('36文字より短いUUIDでAuthorIdを作成しようとすると例外が発生する', function () {
    $tooShortUuid = '550e8400-e29b-41d4-a716-44665544000';
    expect(fn() => new AuthorId($tooShortUuid))->toThrow(
      InvalidArgumentException::class,
      'AuthorIdは36文字である必要があります'
    );
  });

  it('36文字より長いUUIDでAuthorIdを作成しようとすると例外が発生する', function () {
    $tooLongUuid = '550e8400-e29b-41d4-a716-4466554400000';
    expect(fn() => new AuthorId($tooLongUuid))->toThrow(
      InvalidArgumentException::class,
      'AuthorIdは36文字である必要があります'
    );
  });

  it('同じ値のAuthorId同士は等しいと判定される', function () {
    $uuid = '550e8400-e29b-41d4-a716-446655440000';
    $authorId1 = new AuthorId($uuid);
    $authorId2 = new AuthorId($uuid);

    expect($authorId1->isEquals($authorId2))->toBeTrue();
  });

  it('異なる値のAuthorId同士は等しくないと判定される', function () {
    $authorId1 = new AuthorId('550e8400-e29b-41d4-a716-446655440000');
    $authorId2 = new AuthorId('550e8400-e29b-41d4-a716-446655440001');

    expect($authorId1->isEquals($authorId2))->toBeFalse();
  });

  it('getValueメソッドで正しい値を取得できる', function () {
    $uuid = '550e8400-e29b-41d4-a716-446655440000';
    $authorId = new AuthorId($uuid);

    expect($authorId->getValue())->toBe($uuid);
  });

  it('大文字小文字が混在したUUIDでも正常に作成できる', function () {
    $mixedCaseUuid = '550E8400-E29B-41D4-A716-446655440000';
    $authorId = new AuthorId($mixedCaseUuid);

    expect($authorId->getValue())->toBe($mixedCaseUuid);
  });

  it('境界値の36文字のUUIDで正常に作成できる', function () {
    $boundaryUuid = '550e8400-e29b-41d4-a716-446655440000';
    $authorId = new AuthorId($boundaryUuid);

    expect($authorId->getValue())->toBe($boundaryUuid);
  });
});
