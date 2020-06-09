<?php

class SuperEightFestivals_FilmmakerPhotosController extends Omeka_Controller_AbstractActionController
{
    public function init()
    {
        // Set the model class so this controller can perform some functions,
        // such as $this->findById()
        $this->_helper->db->setDefaultModelName('SuperEightFestivalsFilmmakerPhoto');
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

        $filmmakerID = $request->getParam('filmmakerID');
        $filmmaker = get_filmmaker_by_id($filmmakerID);
        $this->view->filmmaker = $filmmaker;

        $this->redirect("/super-eight-festivals/countries/" . urlencode($country->name) . "/cities/" . urlencode($city->name) . "/filmmakers/" . $filmmaker->id);
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

        $filmmakerID = $request->getParam('filmmakerID');
        $filmmaker = get_filmmaker_by_id($filmmakerID);
        $this->view->filmmaker = $filmmaker;

        $photo = new SuperEightFestivalsFilmmakerPhoto();
        $photo->city_id = $city->id;
        $photo->filmmaker_id = $filmmaker->id;
        $form = $this->_getForm($photo);
        $this->view->form = $form;
        $this->view->photo = $photo;
        $this->_processForm($photo, $form, 'add');
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

        $filmmakerID = $request->getParam('filmmakerID');
        $filmmaker = get_filmmaker_by_id($filmmakerID);
        $this->view->filmmaker = $filmmaker;

        $photo_id = $request->getParam('filmmakerPhotoID');
        $photo = get_filmmaker_photo_by_id($photo_id);
        $this->view->photo = $photo;

        $form = $this->_getForm($photo);
        $this->view->form = $form;
        $this->_processForm($photo, $form, 'edit');
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

        $filmmakerID = $request->getParam('filmmakerID');
        $filmmaker = get_filmmaker_by_id($filmmakerID);
        $this->view->filmmaker = $filmmaker;

        $photo_id = $request->getParam('filmmakerPhotoID');
        $photo = get_filmmaker_photo_by_id($photo_id);
        $this->view->filmmaker = $filmmaker;

        $form = $this->_getDeleteForm();
        $this->view->form = $form;
        $this->_processForm($photo, $form, 'delete');
    }

    protected function _getForm(SuperEightFestivalsFilmmakerPhoto $photo = null): Omeka_Form_Admin
    {
        $formOptions = array(
            'type' => 'super_eight_festivals_filmmaker'
        );

        $form = new Omeka_Form_Admin($formOptions);

        $form->addElementToEditGroup(
            'select', 'contributor_id',
            array(
                'id' => 'contributor_id',
                'label' => 'Contributor',
                'description' => "The person who contributed the item",
                'multiOptions' => get_parent_contributor_options(),
                'value' => $photo->contributor_id,
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'text', 'title',
            array(
                'id' => 'title',
                'label' => 'Title',
                'description' => "The catalog's title",
                'value' => $photo->title,
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'text', 'description',
            array(
                'id' => 'description',
                'label' => 'Description',
                'description' => "The catalog's description",
                'value' => $photo->description,
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'file', 'file',
            array(
                'id' => 'file',
                'label' => 'File',
                'description' => "The photo file",
                'required' => $photo->file_name == "" || !file_exists($photo->get_path()),
            )
        );

        return $form;
    }

    private function _processForm(SuperEightFestivalsFilmmakerPhoto $photo, Zend_Form $form, $action)
    {
        $this->view->photo = $photo;

        if ($this->getRequest()->isPost()) {
            try {
                if (!$form->isValid($_POST)) {
                    $this->_helper->flashMessenger('There was an error on the form. Please try again.', 'error');
                    return;
                }

                try {
                    // delete
                    if ($action == 'delete') {
                        $photo->delete();
                        $this->_helper->flashMessenger("The photo has been deleted.", 'success');
                    } // add
                    else if ($action == 'add') {
                        $photo->setPostData($_POST);
                        if ($photo->save()) {
                            // do file upload
                            $this->upload_file($photo);
                            $this->_helper->flashMessenger("The photo has been added.", 'success');
                        }
                    } // edit
                    else if ($action == 'edit') {
                        // get the original so that we can use old information which doesn't persist well (e.g. files)
                        $originalRecord = get_filmmaker_photo_by_id($photo->id);
                        // set the data of the record according to what was submitted in the form
                        $photo->setPostData($_POST);
                        // temporarily set file name to uploaded file name
                        $photo->file_name = get_temporary_file("file")[0];
                        // if there is no pending upload, use the old files
                        if (!has_temporary_file('file')) {
                            $photo->file_name = $originalRecord->file_name;
                            $photo->thumbnail_file_name = $originalRecord->thumbnail_file_name;
                        } else {
                            // temporarily set file name to uploaded file name
                            $photo->file_name = get_temporary_file("file")[0];
                        }
                        if ($photo->save()) {
                            // only change files if there is a file waiting
                            if (has_temporary_file('file')) {
                                // delete old files
                                $originalRecord->delete_files();
                                // do file upload
                                $this->upload_file($photo);
                            }
                            // display result dialog
                            $this->_helper->flashMessenger("The photo has been edited.", 'success');
                        }
                    }

                    $this->redirect("/super-eight-festivals/countries/" . urlencode($photo->get_country()->name) . "/cities/" . urlencode($photo->get_city()->name) . "/filmmakers/" . $photo->filmmaker_id);
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

    private function upload_file(SuperEightFestivalsFilmmakerPhoto $photo)
    {
        list($original_name, $temporary_name, $extension) = get_temporary_file("file");
        $newFileName = uniqid($photo->get_internal_prefix() . "_") . "." . $extension;
        move_to_dir($temporary_name, $newFileName, $photo->get_dir());
        $photo->file_name = $newFileName;
        $photo->create_thumbnail();
        $photo->save();
    }
}
