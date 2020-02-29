<?php

class SuperEightFestivals_FilmmakersController extends Omeka_Controller_AbstractActionController
{

    public function init()
    {
        // Set the model class so this controller can perform some functions,
        // such as $this->findById()
        $this->_helper->db->setDefaultModelName('SuperEightFestivalsFestivalFilmmaker');
    }

    public function indexAction()
    {
        $this->_helper->redirector('browse');
        return;
    }

    public function addAction()
    {
        // Create new filmmaker
        $filmmaker = new SuperEightFestivalsFestivalFilmmaker();
        $form = $this->_getForm($filmmaker);
        $this->view->form = $form;
        $this->view->filmmaker = $filmmaker;
        $this->_processForm($filmmaker, $form, 'add');
    }

    public function editAction()
    {
        $filmmaker = $this->_helper->db->findById();
        $form = $this->_getForm($filmmaker);
        $this->view->form = $form;
        $this->view->filmmaker = $filmmaker;
        $this->_processForm($filmmaker, $form, 'edit');
    }

    public function viewAction()
    {
        $filmmaker = $this->_helper->db->findById();
        $this->view->filmmaker = $filmmaker;
    }

    protected function _getForm(SuperEightFestivalsFestivalFilmmaker $filmmaker = null): Omeka_Form_Admin
    {
        $formOptions = array(
            'type' => 'super_eight_festivals_festival_filmmaker'
        );

        $form = new Omeka_Form_Admin($formOptions);

        $form->addElementToEditGroup(
            'select', 'festival_id',
            array(
                'id' => 'festival_id',
                'label' => 'Festival',
                'description' => "The festival which the filmmaker was a member of (required)",
                'multiOptions' => get_parent_festival_options(),
                'value' => $filmmaker->festival_id,
                'required' => true,
            )
        );

        $form->addElementToEditGroup(
            'text', 'email',
            array(
                'id' => 'email',
                'label' => 'Email',
                'description' => "The filmmaker's email (required)",
                'value' => $filmmaker->email,
                'required' => true
            )
        );

        $form->addElementToEditGroup(
            'text', 'first_name',
            array(
                'id' => 'first_name',
                'label' => 'First Name',
                'description' => "The filmmaker's first name (if any)",
                'value' => $filmmaker->first_name,
                'required' => false
            )
        );

        $form->addElementToEditGroup(
            'text', 'last_name',
            array(
                'id' => 'last_name',
                'label' => 'Last Name',
                'description' => "The filmmaker's last name (if any)",
                'value' => $filmmaker->last_name,
                'required' => false
            )
        );

        $form->addElementToEditGroup(
            'text', 'organization_name',
            array(
                'id' => 'organization_name',
                'label' => 'Organization Name',
                'description' => "The name of the filmmaker's organization (if any)",
                'value' => $filmmaker->organization_name,
                'required' => false
            )
        );

        return $form;
    }

    private function _processForm(SuperEightFestivalsFestivalFilmmaker $filmmaker, $form, $action)
    {
        // Set the page object to the view.
        $this->view->super_eight_festivals_festival_filmmaker = $filmmaker;

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
                $filmmaker->setPostData($_POST);

                if ($filmmaker->save()) {
                    if ($action == 'add') {
                        $this->_helper->flashMessenger(__('The filmmaker "%s" has been added.', $filmmaker->email), 'success');
                    } else if ($action == 'edit') {
                        $this->_helper->flashMessenger(__('The filmmaker "%s" has been edited.', $filmmaker->email), 'success');
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
