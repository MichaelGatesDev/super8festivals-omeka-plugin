<?php

class SuperEightFestivals_FestivalPrintMediaController extends Omeka_Controller_AbstractActionController
{
    public function init()
    {
        // Set the model class so this controller can perform some functions,
        // such as $this->findById()
        $this->_helper->db->setDefaultModelName('SuperEightFestivalsFestivalPrintMedia');
    }

    public function indexAction()
    {
        $request = $this->getRequest();

        $countryName = $request->getParam('countryName');
        $country = SuperEightFestivalsCountry::get_by_param('name', $countryName, 1)[0];
        $this->view->country = $country;

        $cityName = $request->getParam('cityName');
        $city = SuperEightFestivalsCity::get_by_params(array('country_id' => $country->id, 'name', $cityName, 1))[0];;
        $this->view->city = $city;

        $festivalID = $request->getParam('festivalID');
        $festival = SuperEightFestivalsFestival::get_by_id($festivalID);
        $this->view->festival = $festival;

        $this->redirect("/super-eight-festivals/countries/" . urlencode($country->name) . "/cities/" . urlencode($city->name) . "/festivals/" . $festival->id);
        return;
    }

    public function addAction()
    {
        $request = $this->getRequest();

        $countryName = $request->getParam('countryName');
        $country = SuperEightFestivalsCountry::get_by_param('name', $countryName, 1)[0];
        $this->view->country = $country;

        $cityName = $request->getParam('cityName');
        $city = SuperEightFestivalsCity::get_by_params(array('country_id' => $country->id, 'name', $cityName, 1))[0];;
        $this->view->city = $city;

        $festivalID = $request->getParam('festivalID');
        $festival = SuperEightFestivalsFestival::get_by_id($festivalID);
        $this->view->festival = $festival;

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

        $countryName = $request->getParam('countryName');
        $country = SuperEightFestivalsCountry::get_by_param('name', $countryName, 1)[0];
        $this->view->country = $country;

        $cityName = $request->getParam('cityName');
        $city = SuperEightFestivalsCity::get_by_params(array('country_id' => $country->id, 'name', $cityName, 1))[0];;
        $this->view->city = $city;

        $festivalID = $request->getParam('festivalID');
        $festival = SuperEightFestivalsFestival::get_by_id($festivalID);
        $this->view->festival = $festival;

        $pritnMediaID = $request->getParam('printMediaID');
        $print_media = get_print_media_by_id($pritnMediaID);
        $this->view->print_media = $print_media;

        $form = $this->_getForm($print_media);
        $this->view->form = $form;
        $this->_processForm($print_media, $form, 'edit');
    }

    public function deleteAction()
    {
        $request = $this->getRequest();

        $countryName = $request->getParam('countryName');
        $country = SuperEightFestivalsCountry::get_by_param('name', $countryName, 1)[0];
        $this->view->country = $country;

        $cityName = $request->getParam('cityName');
        $city = SuperEightFestivalsCity::get_by_params(array('country_id' => $country->id, 'name', $cityName, 1))[0];;
        $this->view->city = $city;

        $festivalID = $request->getParam('festivalID');
        $festival = SuperEightFestivalsFestival::get_by_id($festivalID);
        $this->view->festival = $festival;

        $pritnMediaID = $request->getParam('printMediaID');
        $print_media = get_print_media_by_id($pritnMediaID);
        $this->view->print_media = $print_media;

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

        $form->addElementToEditGroup(
            'select', 'contributor_id',
            array(
                'id' => 'contributor_id',
                'label' => 'Contributor',
                'description' => "The person who contributed the item",
                'multiOptions' => get_parent_contributor_options(),
                'value' => $print_media->contributor_id,
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'text', 'title',
            array(
                'id' => 'title',
                'label' => 'Title',
                'description' => "The media's title",
                'value' => $print_media->title,
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'text', 'description',
            array(
                'id' => 'description',
                'label' => 'Description',
                'description' => "The media's description",
                'value' => $print_media->description,
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'file', 'file',
            array(
                'id' => 'file',
                'label' => 'File',
                'description' => "The print media file",
                'required' => $print_media->file_name == "" || !file_exists($print_media->get_path()),
                'accept' => get_form_accept_string(array_merge(get_image_types(), get_document_types())),
            )
        );

        return $form;
    }

    private function _processForm(SuperEightFestivalsFestivalPrintMedia $print_media, Zend_Form $form, $action)
    {
        $this->view->print_media = $print_media;

        if ($this->getRequest()->isPost()) {
            try {
                if (!$form->isValid($_POST)) {
                    $this->_helper->flashMessenger('There was an error on the form. Please try again.', 'error');
                    return;
                }
                try {
                    // delete
                    if ($action == 'delete') {
                        $print_media->delete();
                        $this->_helper->flashMessenger("The print media for " . $print_media->get_city()->name . " has been deleted.", 'success');
                    } // add
                    else if ($action == 'add') {
                        $print_media->setPostData($_POST);
                        if ($print_media->save()) {
                            // do file upload
                            $this->upload_file($print_media);
                            $this->_helper->flashMessenger("The print media for " . $print_media->get_city()->name . " has been added.", 'success');
                        }
                    } // edit
                    else if ($action == 'edit') {
                        // get the original so that we can use old information which doesn't persist well (e.g. files)
                        $originalRecord = get_print_media_by_id($print_media->id);
                        // set the data of the record according to what was submitted in the form
                        $print_media->setPostData($_POST);
                        // if there is no pending upload, use the old files
                        if (!has_temporary_file('file')) {
                            $print_media->file_name = $originalRecord->file_name;
                            $print_media->thumbnail_file_name = $originalRecord->thumbnail_file_name;
                        } else {
                            // temporarily set file name to uploaded file name
                            $print_media->file_name = get_temporary_file("file")[0];
                        }
                        if ($print_media->save()) {
                            // only change files if there is a file waiting
                            if (has_temporary_file('file')) {
                                // delete old files
                                $originalRecord->delete_files();
                                // do file upload
                                $this->upload_file($print_media);
                            }
                            // display result dialog
                            $this->_helper->flashMessenger("The print media for " . $print_media->get_city()->name . " has been edited.", 'success');
                        }
                    }


                    $this->redirect("/super-eight-festivals/countries/" . urlencode($print_media->get_country()->name) . "/cities/" . urlencode($print_media->get_city()->name) . "/festivals/" . $print_media->festival_id);
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

    private function upload_file(SuperEightFestivalsFestivalPrintMedia $print_media)
    {
        list($original_name, $temporary_name, $extension) = get_temporary_file("file");
        $newFileName = uniqid($print_media->get_internal_prefix() . "_") . "." . $extension;
        move_to_dir($temporary_name, $newFileName, $print_media->get_dir());
        $print_media->file_name = $newFileName;
        $print_media->create_thumbnail();
        $print_media->save();
    }

}
