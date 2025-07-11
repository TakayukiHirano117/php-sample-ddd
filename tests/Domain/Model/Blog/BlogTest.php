<?php

namespace Tests\Domain\Model\Blog;

use Domain\Model\Blog\Blog;
use Domain\Model\Blog\BlogId\BlogId;
use Domain\Model\Blog\Title\Title;
use Domain\Model\Blog\Body\Body;
use Domain\Model\Author\AuthorId\AuthorId;

describe('Blog', function () {
  it('createでBlogを生成できる', function () {
    $id = new BlogId('550e8400-e29b-41d4-a716-446655440000');
    $title = new Title('テストタイトル');
    $body = new Body('テスト本文');
    $authorId = new AuthorId('550e8400-e29b-41d4-a716-446655440001');
    $blog = Blog::create($id, $title, $body, $authorId);
    expect($blog->getId())->toBe($id);
    expect($blog->getTitle())->toBe($title);
    expect($blog->getBody())->toBe($body);
    expect($blog->getAuthorId())->toBe($authorId);
  });

  it('reconstructでBlogを復元できる', function () {
    $id = new BlogId('550e8400-e29b-41d4-a716-446655440000');
    $title = new Title('テストタイトル');
    $body = new Body('テスト本文');
    $authorId = new AuthorId('550e8400-e29b-41d4-a716-446655440001');
    $blog = Blog::reconstruct($id, $title, $body, $authorId);
    expect($blog->getId())->toBe($id);
    expect($blog->getTitle())->toBe($title);
    expect($blog->getBody())->toBe($body);
    expect($blog->getAuthorId())->toBe($authorId);
  });

  it('changeTitleでタイトルを変更できる', function () {
    $id = new BlogId('550e8400-e29b-41d4-a716-446655440000');
    $title = new Title('テストタイトル');
    $body = new Body('テスト本文');
    $authorId = new AuthorId('550e8400-e29b-41d4-a716-446655440001');
    $blog = Blog::create($id, $title, $body, $authorId);
    $newTitle = new Title('新しいタイトル');
    $blog->changeTitle($newTitle);
    expect($blog->getTitle())->toBe($newTitle);
  });

  it('changeBodyで本文を変更できる', function () {
    $id = new BlogId('550e8400-e29b-41d4-a716-446655440000');
    $title = new Title('テストタイトル');
    $body = new Body('テスト本文');
    $authorId = new AuthorId('550e8400-e29b-41d4-a716-446655440001');
    $blog = Blog::create($id, $title, $body, $authorId);
    $newBody = new Body('新しい本文');
    $blog->changeBody($newBody);
    expect($blog->getBody())->toBe($newBody);
  });
});
