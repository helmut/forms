<?php
// Here you can initialize variables that will be available to your tests
date_default_timezone_set('UTC');

function script($test) {
	return str_replace('Cept', '', implode('/', array_slice(explode('/', $test), -2)));
}