<?php 

namespace Helmut\Forms;

interface Request {
	
	/**
     * Fetch all values from the request.
     *
     * @return array
     */
	public function all();

	/**
     * Fetch a value from the request matching provided key.
     *
     * @var string
     * @return mixed
     */
	public function get($key);

	/**
     * Return array of csrf template properties.
     *
     * @return array
     */
	public function csrf();	

}