<?php

class SuperEightFestivals_BannersController extends Omeka_Controller_AbstractActionController
{
    public function init()
    {
        // Set the model class so this controller can perform some functions,
        // such as $this->findById()
        $this->_helper->db->setDefaultModelName('SuperEightFestivalsCountryBanner');
    }

    public function indexAction()
    {
        $request = $this->getRequest();

        $countryName = $request->getParam('countryName');
        $country = get_country_by_name($countryName);
        $this->view->country = $country;

        $this->redirect("/super-eight-festivals/countries/" . urlencode($country->name));
        return;
    }

    public function addAction()
    {
        $request = $this->getRequest();

        $countryName = $request->getParam('countryName');
        $country = get_country_by_name($countryName);
        $this->view->country = $country;

        // Create new banner
        $banner = new SuperEightFestivalsCountryBanner();
        $banner->country_id = $country->id;
        $form = $this->_getForm($banner);
        $this->view->form = $form;
        $this->_processForm($banner, $form, 'add');
    }

    public function editAction()
    {
        $request = $this->getRequest();

        $countryName = $request->getParam('countryName');
        $country = get_country_by_name($countryName);
        $this->view->country = $country;

        $bannerID = $request->getParam('bannerID');
        $banner = get_country_banner_by_id($bannerID);
        $this->view->banner = $banner;

        $form = $this->_getForm($banner);
        $this->view->form = $form;
        $this->_processForm($banner, $form, 'edit');
    }


    public function deleteAction()
    {
        $request = $this->getRequest();

        $countryName = $request->getParam('countryName');
        $country = get_country_by_name($countryName);
        $this->view->country = $country;

        $bannerID = $request->getParam('bannerID');
        $banner = get_country_banner_by_id($bannerID);
        $this->view->banner = $banner;

        $form = $this->_getDeleteForm();
        $this->view->form = $form;
        $this->_processForm($banner, $form, 'delete');
    }

    protected function _getForm(SuperEightFestivalsCountryBanner $banner = null)
    {
        $formOptions = array(
            'type' => 'super_eight_festivals_country_banner'
        );

        $form = new Omeka_Form_Admin($formOptions);

        $form->addElementToEditGroup(
            'select', 'country_id',
            array(
                'id' => 'country_id',
                'label' => 'Country',
                'description' => "The country which the banner belongs to (required)",
                'multiOptions' => get_parent_country_options(),
                'value' => $banner->country_id,
                'required' => true
            )
        );

        $form->addElementToEditGroup(
            'file', 'file',
            array(
                'id' => 'file',
                'label' => 'File',
                'description' => "The banner image file",
                'required' => $banner->file_name == "" || !file_exists($banner->get_path()),
            )
        );

        $form->addElementToEditGroup(
            'checkbox', 'active',
            array(
                'id' => 'active',
//                    'disabled' => get_active_country_banner($banner->get_country()->id) == null,
                'label' => 'Active',
                'description' => "Make this the active banner?",
                'value' => $banner->active,
            )
        );

        return $form;
    }


    private function _processForm(SuperEightFestivalsCountryBanner $banner, Zend_Form $form, $action)
    {
        $this->view->banner = $banner;

        if ($this->getRequest()->isPost()) {
            try {
                if (!$form->isValid($_POST)) {
                    $this->_helper->flashMessenger('There was an error on the form. Please try again.', 'error');
                    return;
                }
                try {
                    // delete
                    if ($action == 'delete') {
                        $banner->delete();
                        $this->_helper->flashMessenger("The banner for " . $banner->get_country()->name . " has been deleted.", 'success');
                    } //add
                    else if ($action == 'add') {
                        $banner->setPostData($_POST);
                        if ($banner->save()) {
                            $this->_helper->flashMessenger("The banner for " . $banner->get_country()->name . " has been added.", 'success');

                            // do file upload
                            $this->upload_file($banner);
                        }
                    } //edit
                    else if ($action == 'edit') {
                        // get the original so that we can use old information which doesn't persist well (e.g. files)
                        $originalRecord = get_country_banner_by_id($banner->id);
                        // set the data of the record according to what was submitted in the form
                        $banner->setPostData($_POST);
                        // if there is no pending upload, use the old files
                        if (!has_temporary_file('file')) {
                            $banner->file_name = $originalRecord->file_name;
                            $banner->thumbnail_file_name = $originalRecord->thumbnail_file_name;
                        }
                        if ($banner->save()) {
                            // display result dialog
                            $this->_helper->flashMessenger("The banner for " . $banner->get_country()->name . " has been edited.", 'success');

                            // only change files if there is a file waiting
                            if (has_temporary_file('file')) {
                                // delete old files
                                $originalRecord->delete_files();
                                // do file upload
                                $this->upload_file($banner);
                            }
                        }
                    }

                    // bring us back to the country page
                    $this->redirect("/super-eight-festivals/countries/" . urlencode($banner->get_country()->name));
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

    private function upload_file(SuperEightFestivalsCountryBanner $country_banner)
    {
        list($original_name, $temporary_name, $extension) = get_temporary_file("file");
        $newFileName = uniqid($country_banner->get_internal_prefix() . "_") . "." . $extension;
        move_to_dir($temporary_name, $newFileName, get_country_dir($country_banner->get_country()->name));
        $country_banner->file_name = $newFileName;
        $country_banner->save();
    }

}
