<?php

namespace Usecases\Author;

use Domain\Model\Author\Author;
use Domain\Model\Author\AuthorId\AuthorId;
use Domain\Model\Author\AuthorName\AuthorName;
use Domain\Model\Author\Email\Email;
use Domain\Model\Author\Password\Password;
use Domain\Repositories\Author\IAuthorRepository;

class CreateAuthorUsecase
{
  public function __construct(private IAuthorRepository $authorRepository) {}

  public function execute(CreateAuthorRequest $request): void
  {
    // TODO: エラーハンドリングする
    $this->authorRepository->save(
      Author::create(
        new AuthorId(),
        new AuthorName($request->name),
        new Password($request->password),
        new Email($request->email),
      )
    );
  }
}