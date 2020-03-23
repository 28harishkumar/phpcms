<?php

return [
  'auth/login-form' => [
    'name' => 'login-form',
    'control' => 'auth@login_form',
    'allow' => ['GET', 'POST']
  ],

  'auth/login-form\#signup' => [
    'name' => 'signup-form',
    'control' => 'auth@login_form',
    'allow' => ['GET', 'POST']
  ],

  'auth/login' => [
    'name' => 'login',
    'control' => 'auth@login_user',
    'allow' => ['POST']
  ],

  'auth/register' => [
    'name' => 'register',
    'control' => 'auth@register_user',
    'allow' => ['POST']
  ],

  'auth/verify-email/{code}[0-9a-z]+/{email}[0-9a-zA-Z\.@]+' => [
    'name' => 'verify-email',
    'control' => 'auth@verify_email',
    'allow' => ['GET']
  ],

  'auth/forget-password' => [
    'name' => 'forget-password',
    'control' => 'auth@forget_password',
    'allow' => ['POST']
  ],

  'auth/reset' => [
    'name' => 'reset',
    'control' => 'auth@reset_password',
    'allow' => ['POST']
  ],

  'auth/reset-password/{code}[0-9a-z]+/{email}[0-9a-zA-Z\.@]+' => [
    'name' => 'reset-password',
    'control' => 'auth@reset_password_form',
    'allow' => ['GET']
  ],

  'auth/logout' => [
    'name' => 'logout',
    'control' => 'auth@logout_user',
    'allow' => ['GET']
  ],
];
