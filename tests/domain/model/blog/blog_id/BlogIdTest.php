<?php

namespace Tests\Domain\Model\Blog\BlogId;

use Domain\Model\Blog\BlogId\BlogId;
use InvalidArgumentException;

describe('BlogId', function () {
    it('正常なUUID v4でBlogIdを作成できる', function () {
        // Arrange
        $validUuid = '550e8400-e29b-41d4-a716-446655440000';
        $blogId = new BlogId($validUuid);
        
        expect($blogId->getValue())->toBe($validUuid);
    });

    it('空文字でBlogIdを作成しようとすると例外が発生する', function () {
        expect(fn() => new BlogId(''))->toThrow(
            InvalidArgumentException::class,
            'BlogIdは空ではいけません'
        );
    });

    it('空白文字でBlogIdを作成しようとすると例外が発生する', function () {
        expect(fn() => new BlogId('   '))->toThrow(
            InvalidArgumentException::class,
            'BlogIdは空ではいけません'
        );
    });

    it('無効なUUID形式でBlogIdを作成しようとすると例外が発生する', function () {
        $invalidUuid = 'invalid-uuid-format';
        expect(fn() => new BlogId($invalidUuid))->toThrow(
            InvalidArgumentException::class,
            'BlogIdはUUIDでなくてはいけません'
        );
    });

    it('UUID v4以外の形式でBlogIdを作成しようとすると例外が発生する', function () {
        // UUID v1形式（4番目の部分が4で始まらない）
        $uuidV1 = '550e8400-e29b-11d4-a716-446655440000';
        expect(fn() => new BlogId($uuidV1))->toThrow(
            InvalidArgumentException::class,
            'BlogIdはUUIDでなくてはいけません'
        );
    });

    it('最大長を超えるUUIDでBlogIdを作成しようとすると例外が発生する', function () {
        $tooLongUuid = '550e8400-e29b-41d4-a716-446655440000-extra-long-part';
        expect(fn() => new BlogId($tooLongUuid))->toThrow(
            InvalidArgumentException::class,
            'BlogIdは100文字以内である必要があります'
        );
    });

    it('同じ値のBlogId同士は等しいと判定される', function () {
        $uuid = '550e8400-e29b-41d4-a716-446655440000';
        $blogId1 = new BlogId($uuid);
        $blogId2 = new BlogId($uuid);
        
        expect($blogId1->isEquals($blogId2))->toBeTrue();
    });

    it('異なる値のBlogId同士は等しくないと判定される', function () {
        $blogId1 = new BlogId('550e8400-e29b-41d4-a716-446655440000');
        $blogId2 = new BlogId('550e8400-e29b-41d4-a716-446655440001');
        
        expect($blogId1->isEquals($blogId2))->toBeFalse();
    });

    it('getValueメソッドで正しい値を取得できる', function () {
        $uuid = '550e8400-e29b-41d4-a716-446655440000';
        $blogId = new BlogId($uuid);
        
        expect($blogId->getValue())->toBe($uuid);
    });

    it('大文字小文字が混在したUUIDでも正常に作成できる', function () {
        $mixedCaseUuid = '550E8400-E29B-41D4-A716-446655440000';
        $blogId = new BlogId($mixedCaseUuid);
        
        expect($blogId->getValue())->toBe($mixedCaseUuid);
    });

    it('境界値の36文字のUUIDで正常に作成できる', function () {
        $boundaryUuid = '550e8400-e29b-41d4-a716-446655440000';
        $blogId = new BlogId($boundaryUuid);
        
        expect($blogId->getValue())->toBe($boundaryUuid);
    });
});

