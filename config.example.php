<?php

return [

  // set a database connection as default

  'database' => 'mysql',

  // config database connections
  'connection' => [
    'mysql' => [
      'driver'    => 'mysql',
      'host'      => 'your host',
      'database'  => 'your database name',
      'username'  => 'your username',
      'password'  => 'your password',
    ],
  ],

  // set the location of application withour trailing slash
  'root' => '', // example 'http://localhost/todolist' or http://demo.findalltogeher.com

  // register apps
  'apps' => [
    'auth',
    'todo',
    'admin',
  ],

  // secret string for encreption
  'secret' => 'this_is_secret_string', // example 'fa&k+j@sdf!has^dh-iu!d#dh$sd'

];
