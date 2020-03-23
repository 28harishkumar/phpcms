<?php

return [
  '' => [
    'name' => 'home',
    'control' => 'todo@index',
    'allow' => ['GET',]
  ],
  'todo' => [
    'name' => 'todo-home',
    'control' => 'todo@index',
    'allow' => ['GET',]
  ],

  'todo/new' => [
    'name' => 'new-todo',
    'control' => 'todo@add',
    'allow' => ['GET',]
  ],

  'todo/add' => [
    'name' => 'add-todo',
    'control' => 'todo@create',
    'allow' => ['POST']
  ],

  'todo/edit/{id}[0-9]+' => [
    'name' => 'edit-todo',
    'control' => 'todo@edit',
    'allow' => ['GET']
  ],

  'todo/update' => [
    'name' => 'update-todo',
    'control' => 'todo@update',
    'allow' => ['POST']
  ],

  'todo/delete/{id}[0-9]+' => [
    'name' => 'delete-todo',
    'control' => 'todo@destroy',
    'allow' => ['POST']
  ],

  'todo/list' => [
    'name' => 'todo-list',
    'control' => 'todo@index',
    'allow' => ['GET']
  ],

  'todo/list/{label}[a-z]+' => [
    'name' => 'todo-label',
    'control' => 'todo@index',
    'allow' => ['GET']
  ],

  'todo/show/{id}[0-9]+' => [
    'name' => 'show-todo',
    'control' => 'todo@show',
    'allow' => ['GET']
  ],
];
