<?php

/**
 *
 */
map('GET', '/cms/pages/new', function ()
{
	print phtml('page/form', [
		'action' => '/cms/pages'
	]);
});

/**
 *
 */
map('GET', '/cms/pages/<id>', function ($params)
{
	$page = db()->get('pages', '*', ['id' => $params['id']]);

	print phtml('page/page', ['page' => $page]);
});

/**
 *
 */
map('GET', '/cms/pages', function () {
	$pages = db()->select('pages', '*');

	print phtml('page/index', [
		'pages' => $pages
	]);
});

/**
 *
 */
map('POST', '/cms/pages', function ()
{
	$data = $_POST;

	$data['slug'] = slugify($data['title']);
	$data['created_at'] = date('Y-m-d H:i:s');
	$data['updated_at'] = date('Y-m-d H:i:s');

	$page_id = db()->insert('pages', $data);

	redirect('/cms/pages');
});

/**
 *
 */
map('GET', '/cms/pages/<id>/edit', function ($params)
{
	//
});

/**
 *
 */
map('POST', '/cms/pages/<id>', function ($params)
{
	//
});

/**
 *
 */
map('DELETE', '/cms/pages/<id>', function ($params)
{
	//
});

/**
 *
 */
map('GET', '/{slug}', function ($params)
{
	$page = db()->get('pages', '*', ['slug' => $params['slug']]);

	print phtml('page/page', ['page' => $page]);
});
