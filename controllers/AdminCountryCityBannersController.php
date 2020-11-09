<?php

class SuperEightFestivals_AdminCountryCityBannersController extends Omeka_Controller_AbstractActionController
{
    public function init()
    {
        // Set the model class so this controller can perform some functions,
        // such as $this->findById()
        $this->_helper->db->setDefaultModelName('SuperEightFestivalsCityBanner');
    }

    public function indexAction()
    {
        $request = $this->getRequest();

        $country = get_request_param_country($request);
        $city = get_request_param_city($request);

        $this->redirect("/super-eight-festivals/countries/" . urlencode($country->name) . "/cities/" . urlencode($city->name));
    }

    public function addAction()
    {
        $request = $this->getRequest();

        $this->view->country = $country = get_request_param_country($request);
        $this->view->city = $city = get_request_param_city($request);

        // Create new banner
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
        $this->view->banner = $banner;

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
        $this->view->banner = $banner;

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

        $form->addElementToEditGroup(
            'file', 'file',
            array(
                'id' => 'file',
                'label' => 'File',
                'description' => "The banner image file",
                'required' => $banner == null || $banner->get_file() == null || !file_exists($banner->get_file()->file_name),
                'accept' => get_form_accept_string(get_image_types()),
            )
        );

        return $form;
    }


    private function _processForm(SuperEightFestivalsCityBanner $banner, Zend_Form $form, $action)
    {
        $this->view->banner = $banner;

        if ($this->getRequest()->isPost()) {
            try {
                if (!$form->isValid($_POST)) {
                    $this->_helper->flashMessenger('There was an error on the form. Please try again.', 'error');
                    return;
                }
                // delete
                if ($action == 'delete') {
                    $banner->delete();
                    $this->_helper->flashMessenger("The banner for " . $banner->get_city()->name . " has been deleted.", 'success');
                } //add
                else if ($action == 'add') {
                    $banner->setPostData($_POST);
                    if ($banner->save()) {
                        // do file upload
                        $banner->upload();
                        $this->_helper->flashMessenger("The banner for " . $banner->get_city()->name . " has been added.", 'success');
                    }
                } //edit
                else if ($action == 'edit') {
                    // get the original so that we can use old information which doesn't persist well (e.g. files)
                    $originalRecord = SuperEightFestivalsCityBanner::get_by_id($banner->id);
                    $originalFile = $originalRecord->get_file();
                    // set the data of the record according to what was submitted in the form
                    $banner->setPostData($_POST);
                    $banner->file_id = $originalRecord->file_id;
                    if ($banner->save()) {
                        // only change files if there is a file waiting
                        if (has_temporary_file('file')) {
                            // delete old files
                            if ($originalRecord != null) {
                                $originalFile->delete_files();
                            }
                            // do file upload
                            $banner->upload();
                        }
                        // display result dialog
                        $this->_helper->flashMessenger("The banner for " . $banner->get_city()->name . " has been edited.", 'success');
                    }
                }

                $this->redirect("/super-eight-festivals/countries/" . urlencode($banner->get_country()->name) . "/cities/" . urlencode($banner->get_city()->name));
            } catch (Omeka_Validate_Exception $e) {
                $this->_helper->flashMessenger($e);
            } catch (Omeka_Record_Exception $e) {
                $this->_helper->flashMessenger($e);
            } catch (Zend_Form_Exception $e) {
                $this->_helper->flashMessenger($e);
            }
        }
    }
}
