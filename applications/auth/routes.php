<?php

return [
		'auth/login-form' => ['name' => 'login-form', 'control' => 'auth@login_form'],
		'auth/login-form\#signup' => ['name' => 'signup-form', 'control' => 'auth@login_form'],
		'auth/login' => ['name' => 'login', 'control' => 'auth@login_user'],
		'auth/register' => ['name' => 'register', 'control' => 'auth@register_user'],
		'auth/verify-email/{code}[0-9a-z]+/{email}[0-9a-zA-Z\.@]+' => ['name' => 'verify-email', 'control' => 'auth@verify_email'],
		'auth/forget-password' => ['name' => 'forget-password', 'control' => 'auth@forget_password'],
		'auth/reset' => ['name' => 'reset', 'control' => 'auth@reset_password'],
		'auth/reset-password/{code}[0-9a-z]+/{email}[0-9a-zA-Z\.@]+' => ['name' => 'reset-password', 'control' => 'auth@reset_password_form'],
		'auth/logout' => ['name' => 'logout', 'control' => 'auth@logout_user'],
];