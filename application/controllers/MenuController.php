<?php
class MenuController extends Zend_Controller_Action
{
    public function init()
    {
        /* Initialize action controller here */
    }


    public function indexAction()
    {
        $mdlMenu = new Model_Menu();
        $this->view->menu = $mdlMenu->getMenus();
    }


    public function createAction()
    {
        $frmMenu = new Form_Menu();
        if ($this->getRequest()->isPost()) {
            if ($frmMenu->isValid($_POST)) {
                $menuName = $frmMenu->getValue('name');
                $mdlMenu = new Model_Menu();
                $result = $mdlMenu->createMenu($menuName);
                if ($result) {
                    // redirect to the index action
                    $this->_redirect('/menu/index');
                }
            }
        }
        $frmMenu->setAction('/zendf/menu/create');
        $this->view->form = $frmMenu;
    }

    public function editAction()
    {
        $id = $this->_request->getParam('id');
        $mdlMenu = new Model_Menu();
        $frmMenu = new Form_Menu();
        // if this is a postback, then process the form if valid
        if ($this->getRequest()->isPost()) {
            if ($frmMenu->isValid($_POST)) {
                $menuName = $frmMenu->getValue('name');
                $mdlMenu = new Model_Menu();
                $result = $mdlMenu->updateMenu($id, $menuName);
                if ($result) {
                    // redirect to the index action
                    return $this->_forward('index');
                }
            }
        } else {
            // fetch the current menu from the db
            $currentMenu = $mdlMenu->find($id)->current();
            // populate the form
            $frmMenu->getElement('id')->setValue($currentMenu->id);
            $frmMenu->getElement('name')->setValue($currentMenu->name);
        }
        $frmMenu->setAction('/zendf/menu/edit');
        // pass the form to the view to render
        $this->view->form = $frmMenu;
    }


    public function deleteAction()
    {
        $id = $this->_request->getParam('id');
        $mdlMenu = new Model_Menu();
        $mdlMenu->deleteMenu($id);
        $this->_redirect('menu/');
    }

    public function renderAction()
    {
        $menu = $this->_request->getParam('menu');
        $mdlMenuItems = new Model_MenuItem();
        $menuItems = $mdlMenuItems->getItemsByMenu($menu);
        if (count($menuItems) > 0) {
            foreach ($menuItems as $item) {
                $label = $item->label;
                if (!empty($item->link)) { // First, Check for link
                    $uri = $item->link;
                } else {
                    // update this to form more search-engine-friendly URLs
                    $page = new CMS_Content_Item_Page($item->page_id);
                    $uri = '/zendf/page/open/title/' . $page->name;
                }
                $itemArray[] = array('label' => $label, 'uri' => $uri);
            }
            $container = new Zend_Navigation($itemArray);
            $this->view->navigation()->setContainer($container);
        }
    }
}
