<?php

class SuperEightFestivals_FilmmakersController extends Omeka_Controller_AbstractActionController
{
    public function init()
    {
        // Set the model class so this controller can perform some functions,
        // such as $this->findById()
        $this->_helper->db->setDefaultModelName('SuperEightFestivalsFilmmaker');
    }

    public function indexAction()
    {
        $request = $this->getRequest();

        $countryName = $request->getParam('countryName');
        $country = get_country_by_name($countryName);
        $this->view->country = $country;

        $cityName = $request->getParam('cityName');
        $city = get_city_by_name($country->id, $cityName);
        $this->view->city = $city;

        $filmmakerID = $request->getParam('filmmakerID');
        $filmmaker = get_filmmaker_by_id($filmmakerID);
        $this->view->filmmaker = $filmmaker;

        $this->redirect("/super-eight-festivals/countries/" . urlencode($country->name) . "/cities/" . urlencode($city->name));
        return;
    }

    public function singleAction()
    {
        $request = $this->getRequest();

        $countryName = $request->getParam('countryName');
        $country = get_country_by_name($countryName);
        $this->view->country = $country;

        $cityName = $request->getParam('cityName');
        $city = get_city_by_name($country->id, $cityName);
        $this->view->city = $city;

        $filmmakerID = $request->getParam('filmmakerID');
        $filmmaker = get_filmmaker_by_id($filmmakerID);
        $this->view->filmmaker = $filmmaker;
        return;
    }


    public function addAction()
    {
        $request = $this->getRequest();

        $countryName = $request->getParam('countryName');
        $country = get_country_by_name($countryName);
        $this->view->country = $country;

        $cityName = $request->getParam('cityName');
        $city = get_city_by_name($country->id, $cityName);
        $this->view->city = $city;

        $filmmaker = new SuperEightFestivalsFilmmaker();
        $filmmaker->city_id = $city->id;
        $form = $this->_getForm($filmmaker);
        $this->view->form = $form;
        $this->view->filmmaker = $filmmaker;
        $this->_processForm($filmmaker, $form, 'add');
    }

    public function editAction()
    {
        $request = $this->getRequest();

        $countryName = $request->getParam('countryName');
        $country = get_country_by_name($countryName);
        $this->view->country = $country;

        $cityName = $request->getParam('cityName');
        $city = get_city_by_name($country->id, $cityName);
        $this->view->city = $city;

        $filmmakerID = $request->getParam('filmmakerID');
        $filmmaker = get_filmmaker_by_id($filmmakerID);
        $this->view->filmmaker = $filmmaker;

        $form = $this->_getForm($filmmaker);
        $this->view->form = $form;
        $this->_processForm($filmmaker, $form, 'edit');
    }

    public function deleteAction()
    {
        $request = $this->getRequest();

        $countryName = $request->getParam('countryName');
        $country = get_country_by_name($countryName);
        $this->view->country = $country;

        $cityName = $request->getParam('cityName');
        $city = get_city_by_name($country->id, $cityName);
        $this->view->city = $city;

        $filmmakerID = $request->getParam('filmmakerID');
        $filmmaker = get_filmmaker_by_id($filmmakerID);
        $this->view->filmmaker = $filmmaker;

        $form = $this->_getDeleteForm();
        $this->view->form = $form;
        $this->_processForm($filmmaker, $form, 'delete');
    }

    protected function _getForm(SuperEightFestivalsFilmmaker $filmmaker = null): Omeka_Form_Admin
    {
        $formOptions = array(
            'type' => 'super_eight_festivals_filmmaker'
        );

        $form = new Omeka_Form_Admin($formOptions);

        $form->addElementToEditGroup(
            'text', 'email',
            array(
                'id' => 'email',
                'label' => 'Email',
                'description' => "The filmmaker's email",
                'value' => $filmmaker->email,
                'required' => false
            )
        );

        $form->addElementToEditGroup(
            'text', 'first_name',
            array(
                'id' => 'first_name',
                'label' => 'First Name',
                'description' => "The filmmaker's first name",
                'value' => $filmmaker->first_name,
                'required' => false
            )
        );

        $form->addElementToEditGroup(
            'text', 'last_name',
            array(
                'id' => 'last_name',
                'label' => 'Last Name',
                'description' => "The filmmaker's last name",
                'value' => $filmmaker->last_name,
                'required' => false
            )
        );

        $form->addElementToEditGroup(
            'text', 'organization_name',
            array(
                'id' => 'organization_name',
                'label' => 'Organization Name',
                'description' => "The name of the filmmaker's organization",
                'value' => $filmmaker->organization_name,
                'required' => false
            )
        );

        return $form;
    }

    private function _processForm(SuperEightFestivalsFilmmaker $filmmaker, Zend_Form $form, $action)
    {
        // Set the page object to the view.
        $this->view->filmmaker = $filmmaker;

        if ($this->getRequest()->isPost()) {
            try {
                if (!$form->isValid($_POST)) {
                    $this->_helper->flashMessenger('There was an error on the form. Please try again.', 'error');
                    return;
                }
                try {
                    if ($action == 'delete') {
                        $filmmaker->delete();
                        $this->_helper->flashMessenger('The filmmaker' . $filmmaker->get_display_name() . ' has been deleted.', 'success');
                    } else if ($action == 'add') {
                        $filmmaker->setPostData($_POST);
                        if ($filmmaker->save()) {
                            $this->_helper->flashMessenger('The filmmaker' . $filmmaker->get_display_name() . ' has been added.', 'success');
                        }
                    } else if ($action == 'edit') {
                        $filmmaker->setPostData($_POST);
                        if ($filmmaker->save()) {
                            $this->_helper->flashMessenger('The filmmaker' . $filmmaker->get_display_name() . ' has been edited.', 'success');
                        }
                    }


                    $this->redirect("/super-eight-festivals/countries/" . urlencode($filmmaker->get_country()->name) . "/cities/" . urlencode($filmmaker->get_city()->name));
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
