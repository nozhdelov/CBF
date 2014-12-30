<?php

class IndexController extends BaseController {
	
	public function indexAction(){
		//print_r(IndexModel::all());
		//var_dump(IndexModel::getAdaptor()->fetchByQuery("SELECT * from `users`"));
		return View::make('index');
	}
	
}