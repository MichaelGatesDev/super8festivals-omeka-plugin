<?php

class SuperEightFestivals_AdminCountryCityFestivalPrintMediaController extends Omeka_Controller_AbstractActionController
{
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

        $media = new SuperEightFestivalsFestivalPrintMedia();
        $media->festival_id = $festival->id;
        $form = $this->_getForm($media);
        $this->view->form = $form;
        $this->view->media = $media;
        $this->_processForm($media, $form, 'add');
    }

    public function editAction()
    {
        $request = $this->getRequest();

        $this->view->country = $country = get_request_param_country($request);
        $this->view->city = $city = get_request_param_city($request);
        $this->view->festival = $festival = get_request_param_by_id($request, SuperEightFestivalsFestival::class, "festivalID");
        $this->view->print_media = $print_media = get_request_param_by_id($request, SuperEightFestivalsFestivalPrintMedia::class, "printMediaID");

        $form = $this->_getForm($print_media);
        $this->view->form = $form;
        $this->_processForm($print_media, $form, 'edit');
    }

    public function deleteAction()
    {
        $request = $this->getRequest();

        $this->view->country = $country = get_request_param_country($request);
        $this->view->city = $city = get_request_param_city($request);
        $this->view->festival = $festival = get_request_param_by_id($request, SuperEightFestivalsFestival::class, "festivalID");
        $this->view->print_media = $print_media = get_request_param_by_id($request, SuperEightFestivalsFestivalPrintMedia::class, "printMediaID");

        $form = $this->_getDeleteForm();
        $this->view->form = $form;
        $this->_processForm($print_media, $form, 'delete');
    }

    protected function _getForm(SuperEightFestivalsFestivalPrintMedia $print_media = null): Omeka_Form_Admin
    {
        $formOptions = array(
            'type' => 'super_eight_festivals_festival_print_media'
        );

        $form = new Omeka_Form_Admin($formOptions);

        $file = $print_media->get_file();

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
                'description' => "The print media file",
                'required' => $file->file_name == "" || !file_exists($file->get_path()),
                'accept' => get_form_accept_string(get_image_types()),
            )
        );

        return $form;
    }

    private function _processForm(SuperEightFestivalsFestivalPrintMedia $print_media, Zend_Form $form, $action)
    {
        $this->view->print_media = $print_media;

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
                    $print_media->setPostData($_POST);
                    $print_media->save(true);

                    $file = $print_media->upload_file($fileInputName);
                    $file->contributor_id = $this->getParam("contributor", 0);
                    $file->save();

                    $this->_helper->flashMessenger("Print Media successfully added.", 'success');
                    break;
                case "edit":
                    $print_media->setPostData($_POST);
                    $print_media->save(true);

                    // get the original record so that we can use old information which doesn't persist (e.g. files)
                    $originalRecord = SuperEightFestivalsFestivalPrintMedia::get_by_id($print_media->id);
                    $print_media->file_id = $originalRecord->file_id;

                    // only change files if there is a file waiting
                    if (has_temporary_file($fileInputName)) {
                        // delete old files
                        $originalFile = $originalRecord->get_file();
                        $originalFile->delete_files();

                        // upload new file
                        $file = $print_media->upload_file($fileInputName);
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
                    $this->_helper->flashMessenger("Print Media successfully updated.", 'success');
                    break;
                case "delete":
                    $print_media->delete();
                    $this->_helper->flashMessenger("Print Media successfully deleted.", 'success');
                    break;
            }

            $festival = $print_media->get_festival();
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
