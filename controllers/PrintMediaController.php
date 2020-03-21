<?php

class SuperEightFestivals_PrintMediaController extends Omeka_Controller_AbstractActionController
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
        $country = get_country_by_name($countryName);
        $this->view->country = $country;

        $cityName = $request->getParam('cityName');
        $city = get_city_by_name($country->id, $cityName);
        $this->view->city = $city;

        $festivalID = $request->getParam('festivalID');
        $festival = get_festival_by_id($festivalID);
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
        $country = get_country_by_name($countryName);
        $this->view->country = $country;

        $cityName = $request->getParam('cityName');
        $city = get_city_by_name($country->id, $cityName);
        $this->view->city = $city;

        $festivalID = $request->getParam('festivalID');
        $festival = get_festival_by_id($festivalID);
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
            'select', 'festival_id',
            array(
                'id' => 'festival_id',
                'label' => 'Festival',
                'description' => "The festival which the media was an item of (required)",
                'multiOptions' => array_merge(array("Select..."), get_parent_festival_options()),
                'value' => $print_media->festival_id,
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
            )
        );

        $form->addElementToEditGroup(
            'textarea', 'embed',
            array(
                'id' => 'embed',
                'label' => 'Embed Code',
                'description' => "The media's embed code",
                'value' => $print_media->embed,
                'required' => false,
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
                    if ($action == 'delete') {
                        $print_media->delete();
                        $this->_helper->flashMessenger("The print media for " . $print_media->get_city()->name . " has been deleted.", 'success');
                    } else if ($action == 'add') {
                        $print_media->setPostData($_POST);
                        if ($print_media->save()) {
                            $this->_helper->flashMessenger("The print media for " . $print_media->get_city()->name . " has been added.", 'success');

                            // do file upload
                            $this->upload_file($print_media);
                        }
                    } else if ($action == 'edit') {
                        // get the original so that we can use old information which doesn't persist well (e.g. files)
                        $originalRecord = get_print_media_by_id($print_media->id);
                        // set the data of the record according to what was submitted in the form
                        $print_media->setPostData($_POST);
                        // if there is no pending upload, use the old files
                        if (!has_temporary_file('file')) {
                            $print_media->file_name = $originalRecord->file_name;
                            $print_media->thumbnail_file_name = $originalRecord->thumbnail_file_name;
                        }
                        if ($print_media->save()) {
                            // display result dialog
                            $this->_helper->flashMessenger("The print media for " . $print_media->get_city()->name . " has been edited.", 'success');

                            // only change files if there is a file waiting
                            if (has_temporary_file('file')) {
                                // delete old files
                                $originalRecord->delete_files();
                                // do file upload
                                $this->upload_file($print_media);
                            }
                        }
                    }

                    // bring us back to the city page
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
        $print_media->save();
    }

}
