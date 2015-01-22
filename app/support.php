<?php

/**
 * Create a slug from a string
 *
 * @param string $str
 * @return string
 */
function slugify($str)
{
    return (new \Cocur\Slugify\Slugify())->slugify($str);
}
