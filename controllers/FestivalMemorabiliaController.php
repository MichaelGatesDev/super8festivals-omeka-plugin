<?php

class SuperEightFestivals_FestivalMemorabiliaController extends Omeka_Controller_AbstractActionController
{
    public function init()
    {
        // Set the model class so this controller can perform some functions,
        // such as $this->findById()
        $this->_helper->db->setDefaultModelName('SuperEightFestivalsFestivalMemorabilia');
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

        $festivalID = $request->getParam('festivalID');
        $festival = get_festival_by_id($festivalID);
        $this->view->festival = $festival;

        $memorabiliaID = $request->getParam('memorabiliaID');
        $memorabilia = get_memorabilia_by_id($memorabiliaID);
        $this->view->memorabilia = $memorabilia;

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

        $memorabilia = new SuperEightFestivalsFestivalMemorabilia();
        $memorabilia->festival_id = $festival->id;
        $form = $this->_getForm($memorabilia);
        $this->view->form = $form;
        $this->view->memorabilia = $memorabilia;
        $this->_processForm($memorabilia, $form, 'add');
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

        $memorabiliaID = $request->getParam('memorabiliaID');
        $memorabilia = get_memorabilia_by_id($memorabiliaID);
        $this->view->memorabilia = $memorabilia;

        $form = $this->_getForm($memorabilia);
        $this->view->form = $form;
        $this->_processForm($memorabilia, $form, 'edit');
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

        $festivalID = $request->getParam('festivalID');
        $festival = get_festival_by_id($festivalID);
        $this->view->festival = $festival;

        $memorabiliaID = $request->getParam('memorabiliaID');
        $memorabilia = get_memorabilia_by_id($memorabiliaID);
        $this->view->memorabilia = $memorabilia;

        $form = $this->_getDeleteForm();
        $this->view->form = $form;
        $this->_processForm($memorabilia, $form, 'delete');
    }

    protected function _getForm(SuperEightFestivalsFestivalMemorabilia $memorabilia = null): Omeka_Form_Admin
    {
        $formOptions = array(
            'type' => 'super_eight_festivals_festival_memorabilia'
        );

        $form = new Omeka_Form_Admin($formOptions);

        $form->addElementToEditGroup(
            'select', 'contributor_id',
            array(
                'id' => 'contributor_id',
                'label' => 'Contributor',
                'description' => "The person who contributed the item",
                'multiOptions' => get_parent_contributor_options(),
                'value' => $memorabilia->contributor_id,
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'text', 'title',
            array(
                'id' => 'title',
                'label' => 'Title',
                'description' => "The memorabilia's title",
                'value' => $memorabilia->title,
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'text', 'description',
            array(
                'id' => 'description',
                'label' => 'Description',
                'description' => "The memorabilia's description",
                'value' => $memorabilia->description,
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'file', 'file',
            array(
                'id' => 'file',
                'label' => 'File',
                'description' => "The memorabilia file",
                'required' => $memorabilia->file_name == "" || !file_exists($memorabilia->get_path()),
            )
        );

        return $form;
    }

    private function _processForm(SuperEightFestivalsFestivalMemorabilia $memorabilia, Zend_Form $form, $action)
    {
        $this->view->memorabilia = $memorabilia;

        if ($this->getRequest()->isPost()) {
            try {
                if (!$form->isValid($_POST)) {
                    $this->_helper->flashMessenger('There was an error on the form. Please try again.', 'error');
                    return;
                }

                try {
                    if ($action == 'delete') {
                        $memorabilia->delete();
                        $this->_helper->flashMessenger("The memorabilia for " . $memorabilia->get_city()->name . " has been deleted.", 'success');
                    } else if ($action == 'add') {
                        $memorabilia->setPostData($_POST);
                        if ($memorabilia->save()) {
                            // do file upload
                            $this->upload_file($memorabilia);
                            $this->_helper->flashMessenger("The memorabilia for " . $memorabilia->get_city()->name . " has been added.", 'success');
                        }
                    } else if ($action == 'edit') {
                        // get the original so that we can use old information which doesn't persist well (e.g. files)
                        $originalRecord = get_memorabilia_by_id($memorabilia->id);
                        // set the data of the record according to what was submitted in the form
                        $memorabilia->setPostData($_POST);
                        // if there is no pending upload, use the old files
                        if (!has_temporary_file('file')) {
                            $memorabilia->file_name = $originalRecord->file_name;
                            $memorabilia->thumbnail_file_name = $originalRecord->thumbnail_file_name;
                        } else {
                            // temporarily set file name to uploaded file name
                            $memorabilia->file_name = get_temporary_file("file")[0];
                        }
                        if ($memorabilia->save()) {
                            // only change files if there is a file waiting
                            if (has_temporary_file('file')) {
                                // delete old files
                                $originalRecord->delete_files();
                                // do file upload
                                $this->upload_file($memorabilia);
                            }
                            // display result dialog
                            $this->_helper->flashMessenger("The memorabilia for " . $memorabilia->get_city()->name . " has been edited.", 'success');
                        }
                    }


                    $this->redirect("/super-eight-festivals/countries/" . urlencode($memorabilia->get_country()->name) . "/cities/" . urlencode($memorabilia->get_city()->name) . "/festivals/" . $memorabilia->festival_id);
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

    private function upload_file(SuperEightFestivalsFestivalMemorabilia $memorabilia)
    {
        list($original_name, $temporary_name, $extension) = get_temporary_file("file");
        $newFileName = uniqid($memorabilia->get_internal_prefix() . "_") . "." . $extension;
        move_to_dir($temporary_name, $newFileName, $memorabilia->get_festival()->get_memorabilia_dir());
        $memorabilia->file_name = $newFileName;
        $memorabilia->create_thumbnail();
        $memorabilia->save();
    }

}
