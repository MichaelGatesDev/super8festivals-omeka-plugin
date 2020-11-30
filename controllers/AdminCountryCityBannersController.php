<?php

class SuperEightFestivals_AdminCountryCityBannersController extends Omeka_Controller_AbstractActionController
{
    public function indexAction()
    {
        $request = $this->getRequest();

        $country = get_request_param_country($request);
        $city = get_request_param_city($request);

        $this->redirect("/super-eight-festivals/countries/" . urlencode($banner->get_country()->get_location()->name) . "/cities/" . urlencode($banner->get_city()->get_location()->name));
    }

    public function addAction()
    {
        $request = $this->getRequest();

        $this->view->country = $country = get_request_param_country($request);
        $this->view->city = $city = get_request_param_city($request);

        $banner = new SuperEightFestivalsCityBanner();
        $banner->city_id = $city->id;
        $form = $this->_getForm($banner);
        $this->view->form = $form;
        $this->_processForm($banner, $form, 'add');
    }

    public function editAction()
    {
        $request = $this->getRequest();

        $this->view->country = $country = get_request_param_country($request);
        $this->view->city = $city = get_request_param_city($request);

        $banner = $city->get_banner();
        $this->view->city_banner = $banner;

        $form = $this->_getForm($banner);
        $this->view->form = $form;
        $this->_processForm($banner, $form, 'edit');
    }


    public function deleteAction()
    {
        $request = $this->getRequest();

        $this->view->country = $country = get_request_param_country($request);
        $this->view->city = $city = get_request_param_city($request);

        $banner = $city->get_banner();
        $this->view->city_banner = $banner;

        $form = $this->_getDeleteForm();
        $this->view->form = $form;
        $this->_processForm($banner, $form, 'delete');
    }

    protected function _getForm(SuperEightFestivalsCityBanner $banner = null)
    {
        $formOptions = array(
            'type' => 'super_eight_festivals_city_banner'
        );

        $form = new Omeka_Form_Admin($formOptions);

        $file = $banner->get_file();

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
            'file', 'file',
            array(
                'id' => 'file',
                'label' => 'File',
                'description' => "The record image file",
                'required' => $banner == null || $banner->get_file() == null || !file_exists(get_uploads_dir() . "/" . $banner->get_file()->file_name),
                'accept' => get_form_accept_string(get_image_types()),
            )
        );

        return $form;
    }


    private function _processForm(SuperEightFestivalsCityBanner $banner, Zend_Form $form, $action)
    {
        $this->view->city_banner = $banner;

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
                    $banner->setPostData($_POST);
                    $banner->save(true);

                    $file = $banner->upload_file($fileInputName);
                    $file->contributor_id = $this->getParam("contributor_id", 0);
                    $file->save();

                    $this->_helper->flashMessenger("City Banner successfully added.", 'success');
                    break;
                case "edit":
                    $banner->setPostData($_POST);
                    $banner->save(true);

                    // get the original record so that we can use old information which doesn't persist (e.g. files)
                    $originalRecord = SuperEightFestivalsCityBanner::get_by_id($banner->id);
                    $banner->file_id = $originalRecord->file_id;

                    // only change files if there is a file waiting
                    if (has_temporary_file($fileInputName)) {
                        // delete old files
                        $originalFile = $originalRecord->get_file();
                        $originalFile->delete_files();

                        // upload new file
                        $file = $banner->upload_file($fileInputName);
                        $file->contributor_id = $this->getParam("contributor_id", 0);
                        $file->save();
                    } else {
                        $file = $originalRecord->get_file();
                        $file->contributor_id = $this->getParam("contributor_id", 0);
                        $file->save();
                    }

                    // display result dialog
                    $this->_helper->flashMessenger("City Banner successfully updated.", 'success');

                    break;
                case "delete":
                    $banner->delete();
                    $this->_helper->flashMessenger("City Banner successfully deleted.", 'success');
                    break;
            }
        } catch (Omeka_Record_Exception $e) {
            $this->_helper->flashMessenger($e->getMessage(), 'error');
        } catch (Omeka_Validate_Exception $e) {
            $this->_helper->flashMessenger($e->getMessage(), 'error');
        }

        $this->redirect("/super-eight-festivals/countries/" . urlencode($banner->get_country()->get_location()->name) . "/cities/" . urlencode($banner->get_city()->get_location()->name));
    }
}
