<?php

class IndexController extends BaseController {
	
	public function indexAction(){
		//print_r(IndexModel::all());
		var_dump(IndexModel::getAdaptor()->fetchByQuery("SELECT * from `users`"));
		return 'API Index controller --- index action';
	}
	
}