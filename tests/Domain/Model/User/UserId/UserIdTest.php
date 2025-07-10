<?php

namespace Tests\Domain\Model\User\UserId;

use Domain\Model\User\UserId\UserId;
use InvalidArgumentException;

describe('UserId', function () {
  it('正常なUUID v4でUserIdを作成できる', function () {
    // Arrange
    $validUuid = '550e8400-e29b-41d4-a716-446655440000';
    $userId = new UserId($validUuid);

    expect($userId->getValue())->toBe($validUuid);
  });

  it('空文字でUserIdを作成しようとすると例外が発生する', function () {
    expect(fn() => new UserId(''))->toThrow(
      InvalidArgumentException::class,
      'UserIdは空ではいけません'
    );
  });

  it('空白文字でUserIdを作成しようとすると例外が発生する', function () {
    expect(fn() => new UserId('   '))->toThrow(
      InvalidArgumentException::class,
      'UserIdは空ではいけません'
    );
  });

  it('無効なUUID形式でUserIdを作成しようとすると例外が発生する', function () {
    $invalidUuid = 'invalid-uuid-format';
    expect(fn() => new UserId($invalidUuid))->toThrow(
      InvalidArgumentException::class,
      'UserIdは36文字である必要があります'
    );
  });

  it('UUID v4以外の形式でUserIdを作成しようとすると例外が発生する', function () {
    // UUID v1形式（4番目の部分が4で始まらない）
    $uuidV1 = '550e8400-e29b-11d4-a716-446655440000';
    expect(fn() => new UserId($uuidV1))->toThrow(
      InvalidArgumentException::class,
      'UserIdはUUIDでなくてはいけません'
    );
  });

  it('36文字より短いUUIDでUserIdを作成しようとすると例外が発生する', function () {
    $tooShortUuid = '550e8400-e29b-41d4-a716-44665544000';
    expect(fn() => new UserId($tooShortUuid))->toThrow(
      InvalidArgumentException::class,
      'UserIdは36文字である必要があります'
    );
  });

  it('36文字より長いUUIDでUserIdを作成しようとすると例外が発生する', function () {
    $tooLongUuid = '550e8400-e29b-41d4-a716-4466554400000';
    expect(fn() => new UserId($tooLongUuid))->toThrow(
      InvalidArgumentException::class,
      'UserIdは36文字である必要があります'
    );
  });

  it('同じ値のUserId同士は等しいと判定される', function () {
    $uuid = '550e8400-e29b-41d4-a716-446655440000';
    $userId1 = new UserId($uuid);
    $userId2 = new UserId($uuid);

    expect($userId1->isEquals($userId2))->toBeTrue();
  });

  it('異なる値のUserId同士は等しくないと判定される', function () {
    $userId1 = new UserId('550e8400-e29b-41d4-a716-446655440000');
    $userId2 = new UserId('550e8400-e29b-41d4-a716-446655440001');

    expect($userId1->isEquals($userId2))->toBeFalse();
  });

  it('getValueメソッドで正しい値を取得できる', function () {
    $uuid = '550e8400-e29b-41d4-a716-446655440000';
    $userId = new UserId($uuid);

    expect($userId->getValue())->toBe($uuid);
  });

  it('大文字小文字が混在したUUIDでも正常に作成できる', function () {
    $mixedCaseUuid = '550E8400-E29B-41D4-A716-446655440000';
    $userId = new UserId($mixedCaseUuid);

    expect($userId->getValue())->toBe($mixedCaseUuid);
  });

  it('境界値の36文字のUUIDで正常に作成できる', function () {
    $boundaryUuid = '550e8400-e29b-41d4-a716-446655440000';
    $userId = new UserId($boundaryUuid);

    expect($userId->getValue())->toBe($boundaryUuid);
  });
});
