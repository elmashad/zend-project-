<?php
require_once 'Zend/Db/Adapter/Pdo/Mysql.php';
require_once 'Zend/Controller/Action.php';
class UserController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $this->view->assign('name', 'Wiwit');
        $this->view->assign('title', 'Hello');
    }
    public function nameAction()
    {
        $request = $this->getRequest();
        $this->view->assign('name', $request->getParam('username'));
        $this->view->assign('gender', $request->getParam('gender'));
        $this->view->assign('title', 'User Name');
    }
    public function registerAction()
    {
        $request = $this->getRequest();
        $this->view->assign('action', "process");
        $this->view->assign('title', 'Member Registration');
        $this->view->assign('label_fname', 'First Name');
        $this->view->assign('label_lname', 'Last Name');
        $this->view->assign('label_uname', 'User Name');
        $this->view->assign('label_pass', 'Password');
        $this->view->assign('label_submit', 'Register');
        $this->view->assign('description', 'Please enter this form completely:');
    }
    public function editAction()
    {
        $params = array('host' => 'localhost', 'username' => 'root', 'password' =>
            'admin', 'dbname' => 'zend');
        $DB = new Zend_Db_Adapter_Pdo_Mysql($params);
        $request = $this->getRequest();
        $id = $request->getParam("id");
        $sql = "SELECT * FROM `user` WHERE id='" . $id . "'";
        $result = $DB->fetchRow($sql);
        $this->view->assign('data', $result);
        $this->view->assign('action', $request->getBaseURL() . "/user/processedit");
        $this->view->assign('title', 'Member Editing');
        $this->view->assign('label_fname', 'First Name');
        $this->view->assign('label_lname', 'Last Name');
        $this->view->assign('label_uname', 'User Name');
        $this->view->assign('label_pass', 'Password');
        $this->view->assign('label_submit', 'Edit');
        $this->view->assign('description', 'Please update this form completely:');
    }
    public function processAction()
    {
        $params = array('host' => 'localhost', 'username' => 'root', 'password' =>
            'admin', 'dbname' => 'zend');
        $DB = new Zend_Db_Adapter_Pdo_Mysql($params);
        $request = $this->getRequest();
        $data = array('first_name' => $request->getParam('first_name'), 'last_name' => $request->
            getParam('last_name'), 'user_name' => $request->getParam('user_name'),
            'password' => md5($request->getParam('password')));
        $DB->insert('user', $data);
        $this->view->assign('title', 'Registration Process');
        $this->view->assign('description', 'Registration succes');
    }
    public function listAction()
    {
        $params = array('host' => 'localhost', 'username' => 'root', 'password' =>
            'admin', 'dbname' => 'zend');
        $DB = new Zend_Db_Adapter_Pdo_Mysql($params);
        $DB->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "SELECT * FROM `user` ORDER BY user_name ASC";
        $result = $DB->fetchAssoc($sql);
        $this->view->assign('title', 'Member List');
        $this->view->assign('description', 'Below, our members:');
        $this->view->assign('datas', $result);
    }
    public function processeditAction()
    {
        $params = array('host' => 'localhost', 'username' => 'root', 'password' =>
            'admin', 'dbname' => 'zend');
        $DB = new Zend_Db_Adapter_Pdo_Mysql($params);
        $request = $this->getRequest();
        $data = array('first_name' => $request->getParam('first_name'), 'last_name' => $request->
            getParam('last_name'), 'user_name' => $request->getParam('user_name'),
            'password' => md5($request->getParam('password')));
        $DB->update('user', $data, 'id = ' . $request->getParam('id'));
        $this->view->assign('title', 'Editing Process');
        $this->view->assign('description', 'Editing succes');
    }
    public function delAction()
    {
        $params = array('host' => 'localhost', 'username' => 'root', 'password' =>
            'admin', 'dbname' => 'zend');
        $DB = new Zend_Db_Adapter_Pdo_Mysql($params);
        $request = $this->getRequest();
        $DB->delete('user', 'id = ' . $request->getParam('id'));
        $this->view->assign('title', 'Delete Data');
        $this->view->assign('description', 'Deleting succes');
        $this->view->assign('list', $request->getBaseURL() . "/user/list");
    }
}
?>