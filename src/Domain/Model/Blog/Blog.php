<?php

namespace Domain\Model\Blog;

use Domain\Model\Blog\BlogId\BlogId;
use Domain\Model\Blog\Title\Title;
use Domain\Model\Blog\Body\Body;

class Blog
{
  private BlogId $id;
  private Title $title;
  private Body $body;

  private function __construct(BlogId $id, Title $title, Body $body)
  {
    $this->id = $id;
    $this->title = $title;
    $this->body = $body;
  }
  // TODO: 作成・削除・再構築メソッドの追加
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
    return new self($id, $title, $body);
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
