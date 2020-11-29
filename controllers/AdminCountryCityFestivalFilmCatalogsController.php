<?php

class SuperEightFestivals_AdminCountryCityFestivalFilmCatalogsController extends Omeka_Controller_AbstractActionController
{
    public function indexAction()
    {
        $request = $this->getRequest();

        $this->view->country = $country = get_request_param_country($request);
        $this->view->city = $city = get_request_param_city($request);
        $this->view->festival = $festival = get_request_param_by_id($request, SuperEightFestivalsFestival::class, "festivalID");

        $this->redirect("/super-eight-festivals/countries/" . urlencode($country->get_location()->name) . "/cities/" . urlencode($city->get_location()->name) . "/festivals/" . $festival->id);
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

        $file = $film_catalog->get_file();

        $form->addElementToEditGroup(
            'select', 'contributor_id',
            array(
                'id' => 'contributor_id',
                'label' => 'Contributor',
                'description' => "The person who contributed the item",
                'multiOptions' => get_parent_contributor_options(),
                'value' => $file ? $file->contributor_id : null,
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'text', 'title',
            array(
                'id' => 'title',
                'label' => 'Title',
                'description' => "The federation bylaw's title",
                'value' => $file ? $file->title : "",
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'text', 'description',
            array(
                'id' => 'description',
                'label' => 'Description',
                'description' => "The federation bylaw's description",
                'value' => $file ? $file->description : "",
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'file', 'file',
            array(
                'id' => 'file',
                'label' => 'File',
                'description' => "The record image file",
                'required' => $film_catalog == null || $film_catalog->get_file() == null || !file_exists($film_catalog->get_file()->file_name),
                'accept' => get_form_accept_string(get_image_types()),
            )
        );

        return $form;
    }

    private function _processForm(SuperEightFestivalsFestivalFilmCatalog $film_catalog, Zend_Form $form, $action)
    {
        $this->view->film_catalog = $film_catalog;

        // form can only be processed by POST request
        if (!$this->getRequest()->isPost()) {
            return;
        }

        // Validate form
        try {
            if (!$form->isValid($_POST)) {
                $this->_helper->flashMessenger('Invalid form data', 'error');
                return;
            }
        } catch (Zend_Form_Exception $e) {
            $this->_helper->flashMessenger("An error occurred while submitting the form: {$e->getMessage()}", 'error');
        }

        $fileInputName = "file";
        try {
            switch ($action) {
                case "add":
                    $film_catalog->setPostData($_POST);
                    $film_catalog->save(true);

                    $file = $film_catalog->upload_file($fileInputName);
                    $file->contributor_id = $this->getParam("contributor", 0);
                    $file->save();

                    $this->_helper->flashMessenger("Film Catalog successfully added.", 'success');
                    break;
                case "edit":
                    $film_catalog->setPostData($_POST);
                    $film_catalog->save(true);

                    // get the original record so that we can use old information which doesn't persist (e.g. files)
                    $originalRecord = SuperEightFestivalsFestivalFilmCatalog::get_by_id($film_catalog->id);
                    $film_catalog->file_id = $originalRecord->file_id;

                    // only change files if there is a file waiting
                    if (has_temporary_file($fileInputName)) {
                        // delete old files
                        $originalFile = $originalRecord->get_file();
                        $originalFile->delete_files();

                        // upload new file
                        $file = $film_catalog->upload_file($fileInputName);
                        $file->contributor_id = $this->getParam("contributor", 0);
                        $file->title = $this->getParam("title", "");
                        $file->description = $this->getParam("description", "");
                        $file->save();
                    } else {
                        $file = $originalRecord->get_file();
                        $file->contributor_id = $this->getParam("contributor", 0);
                        $file->title = $this->getParam("title", "");
                        $file->description = $this->getParam("description", "");
                        $file->save();
                    }

                    // display result dialog
                    $this->_helper->flashMessenger("Film Catalog successfully updated.", 'success');
                    break;
                case "delete":
                    $film_catalog->delete();
                    $this->_helper->flashMessenger("Film Catalog successfully deleted.", 'success');
                    break;
            }

            $festival = $film_catalog->get_festival();
            $country = $festival->get_country();
            $city = $festival->get_city();
            $this->redirect(
                "/super-eight-festivals/countries/"
                . urlencode($country->get_location()->name)
                . "/cities/"
                . urlencode($city->get_location()->name)
                . "/festivals/"
                . $festival->id
            );
        } catch (Omeka_Record_Exception $e) {
            $this->_helper->flashMessenger($e->getMessage(), 'error');
        } catch (Omeka_Validate_Exception $e) {
            $this->_helper->flashMessenger($e->getMessage(), 'error');
        }
    }

}
