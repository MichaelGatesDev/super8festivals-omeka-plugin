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

    /**
     * @param SuperEightFestivalsCity|null $city
     * @return Omeka_Form_Admin
     */
    protected function _getForm($city = null)
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
                'multiOptions' => get_parent_country_options($city),
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
            'text', 'coordinate_north',
            array(
                'id' => 'coordinate_north',
                'label' => 'Coordinate (North)',
                'description' => "The northern geographical coordinate",
                'value' => $city->coordinate_north,
                'required' => true
            )
        );

        $form->addElementToEditGroup(
            'text', 'coordinate_east',
            array(
                'id' => 'coordinate_east',
                'label' => 'Coordinate (North)',
                'description' => "The eastern geographical coordinate",
                'value' => $city->coordinate_east,
                'required' => true
            )
        );

        $form->addElementToEditGroup(
            'text', 'coordinate_north',
            array(
                'id' => 'coordinate_north',
                'label' => 'Coordinate (North)',
                'description' => "The western geographical coordinate",
                'value' => $city->coordinate_north,
                'required' => true
            )
        );

        $form->addElementToEditGroup(
            'text', 'coordinate_west',
            array(
                'id' => 'coordinate_west',
                'label' => 'Coordinate (North)',
                'description' => "The southern geographical coordinate",
                'value' => $city->coordinate_west,
                'required' => true
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
     * @param $city SuperEightFestivalsCity
     * @param $form Omeka_Form
     * @param $action
     */
    private function _processForm($city, $form, $action)
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
