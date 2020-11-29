<?php

class SuperEightFestivals_AdminContributorsController extends Omeka_Controller_AbstractActionController
{
    public function init()
    {
        // Set the model class so this controller can perform some functions,
        // such as $this->findById()
        $this->_helper->db->setDefaultModelName('SuperEightFestivalsContributor');
    }

    public function indexAction()
    {
    }

    public function singleAction()
    {
        $request = $this->getRequest();

        $contributorID = $request->getParam('contributorID');
        $contributor = SuperEightFestivalsContributor::get_by_id($contributorID);
        $this->view->contributor = $contributor;
    }

    public function addAction()
    {
        // Create new contributor
        $contributor = new SuperEightFestivalsContributor();
        $form = $this->_getForm($contributor);
        $this->view->form = $form;
        $this->_processForm($contributor, $form, 'add');
    }

    public function editAction()
    {
        $request = $this->getRequest();

        $contributorID = $request->getParam('contributorID');
        $contributor = SuperEightFestivalsContributor::get_by_id($contributorID);
        $form = $this->_getForm($contributor);
        $this->view->form = $form;
        $this->_processForm($contributor, $form, 'edit');
    }

    public function deleteAction()
    {
        $request = $this->getRequest();

        $contributorID = $request->getParam('contributorID');
        $contributor = SuperEightFestivalsContributor::get_by_id($contributorID);
        $this->view->contributor = $contributor;

        $form = $this->_getDeleteForm();
        $this->view->form = $form;
        $this->_processForm($contributor, $form, 'delete');
    }

    protected function _getForm(SuperEightFestivalsContributor $contributor = null)
    {
        $formOptions = array(
            'type' => 'super_eight_festivals_contributor'
        );

        $form = new Omeka_Form_Admin($formOptions);

        $form->addElementToEditGroup(
            'text', 'email',
            array(
                'id' => 'email',
                'label' => 'Email',
                'description' => "The contributor's email",
                'value' => $contributor->email,
                'required' => false
            )
        );

        $form->addElementToEditGroup(
            'text', 'first_name',
            array(
                'id' => 'first_name',
                'label' => 'First Name',
                'description' => "The contributor's first name",
                'value' => $contributor->first_name,
                'required' => false
            )
        );

        $form->addElementToEditGroup(
            'text', 'last_name',
            array(
                'id' => 'last_name',
                'label' => 'Last Name',
                'description' => "The contributor's last name",
                'value' => $contributor->last_name,
                'required' => false
            )
        );

        $form->addElementToEditGroup(
            'text', 'organization_name',
            array(
                'id' => 'organization_name',
                'label' => 'Organization Name',
                'description' => "The name of the contributor's organization",
                'value' => $contributor->organization_name,
                'required' => false
            )
        );

        return $form;
    }

    private function _processForm(SuperEightFestivalsContributor $contributor, Zend_Form $form, $action)
    {
        $this->view->contributor = $contributor;

        if ($this->getRequest()->isPost()) {
            try {
                if (!$form->isValid($_POST)) {
                    $this->_helper->flashMessenger('There was an error on the form. Please try again.', 'error');
                    return;
                }
                try {
                    if ($action == 'delete') {
                        $contributor->delete();
                        $this->_helper->flashMessenger("The contributor " . $contributor->get_display_name() . " has been deleted.", 'success');
                    } else {
                        $contributor->setPostData($_POST);
                        if ($contributor->save()) {
                            if ($action == 'add') {
                                $this->_helper->flashMessenger("The contributor " . $contributor->get_display_name() . " has been added.", 'success');
                            } else if ($action == 'edit') {
                                $this->_helper->flashMessenger("The contributor " . $contributor->get_display_name() . " has been edited.", 'success');
                            }
                        }
                    }

                    $this->redirect("/super-eight-festivals/contributors/");
//                    $this->redirect("/super-eight-festivals/contributors/" . urlencode($contributor->name));
                } catch (Omeka_Validate_Exception $e) {
                    $this->_helper->flashMessenger($e);
                } catch (Omeka_Record_Exception $e) {
                    $this->_helper->flashMessenger($e);
                }
            } catch (Zend_Form_Exception $e) {
                $this->_helper->flashMessenger($e);
            }
        }
    }

}
