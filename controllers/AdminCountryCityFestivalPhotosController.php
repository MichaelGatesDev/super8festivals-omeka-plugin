<?php

class SuperEightFestivals_AdminCountryCityFestivalPhotosController extends Omeka_Controller_AbstractActionController
{
    public function indexAction()
    {
        $request = $this->getRequest();

        $this->view->country = $country = get_request_param_country($request);
        $this->view->city = $city = get_request_param_city($request);
        $this->view->festival = $festival = get_request_param_by_id($request, SuperEightFestivalsFestival::class, "festivalID");

        $this->redirect("/super-eight-festivals/countries/" . urlencode($country->name) . "/cities/" . urlencode($city->name) . "/festivals/" . $festival->id);
        return;
    }

    public function addAction()
    {
        $request = $this->getRequest();

        $this->view->country = $country = get_request_param_country($request);
        $this->view->city = $city = get_request_param_city($request);
        $this->view->festival = $festival = get_request_param_by_id($request, SuperEightFestivalsFestival::class, "festivalID");

        $photo = new SuperEightFestivalsFestivalPhoto();
        $photo->festival_id = $festival->id;
        $form = $this->_getForm($photo);
        $this->view->form = $form;
        $this->view->photo = $photo;
        $this->_processForm($photo, $form, 'add');
    }

    public function editAction()
    {
        $request = $this->getRequest();

        $this->view->country = $country = get_request_param_country($request);
        $this->view->city = $city = get_request_param_city($request);
        $this->view->festival = $festival = get_request_param_by_id($request, SuperEightFestivalsFestival::class, "festivalID");
        $this->view->photo = $photo = get_request_param_by_id($request, SuperEightFestivalsFestivalPhoto::class, "photoID");

        $form = $this->_getForm($photo);
        $this->view->form = $form;
        $this->_processForm($photo, $form, 'edit');
    }

    public function deleteAction()
    {
        $request = $this->getRequest();

        $this->view->country = $country = get_request_param_country($request);
        $this->view->city = $city = get_request_param_city($request);
        $this->view->festival = $festival = get_request_param_by_id($request, SuperEightFestivalsFestival::class, "festivalID");
        $this->view->photo = $photo = get_request_param_by_id($request, SuperEightFestivalsFestivalPhoto::class, "photoID");

        $form = $this->_getDeleteForm();
        $this->view->form = $form;
        $this->_processForm($photo, $form, 'delete');
    }

    protected function _getForm(SuperEightFestivalsFestivalPhoto $photo = null): Omeka_Form_Admin
    {
        $formOptions = array(
            'type' => 'super_eight_festivals_festival_photo'
        );

        $form = new Omeka_Form_Admin($formOptions);

        $file = $photo->get_file();

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
                'description' => "The photo file",
                'required' => $file->file_name == "" || !file_exists($file->get_path()),
                'accept' => get_form_accept_string(get_image_types()),
            )
        );

        return $form;
    }

    private function _processForm(SuperEightFestivalsFestivalPhoto $photo, Zend_Form $form, $action)
    {
        $this->view->photo = $photo;

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
                    $photo->setPostData($_POST);
                    $photo->save(true);

                    $file = $photo->upload_file($fileInputName);
                    $file->contributor_id = $this->getParam("contributor", 0);
                    $file->save();

                    $this->_helper->flashMessenger("Photo successfully added.", 'success');
                    break;
                case "edit":
                    $photo->setPostData($_POST);
                    $photo->save(true);

                    // get the original record so that we can use old information which doesn't persist (e.g. files)
                    $originalRecord = SuperEightFestivalsFestivalPhoto::get_by_id($photo->id);
                    $photo->file_id = $originalRecord->file_id;

                    // only change files if there is a file waiting
                    if (has_temporary_file($fileInputName)) {
                        // delete old files
                        $originalFile = $originalRecord->get_file();
                        $originalFile->delete_files();

                        // upload new file
                        $file = $photo->upload_file($fileInputName);
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
                    $this->_helper->flashMessenger("Photo successfully updated.", 'success');
                    break;
                case "delete":
                    $photo->delete();
                    $this->_helper->flashMessenger("Photo successfully deleted.", 'success');
                    break;
            }

            $festival = $photo->get_festival();
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
