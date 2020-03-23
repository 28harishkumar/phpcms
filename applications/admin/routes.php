<?php

return [
  'admin' => [
    'name' => 'admin-home',
    'control' => 'admin@index',
    'allow' => ['GET', 'POST']
  ],

  'admin/theme' => [
    'name' => 'theme-settings',
    'control' => 'admin@theme_list',
    'allow' => ['GET']
  ],

  'admin/theme/activate' => [
    'name' => 'theme-activate',
    'control' => 'admin@theme_activate',
    'allow' => ['POST']
  ],

  'admin/theme/preview' => [
    'name' => 'live-preview',
    'control' => 'admin@preview',
    'allow' => ['GET', 'POST']
  ],
  /*
	 these disable links are port for next versionq

	'admin/widget' => [
				'name' => 'widget-settings', 
				'control' => 'admin@widgets_list',
				'allow' => ['GET']],

	'admin/widget/update' => [
				'name' => 'widgets-update', 
				'control' => 'admin@user_list',
				'allow' => ['POST']],

	'admin/menus' => [
				'name' => 'menu-list', 
				'control' =>'admin@menu_list',
				'allow' => ['GET']],

	'admin/menus/add' => [
				'name' => 'add-menu', 
				'control' =>'admin@add_menu',
				'allow' => ['POST']],

	'admin/menus/{id}[0-9]+' => [
				'name' => 'edit-menu', 
				'control' =>'admin@edit_menu',
				'allow' => ['GET']],
				
	'admin/menus/{id}[0-9]+/delete' => [
				'name' => 'delete-menu', 
				'control' =>'admin@delete_menu',
				'allow' => ['POST']],

	'admin/menus/manage' => [
				'name' => 'manage-menu-list', 
				'control' =>'admin@manage_menu_list',
				'allow' => ['GET']],

	'admin/menus/manage/update' => [
				'name' => 'manage-menu', 
				'control' =>'admin@manage_menu',
				'allow' => ['POST']],

	'admin/users/new' => [
				'name' => 'admin-new-user', 
				'control' =>'admin@admin_new_user',
				'allow' => ['GET']],

	'admin/users/add' => [
				'name' => 'admin-add-user', 
				'control' =>'admin@admin_add_user',
				'allow' => ['POST']],

	*/

  'admin/users' => [
    'name' => 'admin-user-list',
    'control' => 'admin@admin_user_list',
    'allow' => ['GET']
  ],

  'admin/user/{id}[0-9]+/edit' => [
    'name' => 'admin-edit-user',
    'control' => 'admin@admin_edit_user',
    'allow' => ['GET']
  ],

  'admin/user/{id}[0-9]+/update' => [
    'name' => 'admin-update-user',
    'control' => 'admin@admin_update_user',
    'allow' => ['POST']
  ],

  'admin/user/{id}[0-9]+/delete' => [
    'name' => 'admin-delete-user',
    'control' => 'admin@admin_delete_user',
    'allow' => ['POST']
  ],
];
