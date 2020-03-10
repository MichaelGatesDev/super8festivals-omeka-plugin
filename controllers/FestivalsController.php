<?php

class SuperEightFestivals_FestivalsController extends Omeka_Controller_AbstractActionController
{

    public function init()
    {
        // Set the model class so this controller can perform some functions,
        // such as $this->findById()
        $this->_helper->db->setDefaultModelName('SuperEightFestivalsFestival');
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

        $festivalID = $request->getParam('festivalID');
        $festival = get_festival_by_id($festivalID);
        $this->view->festival = $festival;

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

        // Create new city
        $festival = new SuperEightFestivalsFestival();
        $festival->city_id = $city->id;
        $form = $this->_getForm($festival);
        $this->view->form = $form;
        $this->_processForm($festival, $form, 'add');
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

        $festivalID = $request->getParam('festivalID');
        $festival = get_festival_by_id($festivalID);
        $this->view->festival = $festival;

        $form = $this->_getForm($festival);
        $this->view->form = $form;
        $this->_processForm($festival, $form, 'edit');
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

        $festivalID = $request->getParam('festivalID');
        $festival = get_festival_by_id($festivalID);
        $this->view->festival = $festival;

        $form = $this->_getDeleteForm();
        $this->view->form = $form;
        $this->_processForm($festival, $form, 'delete');
    }

    protected function _getForm(SuperEightFestivalsFestival $festival = null): Omeka_Form_Admin
    {
        $formOptions = array(
            'type' => 'super_eight_festivals_festival'
        );

        $form = new Omeka_Form_Admin($formOptions);

        $form->addElementToEditGroup(
            'select', 'city_id',
            array(
                'id' => 'city_id',
                'label' => 'City',
                'description' => "The city which the festival was held in (required)",
                'multiOptions' => get_parent_city_options(),
                'value' => $festival->city_id,
                'required' => true
            )
        );

        $form->addElementToEditGroup(
            'text', 'year',
            array(
                'id' => 'year',
                'label' => 'Year',
                'description' => "The year in which the festival was held",
                'value' => $festival->year == -1 ? "" : $festival->year,
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'text', 'title',
            array(
                'id' => 'title',
                'label' => 'Title',
                'description' => "The title of the festival",
                'value' => $festival->title,
                'required' => false
            )
        );

        $form->addElementToEditGroup(
            'text', 'description',
            array(
                'id' => 'description',
                'label' => 'Description',
                'description' => "The description of the festival",
                'value' => $festival->description,
                'required' => false
            )
        );

        return $form;
    }


    private function _processForm(SuperEightFestivalsFestival $festival, Zend_Form $form, $action)
    {
        $this->view->festival = $festival;

        if ($this->getRequest()->isPost()) {
            try {
                if (!$form->isValid($_POST)) {
                    $this->_helper->flashMessenger('There was an error on the form. Please try again.', 'error');
                    return;
                }
                try {
                    if ($action == 'delete') {
                        $festival->delete();
                        $this->_helper->flashMessenger('The festival' . $festival->id . 'has been deleted.', 'success');
                    } else {
                        $festival->setPostData($_POST);
                        if ($festival->save()) {
                            if ($action == 'add') {
                                $this->_helper->flashMessenger('The festival has been added. (ID:' . $festival->id . ')', 'success');
                            } else if ($action == 'edit') {
                                $this->_helper->flashMessenger('The festival' . $festival->id . 'has been edited.', 'success');
                            }
                        }
                    }

                    $this->redirect("/super-eight-festivals/countries/" . urlencode($festival->get_country()->name) . "/cities/" . urlencode($festival->get_city()->name));
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
