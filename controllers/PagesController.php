<?php

class SuperEightFestivals_PagesController extends Omeka_Controller_AbstractActionController
{
    public function init()
    {
        // Set the model class so this controller can perform some functions,
        // such as $this->findById()
        $this->_helper->db->setDefaultModelName('SuperEightFestivalsPage');
    }

    public function indexAction()
    {
        $this->_helper->redirector('browse');
        return;
    }

    public function addAction()
    {
        // Create new page
        $page = new SuperEightFestivalsPage();
        $form = $this->_getForm($page);
        $this->view->form = $form;
        $this->_processForm($page, $form, 'add');
    }

    public function editAction()
    {
        $page = $this->_helper->db->findById();
        $form = $this->_getForm($page);
        $this->view->form = $form;
        $this->_processForm($page, $form, 'edit');
    }

    /**
     * @param SuperEightFestivalsPage|null $page
     * @return Omeka_Form_Admin
     */
    protected function _getForm($page = null)
    {
        $formOptions = array(
            'type' => 'super_eight_festivals_page'
        );

        $form = new Omeka_Form_Admin($formOptions);


        $form->addElementToEditGroup(
            'text', 'title',
            array(
                'id' => 'title',
                'label' => 'title',
                'description' => "The title of this page",
                'value' => $page->title,
                'required' => true
            )
        );
        $form->addElementToEditGroup(
            'text', 'url',
            array(
                'id' => 'url',
                'label' => 'url',
                'description' => "The relative URL to this page",
                'value' => $page->url,
                'required' => true
            )
        );
        $form->addElementToEditGroup(
            'textarea', 'content',
            array(
                'id' => 'url',
                'label' => 'url',
                'description' => "The contents of this page",
                'value' => $page->content,
                'required' => false
            )
        );

        if (class_exists('Omeka_Form_Element_SessionCsrfToken')) {
            try {
                $form->addElement('sessionCsrfToken', 'csrf_token');
            } catch (Zend_Form_Exception $e) {
                echo $e;
            }
        }

        return $form;
    }

    /**
     * @param $page SuperEightFestivalsPage
     * @param $form Omeka_Form
     * @param $action
     */
    private function _processForm($page, $form, $action)
    {
        // Set the page object to the view.
        $this->view->page = $page;

        if ($this->getRequest()->isPost()) {
            try {
                if (!$form->isValid($_POST)) {
                    $this->_helper->flashMessenger('There was an error on the form. Please try again.', 'error');
                    return;
                }
            } catch (Zend_Form_Exception $e) {
                $this->_helper->flashMessenger($e);
            }
            try {
                $page->setPostData($_POST);
                if ($page->save()) {
                    if ($action == 'add') {
                        $this->_helper->flashMessenger(__('The page has been added. (%s)', $page->title), 'success');
                    } else if ($action == 'edit') {
                        $this->_helper->flashMessenger(__('The page has been edited. (%s)', $page->title), 'success');
                    }
                    $this->_helper->redirector('index');
                    return;
                }
                // Catch validation errors.
            } catch (Omeka_Validate_Exception $e) {
                $this->_helper->flashMessenger($e);
            } catch (Omeka_Record_Exception $e) {
                $this->_helper->flashMessenger($e);
            }
        }
    }

}
