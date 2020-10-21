<?php

class SuperEightFestivals_AdminCountryCityFestivalFilmsController extends Omeka_Controller_AbstractActionController
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

        $this->view->country = $country = get_request_param_country($request);
        $this->view->city = $city = get_request_param_city($request);
        $this->view->festival = $festival = get_request_param_by_id($request, SuperEightFestivalsFestival::class, "festivalID");

        $this->redirect("/super-eight-festivals/countries/" . urlencode($country->name) . "/cities/" . urlencode($city->name) . "/festivals/" . $festival->id);
    }

    public function singleAction()
    {
        $request = $this->getRequest();

        $this->view->country = $country = get_request_param_country($request);
        $this->view->city = $city = get_request_param_city($request);
        $this->view->festival = $festival = get_request_param_by_id($request, SuperEightFestivalsFestival::class, "festivalID");

        $filmID = $request->getParam('filmID');
        $film = SuperEightFestivalsFestivalFilm::get_by_id($filmID);
        $this->view->film = $film;
    }


    public function addAction()
    {
        $request = $this->getRequest();

        $this->view->country = $country = get_request_param_country($request);
        $this->view->city = $city = get_request_param_city($request);
        $this->view->festival = $festival = get_request_param_by_id($request, SuperEightFestivalsFestival::class, "festivalID");

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

        $this->view->country = $country = get_request_param_country($request);
        $this->view->city = $city = get_request_param_city($request);
        $this->view->festival = $festival = get_request_param_by_id($request, SuperEightFestivalsFestival::class, "festivalID");
        $this->view->film = $film = get_request_param_by_id($request, SuperEightFestivalsFestivalFilm::class, "filmID");

        $form = $this->_getForm($film);
        $this->view->form = $form;
        $this->_processForm($film, $form, 'edit');
    }

    public function deleteAction()
    {
        $request = $this->getRequest();

        $this->view->country = $country = get_request_param_country($request);
        $this->view->city = $city = get_request_param_city($request);
        $this->view->festival = $festival = get_request_param_by_id($request, SuperEightFestivalsFestival::class, "festivalID");
        $this->view->film = $film = get_request_param_by_id($request, SuperEightFestivalsFestivalFilm::class, "filmID");

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
