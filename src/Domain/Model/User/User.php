<?php

namespace Domain\Model\User;

use Domain\Model\User\UserId\UserId;
use Domain\Model\User\UserName\UserName;
use Domain\Model\User\Password\Password;
use Domain\Model\User\Email\Email;

class User
{
  private readonly UserId $id;
  private UserName $name;
  private Password $password;
  private Email $email;

  private function __construct(UserId $id, UserName $name, Password $password, Email $email)
  {
    $this->id = $id;
    $this->name = $name;
    $this->password = $password;
    $this->email = $email;
  }

  public static function create(UserId $id, UserName $name, Password $password, Email $email)
  {
    return new self($id, $name, $password, $email);
  }

  public function delete()
  {
    // TODO: 削除ロジックの追加
  }

  public static function reconstruct(UserId $id, UserName $name, Password $password, Email $email)
  {
    return new self(id: $id, name: $name, password: $password, email: $email);
  }

  public function changeName(UserName $name)
  {
    $this->name = $name;
  }

  public function changePassword(Password $password)
  {
    $this->password = $password;
  }

  public function changeEmail(Email $email)
  {
    $this->email = $email;
  }

  public function getId(): UserId
  {
    return $this->id;
  }

  public function getName(): UserName
  {
    return $this->name;
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