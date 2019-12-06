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
        $this->_helper->redirector('browse');
        return;
    }

    public function addAction()
    {
        // Create new banner
        $banner = new SuperEightFestivalsCountryBanner();
        $form = $this->_getForm($banner);
        $this->view->form = $form;
        $this->_processForm($banner, $form, 'add');
    }

    public function editAction()
    {
        $banner = $this->_helper->db->findById();
        $form = $this->_getForm($banner);
        $this->view->form = $form;
        $this->_processForm($banner, $form, 'edit');
    }

    /**
     * @param SuperEightFestivalsCountryBanner|null $banner
     * @return Omeka_Form_Admin
     */
    protected function _getForm($banner = null)
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
            'text', 'path',
            array(
                'id' => 'path',
                'label' => 'Path',
                'description' => "The file path or URL to the image (required)",
                'value' => $banner->path,
                'required' => true
            )
        );
        $form->addElementToEditGroup(
            'text', 'thumbnail',
            array(
                'id' => 'thumbnail',
                'label' => 'Thumbnail path',
                'description' => "The file thumbnail or URL to the thumbnail image (required)",
                'value' => $banner->thumbnail,
                'required' => true
            )
        );

        if (class_exists('Omeka_Form_Element_SessionCsrfToken')) {
            try {
                $form->addElement('sessionCsrfToken', 'csrf_token');
            } catch (Zend_Form_Exception $e) {
                echo $e;
            }
        }

        return $form;
    }

    /**
     * @param $banner SuperEightFestivalsCountryBanner
     * @param $form Omeka_Form
     * @param $action
     */
    private function _processForm($banner, $form, $action)
    {
        // Set the page object to the view.
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
                $banner->setPostData($_POST);
                if ($banner->save()) {
                    if ($action == 'add') {
                        $this->_helper->flashMessenger(__('The banner has been added for %s.', $banner->getCountry()->name), 'success');
                    } else if ($action == 'edit') {
                        $this->_helper->flashMessenger(__('The banner has been edited for %s.', $banner->getCountry()->name), 'success');
                    }
                    $this->_helper->redirector('index');
                    return;
                }
                // Catch validation errors.
            } catch (Omeka_Validate_Exception $e) {
                $this->_helper->flashMessenger($e);
            } catch (Omeka_Record_Exception $e) {
                $this->_helper->flashMessenger($e);
            }
        }
    }

}
