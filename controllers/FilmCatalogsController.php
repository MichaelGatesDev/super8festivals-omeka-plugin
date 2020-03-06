<?php

class SuperEightFestivals_FilmCatalogsController extends Omeka_Controller_AbstractActionController
{

    public function init()
    {
        // Set the model class so this controller can perform some functions,
        // such as $this->findById()
        $this->_helper->db->setDefaultModelName('SuperEightFestivalsFestivalFilmCatalog');
    }

    public function indexAction()
    {
        $request = $this->getRequest();

        $countryName = $request->getParam('countryName');
        $country = get_country_by_name($countryName);
        $this->view->country = $country;

        $cityName = $request->getParam('cityName');
        $city = get_city_by_name(get_country_by_name($countryName)->id, $cityName);
        $this->view->city = $city;

        return;
    }

    public function singleAction()
    {
        $request = $this->getRequest();

        $countryName = $request->getParam('countryName');
        $country = get_country_by_name($countryName);
        $this->view->country = $country;

        $cityName = $request->getParam('cityName');
        $city = get_city_by_name(get_country_by_name($countryName)->id, $cityName);
        $this->view->city = $city;

        $filmCatalogID = $request->getParam('filmCatalogID');
        $film_catalog = get_film_catalog_by_id($filmCatalogID);
        $this->view->film_catalog = $film_catalog;
        return;
    }

    public function addAction()
    {
        $request = $this->getRequest();

        $countryName = $request->getParam('countryName');
        $country = get_country_by_name($countryName);
        $this->view->country = $country;

        $cityName = $request->getParam('cityName');
        $city = get_city_by_name(get_country_by_name($countryName)->id, $cityName);
        $this->view->city = $city;

        $catalog = new SuperEightFestivalsFestivalFilmCatalog();
        $catalog->country_id = $country->id;
        $catalog->city_id = $city->id;
        $form = $this->_getForm($catalog);
        $this->view->form = $form;
        $this->_processForm($catalog, $form, 'add');
    }

    public function deleteAction()
    {
        $request = $this->getRequest();

        $countryName = $request->getParam('countryName');
        $country = get_country_by_name($countryName);
        $this->view->country = $country;

        $cityName = $request->getParam('cityName');
        $city = get_city_by_name(get_country_by_name($countryName)->id, $cityName);
        $this->view->city = $city;

        $filmCatalogID = $request->getParam('filmCatalogID');
        $film_catalog = get_film_catalog_by_id($filmCatalogID);
        $this->view->film_catalog = $film_catalog;

        $form = $this->_getDeleteForm();
        $this->view->form = $form;
        $this->_processForm($film_catalog, $form, 'delete');
    }

    protected function _getForm(SuperEightFestivalsFestivalFilmCatalog $film_catalog = null): Omeka_Form_Admin
    {
        $formOptions = array(
            'type' => 'super_eight_festivals_festival_film_catalog'
        );

        $form = new Omeka_Form_Admin($formOptions);

        $form->addElementToEditGroup(
            'select', 'festival_id',
            array(
                'id' => 'festival_id',
                'label' => 'Festival',
                'description' => "The festival which the catalog was a member of (required)",
                'multiOptions' => array_merge(array("Select..."), get_parent_festival_options()),
                'value' => $film_catalog->festival_id,
                'required' => true,
            )
        );

        $form->addElementToEditGroup(
            'select', 'contributor_id',
            array(
                'id' => 'contributor_id',
                'label' => 'Contributor',
                'description' => "The person who contributed the item",
                'multiOptions' => array_merge(array("Select..."), get_parent_contributor_options()),
                'value' => $film_catalog->contributor_id,
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'text', 'title',
            array(
                'id' => 'title',
                'label' => 'Title',
                'description' => "The catalog's title",
                'value' => $film_catalog->title,
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'text', 'description',
            array(
                'id' => 'description',
                'label' => 'Description',
                'description' => "The catalog's description",
                'value' => $film_catalog->description,
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'file', 'file',
            array(
                'id' => 'file',
                'label' => 'File',
                'description' => "The film catalog file",
                'required' => true,
            )
        );

        $form->addElementToEditGroup(
            'textarea', 'embed',
            array(
                'id' => 'embed',
                'label' => 'Embed Code',
                'description' => "The catalog's embed code",
                'value' => $film_catalog->embed,
                'required' => false,
            )
        );

        return $form;
    }

    private function _processForm(SuperEightFestivalsFestivalFilmCatalog $film_catalog, $form, $action)
    {
        $this->view->film_catalog = $film_catalog;

        if ($this->getRequest()->isPost()) {
            if (!$form->isValid($_POST)) {
                $this->_helper->flashMessenger('There was an error on the form. Please try again.', 'error');
                return;
            }
            try {
                if ($action == 'delete') {
                    $film_catalog->delete();
                    $this->_helper->flashMessenger("The film catalog for " . $film_catalog->get_city()->name . " has been deleted.", 'success');
                    $this->redirect("/super-eight-festivals/countries/" . $film_catalog->get_country()->name . "/cities/" . $film_catalog->get_city()->name . "/film-catalogs");
                } else if ($action == 'add') {

                    // do file upload
                    list($original_name, $temporary_name, $extension) = get_temporary_file("file");
                    $newFileName = uniqid("film_catalog_") . "." . $extension;
                    move_to_dir($temporary_name, $newFileName, get_film_catalogs_dir($film_catalog->get_country()->name, $film_catalog->get_city()->name));

                    $film_catalog->setPostData($_POST);
                    $film_catalog->file_name = $newFileName;
                    if ($film_catalog->save()) {
                        if ($action == 'add') {
                            $this->_helper->flashMessenger("The film catalog for " . $film_catalog->get_city()->name . " has been added.", 'success');
                        }
                        $this->redirect("/super-eight-festivals/countries/" . $film_catalog->get_country()->name . "/cities/" . $film_catalog->get_city()->name . "/film-catalogs");
                    }
                }
            } catch (Omeka_Validate_Exception $e) {
                $this->_helper->flashMessenger($e);
            } catch (Omeka_Record_Exception $e) {
                $this->_helper->flashMessenger($e);
            }
        }
    }

}
