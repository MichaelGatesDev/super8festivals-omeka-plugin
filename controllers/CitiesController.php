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
        return;
    }

    public function addAction()
    {
        // Create new city
        $city = new SuperEightFestivalsCity();
        $form = $this->_getForm($city);
        $this->view->form = $form;
        $this->_processForm($city, $form, 'add');
        return;
    }

    public function editAction()
    {
        // Get the requested city
        $city = $this->_helper->db->findById();
        $form = $this->_getForm($city);
        $this->view->form = $form;
        $this->_processForm($city, $form, 'edit');
    }

    public function browseAction()
    {
        return;
    }

    protected function _getForm($city = null)
    {
        if ($city && $city->exists()) {
            $formOptions['record'] = $city;
        }

        $form = new Omeka_Form_Admin(
            array(
                'type' => 'super_eight_festivals_city'
            )
        );

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
