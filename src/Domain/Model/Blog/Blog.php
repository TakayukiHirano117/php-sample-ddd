<?php

namespace Domain\Model\Blog;

use Domain\Model\Blog\BlogId\BlogId;
use Domain\Model\Blog\Title\Title;
use Domain\Model\Blog\Body\Body;

class Blog
{
  private readonly BlogId $id;
  private Title $title;
  private Body $body;
  // TODO: UserIdを追加

  private function __construct(BlogId $id, Title $title, Body $body)
  {
    $this->id = $id;
    $this->title = $title;
    $this->body = $body;
  }

  public static function create(BlogId $id, Title $title, Body $body)
  {
    return new self($id, $title, $body);
  }

  public function delete()
  {
    // TODO: 削除ロジックの追加
  }

  public static function reconstruct(BlogId $id, Title $title, Body $body)
  {
    return new self(id: $id, title: $title, body: $body);
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
}
