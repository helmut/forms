<?php
// Here you can initialize variables that will be available to your tests

function script($test) {
	return str_replace('Cept', '', implode('/', array_slice(explode('/', $test), -2)));
}