<?php

namespace Config;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class DbConnection
{
  public static function getConnection(): Connection
  {
    $connectionParams = [
      'dbname'   => 'localdb',
      'user'     => 'postgres',
      'password' => 'password',
      'host'     => 'localhost',
      'port'     => 5432,
      'driver'   => 'pdo_pgsql',
      'charset'  => 'utf8',
    ];
    return DriverManager::getConnection($connectionParams);
  }
}
