<?php

class pageController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $pageModel = new Model_Page();
        $recentPages = $pageModel->getRecentPages();
        if (is_array($recentPages)) {
            // the 3 most recent items are the featured items
            for ($i = 1; $i <= 3; $i++) {
                if (count($recentPages) > 0) {
                    $featuredItems[] = array_shift($recentPages);
                }
            }
            $this->view->featuredItems = $featuredItems;
            if (count($recentPages) > 0) {
                $this->view->recentPages = $recentPages;
            } else {
                $this->view->recentPages = $null;
            }
        }
    }

    public function openAction()
    {
        $title = $this->_request->getParam('title');
        $id = $this->_request->getParam('id');
        // first confirm the page exists
        $mdlPage = new Model_Page();
        $select = $mdlPage->select();
        $select->where('name = ?', $title);
        $row = $mdlPage->fetchRow($select);
        if ($row) {
            $this->view->page = new CMS_Content_Item_Page($row->id);
        } else {
            // the error handler will catch this exception
            throw new Zend_Controller_Action_Exception("The page you requested was not found",
                404);
        }
    }
    
    
    
    public function createAction()
    {
        $pageForm = new Form_PageForm();
        if ($this->getRequest()->isPost()) {
            if ($pageForm->isValid($_POST)) {
                // create a new page item
                $itemPage = new CMS_Content_Item_Page();
                $itemPage->name = $pageForm->getValue('name');
                $itemPage->headline = $pageForm->getValue('headline');
                $itemPage->description = $pageForm->getValue('description');
                $itemPage->content = $pageForm->getValue('content');
                // upload the image
                if ($pageForm->image->isUploaded()) {
                    $pageForm->image->receive();
                    $itemPage->image = '/images/upload/' . basename($pageForm->image->getFileName());
                }
                // save the content item
                $itemPage->save();
                return $this->_forward('list');
            }
        }
        $pageForm->setAction('/zendf/page/create');
        $this->view->form = $pageForm;
    }


    public function listAction()
    {
        $pageModel = new Model_Page();
        // fetch all of the current pages
        $select = $pageModel->select();
        $select->order('name');
        $currentPages = $pageModel->fetchAll($select);
        if ($currentPages->count() > 0) {
            $this->view->pages = $currentPages;
        } else {
            $this->view->pages = null;
        }
    }

    public function editAction()
    {
        $id = $this->_request->getParam('id');
        $itemPage = new CMS_Content_Item_Page($id);
        $pageForm = new Form_PageForm();
        $pageForm->setAction('/zendf/page/edit');
        if ($this->getRequest()->isPost()) {
            if ($pageForm->isValid($_POST)) {
                $itemPage->name = $pageForm->getValue('name');
                $itemPage->headline = $pageForm->getValue('headline');
                $itemPage->description = $pageForm->getValue('description');
                $itemPage->content = $pageForm->getValue('content');
                if ($pageForm->image->isUploaded()) {
                    $pageForm->image->receive();
                    $itemPage->image = '/zendf/images/upload/' . basename($pageForm->image->
                        getFileName());
                }
                // save the content item
                $itemPage->save();
                $this->_redirect('/page/list');
            }
        }
        $pageForm->populate($itemPage->toArray());
        // create the image preview
        $imagePreview = $pageForm->createElement('image', 'image_preview');
        // element options
        $imagePreview->setLabel('Preview Image: ');
        $imagePreview->setAttrib('style', 'width:200px;height:auto;');
        // add the element to the form
        $imagePreview->setOrder(4);
        $imagePreview->setImage($itemPage->image);
        $pageForm->addElement($imagePreview);
        $this->view->form = $pageForm;
    }

    public function deleteAction()
    {
        $id = $this->_request->getParam('id');
        $itemPage = new CMS_Content_Item_Page($id);
        $itemPage->delete();
        $this->_redirect('/page/list');
    }
}
?>
