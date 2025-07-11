<?php

namespace Domain\Model\Blog;

use Domain\Model\Blog\BlogId\BlogId;
use Domain\Model\Blog\Title\Title;
use Domain\Model\Blog\Body\Body;
use Domain\Model\Author\AuthorId\AuthorId;

class Blog
{
  private readonly BlogId $id;
  private Title $title;
  private Body $body;

  private AuthorId $authorId;

  private function __construct(BlogId $id, Title $title, Body $body, AuthorId $authorId)
  {
    $this->id = $id;
    $this->title = $title;
    $this->body = $body;
    $this->authorId = $authorId;
  }

  public static function create(BlogId $id, Title $title, Body $body, AuthorId $authorId)
  {
    return new self($id, $title, $body, $authorId);
  }

  public function delete()
  {
    // TODO: 削除ロジックの追加
  }

  public static function reconstruct(BlogId $id, Title $title, Body $body, AuthorId $authorId)
  {
    return new self(id: $id, title: $title, body: $body, authorId: $authorId);
  }

  public function changeTitle(Title $title)
  {
    $this->title = $title;
  }

  public function changeBody(Body $body)
  {
    $this->body = $body;
  }

  public function getId(): BlogId
  {
    return $this->id;
  }

  public function getTitle(): Title
  {
    return $this->title;
  }

  public function getBody(): Body
  {
    return $this->body;
  }

  public function getAuthorId(): AuthorId
  {
    return $this->authorId;
  }
}
