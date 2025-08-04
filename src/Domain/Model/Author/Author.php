<?php

namespace Domain\Model\Author;

use Domain\Model\Author\AuthorId\AuthorId;
use Domain\Model\Author\AuthorName\AuthorName;
use Domain\Model\Author\Password\Password;
use Domain\Model\Author\Email\Email;
use InvalidArgumentException;

class Author
{
  private readonly AuthorId $authorId;
  private readonly AuthorName $authorName;
  private readonly Email $email;
  private readonly Password $password;

  private function __construct(AuthorId $authorId, AuthorName $authorName, Email $email, Password $password)
  {
    $this->authorId = $authorId;
    $this->authorName = $authorName;
    $this->email = $email;
    $this->password = $password;
  }

  public static function create(AuthorId $authorId, AuthorName $authorName, Password $password, Email $email)
  {
    return new self($authorId, $authorName, $email, $password);
  }

  public function delete()
  {
    // TODO: 削除ロジックの追加
  }

  public static function reconstruct(AuthorId $authorId, AuthorName $authorName, Password $password, Email $email)
  {
    return new self(authorId: $authorId, authorName: $authorName, password: $password, email: $email);
  }

  public function changeName(AuthorName $authorName)
  {
    $this->authorName = $authorName;
  }

  public function changePassword(Password $password)
  {
    $this->password = $password;
  }

  public function changeEmail(Email $email)
  {
    $this->email = $email;
  }

  public function getId(): AuthorId
  {
    return $this->authorId;
  }

  public function getName(): AuthorName
  {
    return $this->authorName;
  }

  public function getPassword(): Password
  {
    return $this->password;
  }

  public function getEmail(): Email
  {
    return $this->email;
  }
}
