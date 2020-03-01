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

    public function editAction()
    {
        $request = $this->getRequest();

        $countryName = $request->getParam('countryName');
        $country = get_country_by_name($countryName);
        $this->view->country = $country;

        $bannerID = $request->getParam('bannerID');
        $banner = get_banner_by_id($bannerID);
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
            'text', 'thumbnail_path_file',
            array(
                'id' => 'thumbnail_path_file',
                'label' => 'Thumbnail Path (File)',
                'description' => "The banner's thumbnail path (file)",
                'value' => $banner->thumbnail_path_file,
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'text', 'thumbnail_path_web',
            array(
                'id' => 'thumbnail_path_web',
                'label' => 'Thumbnail Path (Web)',
                'description' => "The banner's thumbnail path (web)",
                'value' => $banner->thumbnail_path_web,
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'text', 'path_file',
            array(
                'id' => 'path_file',
                'label' => 'Path (File)',
                'description' => "The banner's path (file)",
                'value' => $banner->path_file,
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'text', 'path_web',
            array(
                'id' => 'path_web',
                'label' => 'Path (Web)',
                'description' => "The banner's path (web)",
                'value' => $banner->path_web,
                'required' => false,
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
                    $this->_helper->flashMessenger(__('The banner "%s" has been deleted.', $banner->id), 'success');
                    $this->redirect("/super-eight-festivals/countries/" . $banner->getCountry()->name);
//                    $this->redirect("/super-eight-festivals/countries/" . $banner->getCountry()->name . "/cities/");
                } else {
                    $banner->setPostData($_POST);
                    if ($banner->save()) {
                        if ($action == 'add') {
                            $this->_helper->flashMessenger(__('The banner "%s" has been added.', $banner->id), 'success');
                        } else if ($action == 'edit') {
                            $this->_helper->flashMessenger(__('The banner "%s" has been edited.', $banner->id), 'success');
                        }
                        $this->redirect("/super-eight-festivals/countries/" . $banner->getCountry()->name . "/banners/");
                        return;
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
