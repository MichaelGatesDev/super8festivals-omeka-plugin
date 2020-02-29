<?php

class SuperEightFestivals_FilmsController extends Omeka_Controller_AbstractActionController
{

    public function init()
    {
        // Set the model class so this controller can perform some functions,
        // such as $this->findById()
        $this->_helper->db->setDefaultModelName('SuperEightFestivalsFestivalFilm');
    }

    public function indexAction()
    {
        $this->_helper->redirector('browse');
        return;
    }

    public function addAction()
    {
        // Create new catalog
        $film = new SuperEightFestivalsFestivalFilm();
        $form = $this->_getForm($film);
        $this->view->form = $form;
        $this->view->film = $film;
        $this->_processForm($film, $form, 'add');
    }

    public function editAction()
    {
        $film = $this->_helper->db->findById();
        $form = $this->_getForm($film);
        $this->view->form = $form;
        $this->view->film = $film;
        $this->_processForm($film, $form, 'edit');
    }

    public function viewAction()
    {
        $film = $this->_helper->db->findById();
        $this->view->film = $film;
    }

    protected function _getForm(SuperEightFestivalsFestivalFilm $film = null): Omeka_Form_Admin
    {
        $formOptions = array(
            'type' => 'super_eight_festivals_festival_film'
        );

        $form = new Omeka_Form_Admin($formOptions);

        $form->addElementToEditGroup(
            'select', 'festival_id',
            array(
                'id' => 'festival_id',
                'label' => 'Festival',
                'description' => "The festival which the item is a part of (required)",
                'multiOptions' => get_parent_festival_options(),
                'value' => $film->festival_id,
                'required' => true,
            )
        );

        $form->addElementToEditGroup(
            'select', 'contributor_id',
            array(
                'id' => 'contributor_id',
                'label' => 'Contributor',
                'description' => "The person who contributed the item",
                'multiOptions' => get_parent_contributor_options(),
                'value' => $film->contributor_id,
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'select', 'filmmaker_id',
            array(
                'id' => 'filmmaker_id',
                'label' => 'Filmmaker',
                'description' => "The person who made the item",
                'multiOptions' => get_parent_filmmaker_options(),
                'value' => $film->filmmaker_id,
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'text', 'title',
            array(
                'id' => 'title',
                'label' => 'Title',
                'description' => "The item's title",
                'value' => $film->title,
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'text', 'description',
            array(
                'id' => 'description',
                'label' => 'Description',
                'description' => "The item's description",
                'value' => $film->description,
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'text', 'thumbnail_path_file',
            array(
                'id' => 'thumbnail_path_file',
                'label' => 'Thumbnail Path (File)',
                'description' => "The item's thumbnail path (file)",
                'value' => $film->thumbnail_path_file,
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'text', 'thumbnail_path_web',
            array(
                'id' => 'thumbnail_path_web',
                'label' => 'Thumbnail Path (Web)',
                'description' => "The item's thumbnail path (web)",
                'value' => $film->thumbnail_path_web,
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'textarea', 'embed',
            array(
                'id' => 'embed',
                'label' => 'Embed Code',
                'description' => "The item's embed code",
                'value' => $film->embed,
                'required' => false,
            )
        );

        return $form;
    }

    private function _processForm(SuperEightFestivalsFestivalFilm $film, $form, $action)
    {
        // Set the page object to the view.
        $this->view->film = $film;

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
                $film->setPostData($_POST);

                if ($film->save()) {
                    if ($action == 'add') {
                        $this->_helper->flashMessenger(__('The film "%s" has been added.', $film->title), 'success');
                    } else if ($action == 'edit') {
                        $this->_helper->flashMessenger(__('The film "%s" has been edited.', $film->title), 'success');
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
