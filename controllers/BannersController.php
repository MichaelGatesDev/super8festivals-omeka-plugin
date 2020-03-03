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

        return;
    }

    public function singleAction()
    {
        $request = $this->getRequest();

        $countryName = $request->getParam('countryName');
        $country = get_country_by_name($countryName);
        $this->view->country = $country;

        $bannerID = $request->getParam('bannerID');
        $banner = get_banner_by_id($bannerID);
        $this->view->banner = $banner;

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

    public function deleteAction()
    {
        $request = $this->getRequest();

        $countryName = $request->getParam('countryName');
        $country = get_country_by_name($countryName);
        $this->view->country = $country;

        $bannerID = $request->getParam('bannerID');
        $banner = get_banner_by_id($bannerID);
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
                'required' => true,
            )
        );

        return $form;
    }


    private function _processForm(SuperEightFestivalsCountryBanner $banner, $form, $action)
    {
        $this->view->banner = $banner;

        if ($this->getRequest()->isPost()) {
            try {
                if (!$form->isValid($_POST)) {
                    $this->_helper->flashMessenger('There was an error on the form. Please try again.', 'error');
                    return;
                }
            } catch (Zend_Form_Exception $e) {
                $this->_helper->flashMessenger($e);
            }
            try {
                if ($action == 'delete') {
                    $banner->delete();
                    $this->_helper->flashMessenger("The banner for " . $banner->get_country()->name . " has been deleted.", 'success');
                    $this->redirect("/super-eight-festivals/countries/" . $banner->get_country()->name);
                } else if ($action == 'add') {

                    // do file upload
                    list($original_name, $temporary_name, $extension) = get_temporary_file("file");
                    $newFileName = uniqid("banner_") . "." . $extension;
                    move_to_dir($temporary_name, $newFileName, get_country_dir($banner->get_country()->name));

                    $banner->setPostData($_POST);
                    $banner->path_file = $newFileName;
                    if ($banner->save()) {
                        if ($action == 'add') {
                            $this->_helper->flashMessenger("The banner for " . $banner->get_country()->name . " has been added.", 'success');
                        }
                        $this->redirect("/super-eight-festivals/countries/" . $banner->get_country()->name . "/");
                    }
                }
            } catch (Omeka_Validate_Exception $e) {
                $this->_helper->flashMessenger($e);
            } catch (Omeka_Record_Exception $e) {
                $this->_helper->flashMessenger($e);
            }
        }
    }

}
