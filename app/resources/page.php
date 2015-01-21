<?php

/**
 * Show form for creating a new Page
 */
map('GET', '/cms/pages/new', function ()
{
    print phtml('page/form', [
        'action' => '/cms/pages'
    ]);
});

/**
 * Show a single Page by ID
 */
map('GET', '/cms/pages/<id>', function ($params)
{
    $page = db()->get('pages', '*', ['id' => $params['id']]);

    print phtml('page/page', ['page' => $page]);
});

/**
 * Show all the pages
 */
map('GET', '/cms/pages', function ()
{
    $pages = db()->select('pages', '*');

    print phtml('page/index', [
        'pages' => $pages
    ]);
});

/**
 * Save a new Page
 */
map('POST', '/cms/pages', function ()
{
    $data = $_POST;

    $data['slug'] = slugify($data['title']);
    $data['created_at'] = date('Y-m-d H:i:s');
    $data['updated_at'] = date('Y-m-d H:i:s');

    if (!isset($data['publish']))
    {
        $data['publish'] = 0;
    }

    $result = db()->insert('pages', $data);

    if ($result !== false)
    {
        redirect('/cms/pages');
    }

    print phtml('error', [
        'error' => 'Page not saved'
    ]);
});

/**
 * Show a from to edit existing Page by ID
 */
map('GET', '/cms/pages/<id>/edit', function ($params)
{
    $page = db()->get('pages', '*', ['id' => $params['id']]);

    print phtml('page/form', [
        'page' => $page,
        'action' => sprintf('/cms/pages/%d', $params['id'])
    ]);
});

/**
 * Save an existing Page
 */
map('POST', '/cms/pages/<id>', function ($params)
{
    $data = $_POST;

    $data['slug'] = slugify($data['title']);
    $data['updated_at'] = date('Y-m-d H:i:s');

    if (!isset($data['publish']))
    {
        $data['publish'] = 0;
    }

    $result = db()->update('pages', $data, ['id' => $params['id']]);

    if ($result !== false)
    {
        redirect('/cms/pages');
    }

    print phtml('error', [
        'error' => 'Page not saved'
    ]);
});

/**
 * Delete an existing Page
 */
map('DELETE', '/cms/pages/<id>', function ($params)
{
    $result = db()->delete('pages', ['id' => $params['id']]);

    if ($result !== false)
    {
        redirect('/cms/pages');
    }

    print phtml('error', [
        'error' => 'Page not saved'
    ]);
});

/**
 * Show Page by Slug
 */
map('GET', '/<slug>', function ($params)
{
    if ($page = db()->get('pages', '*', ['slug' => $params['slug']]))
    {
        print phtml('page/page', ['page' => $page]);
    }
    else
    {
        print phtml('error', [
            'error' => 'Page not found'
        ]);
    }
});
