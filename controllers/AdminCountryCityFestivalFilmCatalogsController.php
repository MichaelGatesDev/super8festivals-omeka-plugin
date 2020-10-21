<?php

class SuperEightFestivals_AdminCountryCityFestivalFilmCatalogsController extends Omeka_Controller_AbstractActionController
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

        $this->view->country = $country = get_request_param_country($request);
        $this->view->city = $city = get_request_param_city($request);
        $this->view->festival = $festival = get_request_param_by_id($request, SuperEightFestivalsFestival::class, "festivalID");

        $this->redirect("/super-eight-festivals/countries/" . urlencode($country->name) . "/cities/" . urlencode($city->name) . "/festivals/" . $festival->id);
    }

    public function addAction()
    {
        $request = $this->getRequest();

        $this->view->country = $country = get_request_param_country($request);
        $this->view->city = $city = get_request_param_city($request);
        $this->view->festival = $festival = get_request_param_by_id($request, SuperEightFestivalsFestival::class, "festivalID");

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

        $this->view->country = $country = get_request_param_country($request);
        $this->view->city = $city = get_request_param_city($request);
        $this->view->festival = $festival = get_request_param_by_id($request, SuperEightFestivalsFestival::class, "festivalID");
        $this->view->film_catalog = $film_catalog = get_request_param_by_id($request, SuperEightFestivalsFestivalFilmCatalog::class, "filmCatalogID");

        $form = $this->_getForm($film_catalog);
        $this->view->form = $form;
        $this->_processForm($film_catalog, $form, 'edit');
    }

    public function deleteAction()
    {
        $request = $this->getRequest();

        $this->view->country = $country = get_request_param_country($request);
        $this->view->city = $city = get_request_param_city($request);
        $this->view->festival = $festival = get_request_param_by_id($request, SuperEightFestivalsFestival::class, "festivalID");
        $this->view->film_catalog = $film_catalog = get_request_param_by_id($request, SuperEightFestivalsFestivalFilmCatalog::class, "filmCatalogID");

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
            'select', 'contributor_id',
            array(
                'id' => 'contributor_id',
                'label' => 'Contributor',
                'description' => "The person who contributed the item",
                'multiOptions' => get_parent_contributor_options(),
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
                'accept' => get_form_accept_string(array_merge(get_image_types(), get_document_types())),
            )
        );

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
                    // delete
                    if ($action == 'delete') {
                        $film_catalog->delete();
                        $this->_helper->flashMessenger("The film catalog for " . $film_catalog->get_city()->name . " has been deleted.", 'success');
                    } else if ($action == 'add') {
                        $film_catalog->setPostData($_POST);
                        if ($film_catalog->save()) {
                            // do file upload
                            $this->upload_file($film_catalog);
                            $this->_helper->flashMessenger("The film catalog for " . $film_catalog->get_city()->name . " has been added.", 'success');
                        }
                    } else if ($action == 'edit') {
                        // get the original so that we can use old information which doesn't persist well (e.g. files)
                        $originalRecord = SuperEightFestivalsFestivalFilmCatalog::get_by_id($film_catalog->id);
                        // set the data of the record according to what was submitted in the form
                        $film_catalog->setPostData($_POST);
                        // if there is no pending upload, use the old files
                        if (!has_temporary_file('file')) {
                            $film_catalog->file_name = $originalRecord->file_name;
                            $film_catalog->thumbnail_file_name = $originalRecord->thumbnail_file_name;
                        } else {
                            // temporarily set file name to uploaded file name
                            $film_catalog->file_name = get_temporary_file("file")[0];
                        }
                        if ($film_catalog->save()) {
                            // only change files if there is a file waiting
                            if (has_temporary_file('file')) {
                                // delete old files
                                $originalRecord->delete_files();
                                // do file upload
                                $this->upload_file($film_catalog);
                            }
                            // display result dialog
                            $this->_helper->flashMessenger("The film catalog for " . $film_catalog->get_city()->name . " has been edited.", 'success');
                        }
                    }


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
        move_tempfile_to_dir($temporary_name, $newFileName, get_uploads_dir());
        $film_catalog->file_name = $newFileName;
        $film_catalog->create_thumbnail();
        $film_catalog->save();
    }

}
