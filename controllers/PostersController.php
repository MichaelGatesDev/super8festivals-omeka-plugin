<?php

class SuperEightFestivals_PostersController extends Omeka_Controller_AbstractActionController
{
    public function init()
    {
        // Set the model class so this controller can perform some functions,
        // such as $this->findById()
        $this->_helper->db->setDefaultModelName('SuperEightFestivalsFestivalPoster');
    }

    public function indexAction()
    {
        $this->_helper->redirector('browse');
        return;
    }

    public function addAction()
    {
        // Create new poster
        $poster = new SuperEightFestivalsFestivalPoster();
        $form = $this->_getForm($poster);
        $this->view->form = $form;
        $this->_processForm($poster, $form, 'add');
    }

    public function editAction()
    {
        $poster = $this->_helper->db->findById();
        $form = $this->_getForm($poster);
        $this->view->form = $form;
        $this->_processForm($poster, $form, 'edit');
    }

    /**
     * @param SuperEightFestivalsFestivalPoster|null $poster
     * @return Omeka_Form_Admin
     */
    protected function _getForm($poster = null)
    {
        $formOptions = array(
            'type' => 'super_eight_festivals_country_poster'
        );

        $form = new Omeka_Form_Admin($formOptions);

        $form->addElementToEditGroup(
            'select', 'city_id',
            array(
                'id' => 'city_id',
                'label' => 'City',
                'description' => "The city which the poster belongs to (required)",
                'multiOptions' => get_parent_city_options(),
                'value' => $poster->city_id,
                'required' => true
            )
        );

        $form->addElementToEditGroup(
            'text', 'path',
            array(
                'id' => 'path',
                'label' => 'Path',
                'description' => "The file path or URL to the image (required)",
                'value' => $poster->path,
                'required' => true
            )
        );
        $form->addElementToEditGroup(
            'text', 'thumbnail',
            array(
                'id' => 'thumbnail',
                'label' => 'Thumbnail path',
                'description' => "The file thumbnail or URL to the thumbnail image (required)",
                'value' => $poster->thumbnail,
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
     * @param $poster SuperEightFestivalsFestivalPoster
     * @param $form Omeka_Form
     * @param $action
     */
    private function _processForm($poster, $form, $action)
    {
        // Set the page object to the view.
        $this->view->poster = $poster;

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
                $poster->setPostData($_POST);
                if ($poster->save()) {
                    if ($action == 'add') {
                        $this->_helper->flashMessenger(__('The poster has been added for %s.', $poster->getCountry()->name), 'success');
                    } else if ($action == 'edit') {
                        $this->_helper->flashMessenger(__('The poster has been edited for %s.', $poster->getCountry()->name), 'success');
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
