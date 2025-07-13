<?php

namespace Infrastructures\Shared\Blog;

use Domain\Repositories\Blog\IBlogRepository;
use Domain\Model\Blog\Blog;
use Domain\Model\Blog\BlogId\BlogId;
use Domain\Model\Blog\Title\Title;
use Domain\Model\Blog\Body\Body;
use Domain\Model\Author\AuthorId\AuthorId;
use Ramsey\Uuid\Uuid;

class BlogTestHelper
{
  public function __construct(private IBlogRepository $blogRepository)
  {
  }

  public static function createTestBlogData(IBlogRepository $blogRepository): callable
  {
    return function () use ($blogRepository): Blog {
      $blog = Blog::reconstruct(
        id: new BlogId(Uuid::uuid4()),
        title: new Title('Test Blog'),
        body: new Body('Test Body'),
        authorId: new AuthorId(Uuid::uuid4()),
      );

      $blogRepository->save($blog);

      return $blog;
    };
  }
}