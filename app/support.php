<?php

function slugify($str)
{
    return (new \Cocur\Slugify\Slugify())->slugify($str);
}
