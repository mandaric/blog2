<?php

function db()
{
	$new = false;
	$file = APP_DIR . '/' .config('database_file');

	if (!file_exists($file))
	{
		touch($file);
		$new = true;
	}

	$db = &$GLOBALS['blog']['db'];

	if (empty($db))
	{
		$db = new medoo([
			'database_type' => config('database_type'),
			'database_file' => $file
		]);
	}

	if ($new)
	{
		$db->query('CREATE TABLE IF NOT EXISTS `pages` (
			`id`	INTEGER PRIMARY KEY AUTOINCREMENT,
			`title`	TEXT,
			`slug`	TEXT,
			`content`	TEXT,
			`publish`	INTEGER,
			`created_at`	DATETIME,
			`updated_at`	DATETIME
		)');
	}

	return $db;
}
