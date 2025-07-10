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

    it('無効なUUID形式でBlogIdを作成しようとすると例外が発生する', function () {
        $invalidUuid = 'invalid-uuid-format';
        expect(fn() => new BlogId($invalidUuid))->toThrow(
            InvalidArgumentException::class,
            'BlogIdは36文字である必要があります'
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
});
