<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller {

	public function action_index()
	{
		$this->response->body('hello, world!');
	}
	
	public function action_do_view()
	{
		$this->response->body('my view hello');
	}

} // End Welcome
