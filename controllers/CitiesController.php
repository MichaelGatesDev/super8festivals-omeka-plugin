<?php

class SuperEightFestivals_CitiesController extends Omeka_Controller_AbstractActionController
{

    public function init()
    {
        // Set the model class so this controller can perform some functions,
        // such as $this->findById()
        $this->_helper->db->setDefaultModelName('SuperEightFestivalsCity');
    }

    public function indexAction()
    {
        $this->_helper->redirector('browse');
        return;
    }

    public function addAction()
    {
        // Create new city
        $city = new SuperEightFestivalsCity();
        $form = $this->_getForm($city);
        $this->view->form = $form;
        $this->_processForm($city, $form, 'add');
    }

    public function editAction()
    {
        $city = $this->_helper->db->findById();
        $form = $this->_getForm($city);
        $this->view->form = $form;
        $this->_processForm($city, $form, 'edit');
    }

    public function viewAction()
    {
        $city = $this->_helper->db->findById();
        $this->view->city = $city;
    }

    protected function _getForm(SuperEightFestivalsCity $city = null): Omeka_Form_Admin
    {
        $formOptions = array(
            'type' => 'super_eight_festivals_city'
        );

        $form = new Omeka_Form_Admin($formOptions);

        $form->addElementToEditGroup(
            'select', 'country_id',
            array(
                'id' => 'country_id',
                'label' => 'Country ID',
                'description' => "The ID of the country (required)",
                'multiOptions' => get_parent_country_options(),
                'value' => $city->country_id,
                'required' => true
            )
        );

        $form->addElementToEditGroup(
            'text', 'name',
            array(
                'id' => 'name',
                'label' => 'City Name',
                'description' => "The name of the city (required)",
                'value' => $city->name,
                'required' => true
            )
        );

        $form->addElementToEditGroup(
            'text', 'latitude',
            array(
                'id' => 'latitude',
                'label' => 'Latitude',
                'description' => "The latitudinal position of the capital or center of mass (required)",
                'value' => $city->latitude,
                'required' => true
            )
        );

        $form->addElementToEditGroup(
            'text', 'longitude',
            array(
                'id' => 'longitude',
                'label' => 'Longitude',
                'description' => "The longitudinal position of the capital or center of mass (required)",
                'value' => $city->longitude,
                'required' => true
            )
        );

        return $form;
    }

    private function _processForm(SuperEightFestivalsCity $city, Omeka_Form $form, string $action)
    {
        // Set the page object to the view.
        $this->view->super_eight_festivals_city = $city;

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
                $city->setPostData($_POST);
                if ($city->save()) {
                    if ($action == 'add') {
                        $this->_helper->flashMessenger(__('The city "%s" has been added.', $city->name), 'success');
                    } else if ($action == 'edit') {
                        $this->_helper->flashMessenger(__('The city "%s" has been edited.', $city->name), 'success');
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
