<?php

class SuperEightFestivals_CountriesController extends Omeka_Controller_AbstractActionController
{

    public function init()
    {
        // Set the model class so this controller can perform some functions,
        // such as $this->findById()
        $this->_helper->db->setDefaultModelName('SuperEightFestivalsCountry');
    }

    public function indexAction()
    {
        $this->_helper->redirector('browse');
        return;
    }

    public function addAction()
    {
        // Create new country
        $country = new SuperEightFestivalsCountry();
        $form = $this->_getForm($country);
        $this->view->form = $form;
        $this->_processForm($country, $form, 'add');
    }

    public function editAction()
    {
        $country = $this->_helper->db->findById();
        $form = $this->_getForm($country);
        $this->view->form = $form;
        $this->_processForm($country, $form, 'edit');
    }

    /**
     * @param SuperEightFestivalsCountry|null $country
     * @return Omeka_Form_Admin
     */
    protected function _getForm($country = null)
    {
        $formOptions = array(
            'type' => 'super_eight_festivals_country'
        );

        $form = new Omeka_Form_Admin($formOptions);

        $form->addElementToEditGroup(
            'text', 'name',
            array(
                'id' => 'name',
                'label' => 'Country',
                'description' => "The name of the country (required)",
                'value' => $country->name,
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
     * @param $country SuperEightFestivalsCountry
     * @param $form Omeka_Form
     * @param $action
     */
    private function _processForm($country, $form, $action)
    {
        // Set the page object to the view.
        $this->view->country = $country;

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
                $country->setPostData($_POST);
                if ($country->save()) {
                    if ($action == 'add') {
                        $this->_helper->flashMessenger(__('The country "%s" has been added.', $country->name), 'success');
                    } else if ($action == 'edit') {
                        $this->_helper->flashMessenger(__('The country "%s" has been edited.', $country->name), 'success');
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
