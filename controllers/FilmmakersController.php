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
        $request = $this->getRequest();

        $countryName = $request->getParam('countryName');
        $country = get_country_by_name($countryName);
        $this->view->country = $country;

        $cityName = $request->getParam('cityName');
        $city = get_city_by_name($country->id, $cityName);
        $this->view->city = $city;

        $this->redirect("/super-eight-festivals/countries/" . $country->name . "/cities/" . $city->name);
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

        $filmmaker = new SuperEightFestivalsFestivalFilmmaker();
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

        $form = $this->_getDeleteForm($filmmaker);
        $this->view->form = $form;
        $this->_processForm($filmmaker, $form, 'delete');
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
        $this->view->filmmaker = $filmmaker;

        if ($this->getRequest()->isPost()) {
            if (!$form->isValid($_POST)) {
                $this->_helper->flashMessenger('There was an error on the form. Please try again.', 'error');
                return;
            }

            try {
                if ($action == 'delete') {
                    $filmmaker->delete();
                    $this->_helper->flashMessenger('The filmmaker "%s" has been deleted.', $filmmaker->email, 'success');
                } else if ($action == 'add') {
                    $filmmaker->setPostData($_POST);
                    if ($filmmaker->save()) {
                        $this->_helper->flashMessenger('The filmmaker "%s" has been added.', $filmmaker->email, 'success');
                    }
                } else if ($action == 'edit') {
                    $filmmaker->setPostData($_POST);
                    if ($filmmaker->save()) {
                        $this->_helper->flashMessenger('The filmmaker "%s" has been edited.', $filmmaker->email, 'success');
                    }
                }

                // bring us back to the city page
                $this->redirect("/super-eight-festivals/countries/" . urlencode($filmmaker->get_country()->name) . "/cities/" . urlencode($filmmaker->get_city()->name));
            } catch (Omeka_Validate_Exception $e) {
                $this->_helper->flashMessenger($e);
            } catch (Omeka_Record_Exception $e) {
                $this->_helper->flashMessenger($e);
            }
        }
    }

}
