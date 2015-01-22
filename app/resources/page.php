<?php
/*
 * Page Resource
 *
 * Package used:
 * @link https://github.com/noodlehaus/dispatch
 * @link https://github.com/catfan/Medoo
 * @link https://github.com/cocur/slugify
 */

/**
 * Show form for creating a new Page
 */
map('GET', '/cms/pages/new', function ()
{
    // display form, set url to post the data to /cms/pages
    print phtml('page/form', ['action' => '/cms/pages']);
});

/**
 * Show a single Page by ID
 */
map('GET', '/cms/pages/<id>', function ($params)
{
    // get the a single page from the database by id
    // see: http://medoo.in/api/get
    if ($page = db()->get('pages', '*', ['id' => $params['id']]))
    {
      // show the page
      print phtml('page/page', ['page' => $page]);
    }
    else
    {
      // page was not found, print an error
      print phtml('error', ['msg' => 'Page not found, ID:' . $params['id']]);
    }
});

/**
 * Show all the pages
 */
map('GET', '/cms/pages', function ()
{
    // Select all pages with all columns
    // see: http://medoo.in/api/select
    $pages = db()->select('pages', '*');

    // show the pages overview
    print phtml('page/index', ['pages' => $pages]);
});

/**
 * Save a new Page
 */
map('POST', '/cms/pages', function ()
{
    // get all the posted data
    $data = $_POST;

    // set the slug by using the title
    $data['slug'] = slugify($data['title']);
    // set the publish column to 0 or 1, html does not post an empty checkbox
    $data['publish'] = !isset($data['publish']) ? 0 : 1;
    // set the created date
    $data['created_at'] = date('Y-m-d H:i:s');
    // set the updated date
    $data['updated_at'] = date('Y-m-d H:i:s');

    // insert the record into the database
    // see: http://medoo.in/api/insert
    $result = db()->insert('pages', $data);

    // check if the insert was correct
    if ($result !== false)
    {
        redirect('/cms/pages');
    }

    // insert failed, display error
    print phtml('error', ['msg' => 'Page not saved, ID:' . $params['id']]);
});

/**
 * Show a from to edit existing Page by ID
 */
map('GET', '/cms/pages/<id>/edit', function ($params)
{
    // get the a single page from the database by id
    // see: http://medoo.in/api/get
    if ($page = db()->get('pages', '*', ['id' => $params['id']]))
    {
      // display the form and set the url to post data to specific page url
      print phtml('page/form', [
        'page' => $page,
        'action' => sprintf('/cms/pages/%d', $params['id'])
      ]);
    }
    else
    {
      // page was not found, print an error
      print phtml('error', ['msg' => 'Page not found, ID:' . $params['id']]);
    }
});

/**
 * Save an existing Page
 */
map('POST', '/cms/pages/<id>', function ($params)
{
    // get all the posted data
    $data = $_POST;

    // set the slug by using the title
    $data['slug'] = slugify($data['title']);
    // set the publish column to 0 or 1, html does not post an empty checkbox
    $data['publish'] = !isset($data['publish']) ? 0 : 1;
    // set the updated date
    $data['updated_at'] = date('Y-m-d H:i:s');

    // update the record into the database
    // see: http://medoo.in/api/update
    $result = db()->update('pages', $data, ['id' => $params['id']]);

    // check if the update was correct
    if ($result !== false)
    {
        redirect('/cms/pages');
    }

    // update failed, display error
    print phtml('error', ['msg' => 'Page not saved, ID:' . $params['id']]);
});

/**
 * Delete an existing Page
 */
map('DELETE', '/cms/pages/<id>', function ($params)
{
    // delete an existing page by id
    // see: http://medoo.in/api/delete
    $result = db()->delete('pages', ['id' => $params['id']]);

    // check if the delete was correct
    if ($result !== false)
    {
        redirect('/cms/pages');
    }

    // delete failed, display error
    print phtml('error', ['msg' => 'Page not deleted, ID:' . $params['id']]);
});

/**
 * Show Page by Slug
 */
map('GET', '/<slug>', function ($params)
{
    // setup the query, show only if published page
    $query = [
      'slug' => $params['slug'],
      'publish' => 1
    ];

    // check if GET parameter is set to show unpublished page
    if (isset($_GET['preview']) && ($_GET['preview'] == 1))
    {
      // uri contains ?preview=1, remove publish from query
      unset($query['publish']);
    }

    // get the a single page from the database by slug
    // see: http://medoo.in/api/get
    if ($page = db()->get('pages', '*', $query))
    {
        // show the page
        print phtml('page/page', ['page' => $page]);
    }
    else
    {
        // page was not found, display error
        print phtml('error', [
          'msg' => 'Page not found, SLUG:' . $params['slug']
        ]);
    }
});
