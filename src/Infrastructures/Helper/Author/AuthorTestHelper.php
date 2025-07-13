<?php

namespace Infrastructures\Helper\Author;

use Domain\Model\Author\AuthorName\AuthorName;
use Domain\Repositories\Author\IAuthorRepository;
use Domain\Model\Author\AuthorId\AuthorId;
use Domain\Model\Author\Email\Email;
use Domain\Model\Author\Password\Password;
use Ramsey\Uuid\Uuid;
use Domain\Model\Author\Author;


class AuthorTestHelper
{
  public function __construct(private IAuthorRepository $authorRepository)
  {
  }

  public static function createTestAuthorData(IAuthorRepository $authorRepository): callable
  {
    return function () use ($authorRepository): Author {
      $author = Author::reconstruct(
        authorId: new AuthorId(Uuid::uuid4()),
        authorName: new AuthorName('Test Author'),
        email: new Email('test@example.com'),
        password: new Password('password')
      );

      $authorRepository->save($author);

      return $author;
    };
  }
}