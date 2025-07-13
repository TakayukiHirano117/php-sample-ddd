<?php

namespace Domain\Repositories\Blog;

use Domain\Model\Blog\Blog;
use Domain\Model\Blog\BlogId\BlogId;

interface IBlogRepository
{
  public function save(Blog $blog): void;

  public function update(Blog $blog): void;

  public function delete(Blog $blog): void;

  public function findById(BlogId $id): ?Blog;

  public function findAll(); 
}
