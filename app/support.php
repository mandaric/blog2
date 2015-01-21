<?php

function slugify($str)
{
	return strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $str));
}
