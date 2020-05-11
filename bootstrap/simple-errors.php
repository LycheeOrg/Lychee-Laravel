<?php

function displaySimpleError($title, $code, $message)
{
	$error_display = file_get_contents(__DIR__ . '/../simple_error_template.html');
	$replacing = [
		'$title' => $title,
		'$code' => $code,
		'$message' => $message,
	];

	echo strtr($error_display, $replacing);
}
