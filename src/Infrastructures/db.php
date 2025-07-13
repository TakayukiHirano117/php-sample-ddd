<?php

require __DIR__ . '/../vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'pgsql',
    'host'      => 'localhost',
    'database'  => 'localdb',
    'username'  => 'postgres',
    'password'  => 'password',
    'charset'   => 'utf8',
    'prefix'    => '',
    'schema'    => 'public',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

// $blogs = Capsule::table('blogs')
//     ->get();

// dd($blogs);
