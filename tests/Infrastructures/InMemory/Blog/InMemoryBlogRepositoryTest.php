<?php

namespace Tests\Infrastructures\InMemory\Blog;

use Domain\Model\Blog\Blog;
use Domain\Model\Blog\BlogId\BlogId;
use Domain\Model\Blog\Title\Title;
use Domain\Model\Blog\Body\Body;
use Domain\Model\Author\AuthorId\AuthorId;
use Exception;
use Infrastructures\InMemory\Blog\InMemoryBlogRepository;

describe('InMemoryBlogRepository', function () {
  beforeEach(function () {
    $this->repository = new InMemoryBlogRepository();
  });

  it('saveでBlogを保存できる', function () {
    // Arrange
    $blogId = new BlogId('550e8400-e29b-41d4-a716-446655440000');
    $title = new Title('テストブログ');
    $body = new Body('これはテストブログの本文です。');
    $authorId = new AuthorId('550e8400-e29b-41d4-a716-446655440001');
    $blog = Blog::create($blogId, $title, $body, $authorId);

    // Act
    $this->repository->save($blog);

    // Assert
    expect($this->repository->DB)->toHaveKey($blogId->getValue());
    expect($this->repository->DB[$blogId->getValue()])->toBe($blog);
  });

  it('findByIdで保存されたBlogを取得できる', function () {
    // Arrange
    $blogId = new BlogId('550e8400-e29b-41d4-a716-446655440000');
    $title = new Title('テストブログ');
    $body = new Body('これはテストブログの本文です。');
    $authorId = new AuthorId('550e8400-e29b-41d4-a716-446655440001');
    $blog = Blog::create($blogId, $title, $body, $authorId);
    $this->repository->save($blog);

    // Act
    $foundBlog = $this->repository->findById($blogId);

    // Assert
    expect($foundBlog)->toBe($blog);
  });

  it('findByIdで存在しないBlogIdの場合はnullを返す', function () {
    // Arrange
    $nonExistentId = new BlogId('550e8400-e29b-41d4-a716-446655440001');

    // Act
    $foundBlog = $this->repository->findById($nonExistentId);

    // Assert
    expect($foundBlog)->toBeNull();
  });

  it('findAllで保存された全てのBlogを取得できる', function () {
    // Arrange
    $blogId1 = new BlogId('550e8400-e29b-41d4-a716-446655440000');
    $title1 = new Title('ブログ1');
    $body1 = new Body('これはブログ1の本文です。');
    $authorId1 = new AuthorId('550e8400-e29b-41d4-a716-446655440001');
    $blog1 = Blog::create($blogId1, $title1, $body1, $authorId1);

    $blogId2 = new BlogId('550e8400-e29b-41d4-a716-446655440002');
    $title2 = new Title('ブログ2');
    $body2 = new Body('これはブログ2の本文です。');
    $authorId2 = new AuthorId('550e8400-e29b-41d4-a716-446655440003');
    $blog2 = Blog::create($blogId2, $title2, $body2, $authorId2);

    $this->repository->save($blog1);
    $this->repository->save($blog2);

    // Act
    $allBlogs = $this->repository->findAll();

    // Assert
    expect($allBlogs)->toHaveCount(2);
    expect($allBlogs)->toContain($blog1);
    expect($allBlogs)->toContain($blog2);
  });

  it('findAllで保存されたBlogがない場合は空配列を返す', function () {
    // Act
    $allBlogs = $this->repository->findAll();

    // Assert
    expect($allBlogs)->toBe([]);
  });

  it('updateで保存されたBlogを更新できる', function () {
    // Arrange
    $blogId = new BlogId('550e8400-e29b-41d4-a716-446655440000');
    $title1 = new Title('元のブログ');
    $body1 = new Body('これは元のブログの本文です。');
    $authorId = new AuthorId('550e8400-e29b-41d4-a716-446655440001');
    $blog1 = Blog::create($blogId, $title1, $body1, $authorId);

    $title2 = new Title('更新されたブログ');
    $body2 = new Body('これは更新されたブログの本文です。');
    $blog2 = Blog::create($blogId, $title2, $body2, $authorId);

    $this->repository->save($blog1);

    // Act
    $this->repository->update($blog2);

    // Assert
    expect($this->repository->findById($blogId))->toBe($blog2);
    expect($this->repository->findById($blogId))->not->toBe($blog1);
  });

  it('deleteで保存されたBlogを削除できる', function () {
    // Arrange
    $blogId = new BlogId('550e8400-e29b-41d4-a716-446655440000');
    $title = new Title('テストブログ');
    $body = new Body('これはテストブログの本文です。');
    $authorId = new AuthorId('550e8400-e29b-41d4-a716-446655440001');
    $blog = Blog::create($blogId, $title, $body, $authorId);
    $this->repository->save($blog);

    // Act
    $this->repository->delete($blog);

    // Assert
    expect($this->repository->DB)->not->toHaveKey($blogId->getValue());
    expect($this->repository->findById($blogId))->toBeNull();
  });

  it('複数のBlogを保存して個別に取得できる', function () {
    // Arrange
    $blogId1 = new BlogId('550e8400-e29b-41d4-a716-446655440000');
    $title1 = new Title('ブログ1');
    $body1 = new Body('これはブログ1の本文です。');
    $authorId1 = new AuthorId('550e8400-e29b-41d4-a716-446655440001');
    $blog1 = Blog::create($blogId1, $title1, $body1, $authorId1);

    $blogId2 = new BlogId('550e8400-e29b-41d4-a716-446655440002');
    $title2 = new Title('ブログ2');
    $body2 = new Body('これはブログ2の本文です。');
    $authorId2 = new AuthorId('550e8400-e29b-41d4-a716-446655440003');
    $blog2 = Blog::create($blogId2, $title2, $body2, $authorId2);

    $this->repository->save($blog1);
    $this->repository->save($blog2);

    // Act & Assert
    expect($this->repository->findById($blogId1))->toBe($blog1);
    expect($this->repository->findById($blogId2))->toBe($blog2);
  });

  it('同じBlogIdで上書き保存できる', function () {
    // Arrange
    $blogId = new BlogId('550e8400-e29b-41d4-a716-446655440000');
    $title1 = new Title('元のブログ');
    $body1 = new Body('これは元のブログの本文です。');
    $authorId = new AuthorId('550e8400-e29b-41d4-a716-446655440001');
    $blog1 = Blog::create($blogId, $title1, $body1, $authorId);

    $title2 = new Title('更新されたブログ');
    $body2 = new Body('これは更新されたブログの本文です。');
    $blog2 = Blog::create($blogId, $title2, $body2, $authorId);

    $this->repository->save($blog1);

    // Act
    $this->repository->save($blog2);

    // Assert
    expect($this->repository->findById($blogId))->toBe($blog2);
    expect($this->repository->findById($blogId))->not->toBe($blog1);
  });

  it('存在しないBlogを削除してもエラーが発生しない', function () {
    // Arrange
    $blogId = new BlogId('550e8400-e29b-41d4-a716-446655440000');
    $title = new Title('存在しないブログ');
    $body = new Body('これは存在しないブログの本文です。');
    $authorId = new AuthorId('550e8400-e29b-41d4-a716-446655440001');
    $nonExistentBlog = Blog::create($blogId, $title, $body, $authorId);

    // Act & Assert
    expect(fn() => $this->repository->delete($nonExistentBlog))->not->toThrow(Exception::class);
  });

  it('Blogを削除した後、findAllで正しい結果を返す', function () {
    // Arrange
    $blogId1 = new BlogId('550e8400-e29b-41d4-a716-446655440000');
    $title1 = new Title('ブログ1');
    $body1 = new Body('これはブログ1の本文です。');
    $authorId1 = new AuthorId('550e8400-e29b-41d4-a716-446655440001');
    $blog1 = Blog::create($blogId1, $title1, $body1, $authorId1);

    $blogId2 = new BlogId('550e8400-e29b-41d4-a716-446655440002');
    $title2 = new Title('ブログ2');
    $body2 = new Body('これはブログ2の本文です。');
    $authorId2 = new AuthorId('550e8400-e29b-41d4-a716-446655440003');
    $blog2 = Blog::create($blogId2, $title2, $body2, $authorId2);

    $this->repository->save($blog1);
    $this->repository->save($blog2);

    // Act
    $this->repository->delete($blog1);

    // Assert
    $remainingBlogs = $this->repository->findAll();
    expect($remainingBlogs)->toHaveCount(1);
    expect($remainingBlogs)->toContain($blog2);
    expect($remainingBlogs)->not->toContain($blog1);
  });
}); 