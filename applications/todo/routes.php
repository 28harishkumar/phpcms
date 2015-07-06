<?php

return [
	'' => ['name' => 'home', 'control' => 'todo@index'],
	'todo' => ['name' => 'todo-home', 'control' =>'todo@index'],
	'todo/new' => ['name' => 'new-todo', 'control' => 'todo@add'],
	'todo/add' => ['name' => 'add-todo', 'control' => 'todo@create'],
	'todo/edit/{id}[0-9]+' => ['name' => 'edit-todo', 'control' => 'todo@edit'],
	'todo/update' => ['name' => 'update-todo', 'control' => 'todo@update'],
	'todo/delete/{id}[0-9]+' => ['name' => 'delete-todo', 'control' => 'todo@destroy'],
	'todo/list' => ['name' => 'todo-list', 'control' =>'todo@index'],
	'todo/list/{label}[a-z]+' => ['name' => 'todo-label', 'control' =>'todo@index'],
	'todo/show/{id}[0-9]+' => ['name' => 'show-todo', 'control' =>'todo@show'],
];