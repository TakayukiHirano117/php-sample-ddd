<?php

namespace Infrastructures\Repositories;

use Domain\Model\Blog\Blog;
use Domain\Model\Blog\BlogId\BlogId;
use Domain\Model\Blog\Title\Title;
use Domain\Model\Blog\Body\Body;
use Domain\Model\Author\AuthorId\AuthorId;
use Doctrine\DBAL\Connection;
use Domain\Repositories\Blog\IBlogRepository;

class BlogRepository implements IBlogRepository
{
  public function __construct(private Connection $connection) {}

  public function save(Blog $blog): void
  {
    $this->connection->insert('blogs', [
      'id' => $blog->getId()->getValue(),
      'title' => $blog->getTitle()->getValue(),
      'body' => $blog->getBody()->getValue(),
      'author_id' => $blog->getAuthorId()->getValue(),
    ]);
  }

  public function update(Blog $blog): void
  {
    $this->connection->update('blogs', [
      'title' => $blog->getTitle()->getValue(),
      'body' => $blog->getBody()->getValue(),
    ], ['id' => $blog->getId()->getValue()]);
  }

  public function delete(Blog $blog): void
  {
    $this->connection->delete('blogs', ['id' => $blog->getId()->getValue()]);
  }

  public function findById(BlogId $id): ?Blog
  {
    $sql = 'SELECT * FROM blogs WHERE id = :id';
    $row = $this->connection->fetchAssociative($sql, ['id' => $id->getValue()]);
    if (!$row) {
      return null;
    }
    return new Blog(
      new BlogId($row['id']),
      new Title($row['title']),
      new Body($row['body']),
      new AuthorId($row['author_id']),
    );
  }

  public function findAll()
  {
    $sql = 'SELECT * FROM blogs';
    $rows = $this->connection->fetchAllAssociative($sql);
    return array_map(function ($row) {
      return new Blog(
        new BlogId($row['id']),
        new Title($row['title']),
        new Body($row['body']),
        new AuthorId($row['author_id']),
      );
    }, $rows);
  }
}
