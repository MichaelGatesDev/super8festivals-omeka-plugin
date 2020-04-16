<?php

class SuperEightFestivals_FilmsController extends Omeka_Controller_AbstractActionController
{
    public function init()
    {
        // Set the model class so this controller can perform some functions,
        // such as $this->findById()
        $this->_helper->db->setDefaultModelName('SuperEightFestivalsFestivalFilm');
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

        $festivalID = $request->getParam('festivalID');
        $festival = get_festival_by_id($festivalID);
        $this->view->festival = $festival;

        $this->redirect("/super-eight-festivals/countries/" . urlencode($country->name) . "/cities/" . urlencode($city->name) . "/festivals/" . $festival->id);
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

        $filmID = $request->getParam('filmID');
        $film = get_film_by_id($filmID);
        $this->view->film = $film;
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

        $festivalID = $request->getParam('festivalID');
        $festival = get_festival_by_id($festivalID);
        $this->view->festival = $festival;

        $film = new SuperEightFestivalsFestivalFilm();
        $film->festival_id = $festival->id;
        $form = $this->_getForm($film);
        $this->view->form = $form;
        $this->view->film = $film;
        $this->_processForm($film, $form, 'add');
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

        $filmID = $request->getParam('filmID');
        $film = get_film_by_id($filmID);
        $this->view->film = $film;

        $form = $this->_getForm($film);
        $this->view->form = $form;
        $this->_processForm($film, $form, 'edit');
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

        $filmID = $request->getParam('filmID');
        $film = get_film_by_id($filmID);
        $this->view->film = $film;

        $form = $this->_getDeleteForm();
        $this->view->form = $form;
        $this->_processForm($film, $form, 'delete');
    }

    protected function _getForm(SuperEightFestivalsFestivalFilm $film = null): Omeka_Form_Admin
    {
        $formOptions = array(
            'type' => 'super_eight_festivals_festival_film'
        );

        $form = new Omeka_Form_Admin($formOptions);

        $form->addElementToEditGroup(
            'select', 'festival_id',
            array(
                'id' => 'festival_id',
                'label' => 'Festival',
                'description' => "The festival which the film was a member of (required)",
                'multiOptions' => get_parent_festival_options(),
                'value' => $film->festival_id,
                'required' => true,
            )
        );

        $form->addElementToEditGroup(
            'select', 'filmmaker_id',
            array(
                'id' => 'filmmaker_id',
                'label' => 'Filmmaker',
                'description' => "The person or organization who made the film",
                'multiOptions' => get_parent_filmmaker_options(),
                'value' => $film->filmmaker_id,
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'select', 'contributor_id',
            array(
                'id' => 'contributor_id',
                'label' => 'Contributor',
                'description' => "The person or organization who contributed the film",
                'multiOptions' => get_parent_contributor_options(),
                'value' => $film->contributor_id,
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'text', 'title',
            array(
                'id' => 'title',
                'label' => 'Title',
                'description' => "The film's title",
                'value' => $film->title,
                'required' => false
            )
        );

        $form->addElementToEditGroup(
            'text', 'description',
            array(
                'id' => 'description',
                'label' => 'Description',
                'description' => "The film's description",
                'value' => $film->description,
                'required' => false
            )
        );

        $form->addElementToEditGroup(
            'textarea', 'embed',
            array(
                'id' => 'embed',
                'label' => 'Embed',
                'description' => "The film's embed",
                'value' => $film->embed,
                'required' => true
            )
        );

        return $form;
    }

    private function _processForm(SuperEightFestivalsFestivalFilm $film, Zend_Form $form, $action)
    {
        // Set the page object to the view.
        $this->view->film = $film;

        if ($this->getRequest()->isPost()) {
            try {
                if (!$form->isValid($_POST)) {
                    $this->_helper->flashMessenger('There was an error on the form. Please try again.', 'error');
                    return;
                }
                try {
                    if ($action == 'delete') {
                        $film->delete();
                        $this->_helper->flashMessenger("The film \"{$film->title}\" has been deleted.", 'success');
                    } else if ($action == 'add') {
                        $film->setPostData($_POST);
                        if ($film->save()) {
                            $this->_helper->flashMessenger("The film \"{$film->title}\" has been added.", 'success');
                        }
                    } else if ($action == 'edit') {
                        $film->setPostData($_POST);
                        if ($film->save()) {
                            $this->_helper->flashMessenger("The film \"{$film->title}\" has been edited.", 'success');
                        }
                    }

                    // bring us back to the city page
                    $this->redirect("/super-eight-festivals/countries/" . urlencode($film->get_country()->name) . "/cities/" . urlencode($film->get_city()->name) . "/festivals/" . $film->festival_id);
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
