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
        return;
    }

    public function singleAction()
    {
        $request = $this->getRequest();

        $countryName = $request->getParam('countryName');
        $country = get_country_by_name($countryName);
        $this->view->country = $country;

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
        $request = $this->getRequest();

        $countryName = $request->getParam('countryName');
        $country = get_country_by_name($countryName);
        $form = $this->_getForm($country);
        $this->view->form = $form;
        $this->_processForm($country, $form, 'edit');
    }

    public function deleteAction()
    {
        $request = $this->getRequest();

        $countryName = $request->getParam('countryName');
        $country = get_country_by_name($countryName);
        $this->view->country = $country;

        $form = $this->_getDeleteForm();
        $this->view->form = $form;
        $this->_processForm($country, $form, 'delete');
    }

    protected function _getForm(SuperEightFestivalsCountry $country = null)
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
        $form->addElementToEditGroup(
            'text', 'latitude',
            array(
                'id' => 'latitude',
                'label' => 'Latitude',
                'description' => "The latitude of the country (optional)",
                'value' => $country->latitude,
                'required' => false
            )
        );
        $form->addElementToEditGroup(
            'text', 'longitude',
            array(
                'id' => 'longitude',
                'label' => 'Longitude',
                'description' => "The longitude of the country (optional)",
                'value' => $country->longitude,
                'required' => false
            )
        );

        return $form;
    }

    private function _processForm(SuperEightFestivalsCountry $country, Zend_Form $form, $action)
    {
        $this->view->country = $country;

        if ($this->getRequest()->isPost()) {
            try {
                if (!$form->isValid($_POST)) {
                    $this->_helper->flashMessenger('There was an error on the form. Please try again.', 'error');
                    return;
                }
                try {
                    if ($action == 'delete') {
                        $country->delete();
                        $this->_helper->flashMessenger('The country "%s" has been deleted.', $country->name, 'success');
                        $this->redirect("/super-eight-festivals/countries/");
                    } else {
                        $country->setPostData($_POST);
                        if ($country->save()) {
                            if ($action == 'add') {
                                $this->_helper->flashMessenger('The country "%s" has been added.', $country->name, 'success');
                            } else if ($action == 'edit') {
                                $this->_helper->flashMessenger('The country "%s" has been edited.', $country->name, 'success');
                            }
                        }
                    }

                    $this->redirect("/super-eight-festivals/countries/" . urlencode($country->name));
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
