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
        $city = get_city_by_name($country->id, $cityName);
        $this->view->city = $city;

        $festivalID = $request->getParam('festivalID');
        $festival = get_festival_by_id($festivalID);
        $this->view->festival = $festival;

        $this->redirect("/super-eight-festivals/countries/" . urlencode($country->name) . "/cities/" . urlencode($city->name) . "/festivals/" . $festival->id);
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

        $catalog = new SuperEightFestivalsFestivalFilmCatalog();
        $catalog->festival_id = $festival->id;
        $form = $this->_getForm($catalog);
        $this->view->form = $form;
        $this->view->catalog = $catalog;
        $this->_processForm($catalog, $form, 'add');
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

        $filmCatalogID = $request->getParam('filmCatalogID');
        $film_catalog = get_film_catalog_by_id($filmCatalogID);
        $this->view->film_catalog = $film_catalog;

        $form = $this->_getForm($film_catalog);
        $this->view->form = $form;
        $this->_processForm($film_catalog, $form, 'edit');
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
                'required' => $film_catalog->file_name == "" || !file_exists($film_catalog->get_path()),
            )
        );

        $form->addElementToEditGroup(
            'text', 'file_url_web',
            array(
                'id' => 'file_url_web',
                'label' => 'URL',
                'description' => "The URL (link) to the record",
                'value' => $film_catalog->file_url_web,
                'required' => false,
            )
        );

//        $form->addElementToEditGroup(
//            'textarea', 'embed',
//            array(
//                'id' => 'embed',
//                'label' => 'Embed Code',
//                'description' => "The catalog's embed code",
//                'value' => $film_catalog->embed,
//                'required' => false,
//            )
//        );

        return $form;
    }

    private function _processForm(SuperEightFestivalsFestivalFilmCatalog $film_catalog, Zend_Form $form, $action)
    {
        $this->view->film_catalog = $film_catalog;

        if ($this->getRequest()->isPost()) {
            try {
                if (!$form->isValid($_POST)) {
                    $this->_helper->flashMessenger('There was an error on the form. Please try again.', 'error');
                    return;
                }

                try {
                    if ($action == 'delete') {
                        $film_catalog->delete();
                        $this->_helper->flashMessenger("The film catalog for " . $film_catalog->get_city()->name . " has been deleted.", 'success');
                    } else if ($action == 'add') {
                        $film_catalog->setPostData($_POST);
                        if ($film_catalog->save()) {
                            $this->_helper->flashMessenger("The film catalog for " . $film_catalog->get_city()->name . " has been added.", 'success');

                            // do file upload
                            $this->upload_file($film_catalog);
                        }
                    } else if ($action == 'edit') {
                        // get the original so that we can use old information which doesn't persist well (e.g. files)
                        $originalRecord = get_film_catalog_by_id($film_catalog->id);
                        // set the data of the record according to what was submitted in the form
                        $film_catalog->setPostData($_POST);
                        // if there is no pending upload, use the old files
                        if (!has_temporary_file('file')) {
                            $film_catalog->file_name = $originalRecord->file_name;
                            $film_catalog->thumbnail_file_name = $originalRecord->thumbnail_file_name;
                        }
                        if ($film_catalog->save()) {
                            // display result dialog
                            $this->_helper->flashMessenger("The film catalog for " . $film_catalog->get_city()->name . " has been edited.", 'success');

                            // only change files if there is a file waiting
                            if (has_temporary_file('file')) {
                                // delete old files
                                $originalRecord->delete_files();
                                // do file upload
                                $this->upload_file($film_catalog);
                            }
                        }
                    }

                    // bring us back to the city page
                    $this->redirect("/super-eight-festivals/countries/" . urlencode($film_catalog->get_country()->name) . "/cities/" . urlencode($film_catalog->get_city()->name) . "/festivals/" . $film_catalog->festival_id);
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

    private function upload_file(SuperEightFestivalsFestivalFilmCatalog $film_catalog)
    {
        list($original_name, $temporary_name, $extension) = get_temporary_file("file");
        $newFileName = uniqid($film_catalog->get_internal_prefix() . "_") . "." . $extension;
        move_to_dir($temporary_name, $newFileName, $film_catalog->get_festival()->get_film_catalogs_dir());
        $film_catalog->file_name = $newFileName;
        $film_catalog->save();
    }

}
