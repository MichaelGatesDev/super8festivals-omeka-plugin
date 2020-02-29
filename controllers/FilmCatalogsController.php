<?php

class SuperEightFestivals_FilmCatalogsController extends Omeka_Controller_AbstractActionController
{

    public function init()
    {
        // Set the model class so this controller can perform some functions,
        // such as $this->findById()
        $this->_helper->db->setDefaultModelName('SuperEightFestivalsFestivalFilmCatalog');
    }

    public function indexAction()
    {
        $this->_helper->redirector('browse');
        return;
    }

    public function addAction()
    {
        // Create new catalog
        $film_catalog = new SuperEightFestivalsFestivalFilmCatalog();
        $form = $this->_getForm($film_catalog);
        $this->view->form = $form;
        $this->view->film_catalog = $film_catalog;
        $this->_processForm($film_catalog, $form, 'add');
    }

    public function editAction()
    {
        $film_catalog = $this->_helper->db->findById();
        $form = $this->_getForm($film_catalog);
        $this->view->form = $form;
        $this->view->film_catalog = $film_catalog;
        $this->_processForm($film_catalog, $form, 'edit');
    }

    public function viewAction()
    {
        $film_catalog = $this->_helper->db->findById();
        $this->view->film_catalog = $film_catalog;
    }

    protected function _getForm(SuperEightFestivalsFestivalFilmCatalog $film_catalog = null): Omeka_Form_Admin
    {
        $formOptions = array(
            'type' => 'super_eight_festivals_festival_film_catalog'
        );

        $form = new Omeka_Form_Admin($formOptions);

        $form->addElementToEditGroup(
            'select', 'festival_id',
            array(
                'id' => 'festival_id',
                'label' => 'Festival',
                'description' => "The festival which the catalog was a member of (required)",
                'multiOptions' => get_parent_festival_options(),
                'value' => $film_catalog->festival_id,
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
                'value' => $film_catalog->contributor_id,
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'text', 'title',
            array(
                'id' => 'title',
                'label' => 'Title',
                'description' => "The catalog's title",
                'value' => $film_catalog->title,
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'text', 'description',
            array(
                'id' => 'description',
                'label' => 'Description',
                'description' => "The catalog's description",
                'value' => $film_catalog->description,
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'text', 'thumbnail_path_file',
            array(
                'id' => 'thumbnail_path_file',
                'label' => 'Thumbnail Path (File)',
                'description' => "The catalog's thumbnail path (file)",
                'value' => $film_catalog->thumbnail_path_file,
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'text', 'thumbnail_path_web',
            array(
                'id' => 'thumbnail_path_web',
                'label' => 'Thumbnail Path (Web)',
                'description' => "The catalog's thumbnail path (web)",
                'value' => $film_catalog->thumbnail_path_web,
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'text', 'path_file',
            array(
                'id' => 'path_file',
                'label' => 'Path (File)',
                'description' => "The catalog's path (file)",
                'value' => $film_catalog->path_file,
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'text', 'path_web',
            array(
                'id' => 'path_web',
                'label' => 'Path (Web)',
                'description' => "The catalog's path (web)",
                'value' => $film_catalog->path_web,
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'textarea', 'embed',
            array(
                'id' => 'embed',
                'label' => 'Embed Code',
                'description' => "The catalog's embed code",
                'value' => $film_catalog->embed,
                'required' => false,
            )
        );

        return $form;
    }

    private function _processForm(SuperEightFestivalsFestivalFilmCatalog $film_catalog, $form, $action)
    {
        // Set the page object to the view.
        $this->view->film_catalog = $film_catalog;

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
                $film_catalog->setPostData($_POST);

                if ($film_catalog->save()) {
                    if ($action == 'add') {
                        $this->_helper->flashMessenger(__('The film catalog "%s" has been added.', $film_catalog->title), 'success');
                    } else if ($action == 'edit') {
                        $this->_helper->flashMessenger(__('The film catalog "%s" has been edited.', $film_catalog->title), 'success');
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
