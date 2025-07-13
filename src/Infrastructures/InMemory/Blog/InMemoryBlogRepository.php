<?php

namespace Infrastructures\InMemory\Blog;

use Domain\Model\Blog\Blog;
use Domain\Model\Blog\BlogId\BlogId;
use Domain\Repositories\Blog\IBlogRepository;

class InMemoryBlogRepository implements IBlogRepository
{
    public array $DB = [];

    public function save(Blog $blog): void
    {
        $this->DB[$blog->getId()->getValue()] = $blog;
    }

    public function findById(BlogId $id): ?Blog
    {
        return $this->DB[$id->getValue()] ?? null;
    }

    public function findAll(): array
    {
        return array_values($this->DB);
    }

    public function update(Blog $blog): void
    {
        $this->DB[$blog->getId()->getValue()] = $blog;
    }

    public function delete(Blog $blog): void
    {
        unset($this->DB[$blog->getId()->getValue()]);
    }
}