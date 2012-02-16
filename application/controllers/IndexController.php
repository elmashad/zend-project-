<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
		$this->view->assign('title', 'Hello, World!');
    }

	function start()
	{
		$this->view->assign('title', 'Hello, World!');
	}
    
    public function heAction()
    {
        echo 'hehe';
    } 

}

