<?php

class SuperEightFestivals_FederationNewslettersController extends Omeka_Controller_AbstractActionController
{
    public function init()
    {
        // Set the model class so this controller can perform some functions,
        // such as $this->findById()
        $this->_helper->db->setDefaultModelName('SuperEightFestivalsFederationNewsletter');
    }

    public function indexAction()
    {
        $request = $this->getRequest();

        $this->redirect("/super-eight-festivals/federation/");
        return;
    }

    public function addAction()
    {
        $request = $this->getRequest();

        $federation_newsletter = new SuperEightFestivalsFederationNewsletter();
        $form = $this->_getForm($federation_newsletter);
        $this->view->form = $form;
        $this->view->newsletter = $federation_newsletter;
        $this->_processForm($federation_newsletter, $form, 'add');
    }

    public function editAction()
    {
        $request = $this->getRequest();

        $newsletterID = $request->getParam('newsletterID');
        $federation_newsletter = get_federation_newsletter_by_id($newsletterID);
        $this->view->federation_newsletter = $federation_newsletter;

        $form = $this->_getForm($federation_newsletter);
        $this->view->form = $form;
        $this->_processForm($federation_newsletter, $form, 'edit');
    }

    public function deleteAction()
    {
        $request = $this->getRequest();

        $newsletterID = $request->getParam('newsletterID');
        $federation_newsletter = get_federation_newsletter_by_id($newsletterID);
        $this->view->federation_newsletter = $federation_newsletter;

        $form = $this->_getDeleteForm();
        $this->view->form = $form;
        $this->_processForm($federation_newsletter, $form, 'delete');
    }

    protected function _getForm(SuperEightFestivalsFederationNewsletter $federation_newsletter = null): Omeka_Form_Admin
    {
        $formOptions = array(
            'type' => 'super_eight_festivals_federation_newsletter'
        );

        $form = new Omeka_Form_Admin($formOptions);

        $form->addElementToEditGroup(
            'select', 'contributor_id',
            array(
                'id' => 'contributor_id',
                'label' => 'Contributor',
                'description' => "The person who contributed the item",
                'multiOptions' => get_parent_contributor_options(),
                'value' => $federation_newsletter->contributor_id,
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'text', 'title',
            array(
                'id' => 'title',
                'label' => 'Title',
                'description' => "The federation newsletter's title",
                'value' => $federation_newsletter->title,
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'text', 'description',
            array(
                'id' => 'description',
                'label' => 'Description',
                'description' => "The federation newsletter's description",
                'value' => $federation_newsletter->description,
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'file', 'file',
            array(
                'id' => 'file',
                'label' => 'File',
                'description' => "The federation newsletter file",
                'required' => $federation_newsletter->file_name == "" || !file_exists($federation_newsletter->get_path()),
            )
        );

        return $form;
    }

    private function _processForm(SuperEightFestivalsFederationNewsletter $federation_newsletter, Zend_Form $form, $action)
    {
        $this->view->federation_newsletter = $federation_newsletter;

        if ($this->getRequest()->isPost()) {
            try {
                if (!$form->isValid($_POST)) {
                    $this->_helper->flashMessenger('There was an error on the form. Please try again.', 'error');
                    return;
                }
                try {
                    // delete
                    if ($action == 'delete') {
                        $federation_newsletter->delete();
                        $this->_helper->flashMessenger("The federation newsletter '" . $federation_newsletter->title . "' has been deleted.", 'success');
                    } // add
                    else if ($action == 'add') {
                        $federation_newsletter->setPostData($_POST);
                        if ($federation_newsletter->save()) {
                            // do file upload
                            $this->upload_file($federation_newsletter);
                            $this->_helper->flashMessenger("The federation newsletter '" . $federation_newsletter->title . "' has been added.", 'success');
                        }
                    } // edit
                    else if ($action == 'edit') {
                        // get the original so that we can use old information which doesn't persist well (e.g. files)
                        $originalRecord = get_federation_newsletter_by_id($federation_newsletter->id);
                        // set the data of the record according to what was submitted in the form
                        $federation_newsletter->setPostData($_POST);
                        // if there is no pending upload, use the old files
                        if (!has_temporary_file('file')) {
                            $federation_newsletter->file_name = $originalRecord->file_name;
                            $federation_newsletter->thumbnail_file_name = $originalRecord->thumbnail_file_name;
                        } else {
                            // temporarily set file name to uploaded file name
                            $federation_newsletter->file_name = get_temporary_file("file")[0];
                        }
                        if ($federation_newsletter->save()) {
                            // only change files if there is a file waiting
                            if (has_temporary_file('file')) {
                                // delete old files
                                $originalRecord->delete_files();
                                // do file upload
                                $this->upload_file($federation_newsletter);
                            }
                            // display result dialog
                            $this->_helper->flashMessenger("The federation newsletter '" . $federation_newsletter->title . "' has been edited.", 'success');
                        }
                    }

                    // bring us back to the city page
                    $this->redirect("/super-eight-festivals/federation");
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

    private function upload_file(SuperEightFestivalsFederationNewsletter $federation_newsletter)
    {
        list($original_name, $temporary_name, $extension) = get_temporary_file("file");
        $newFileName = uniqid($federation_newsletter->get_internal_prefix() . "_") . "." . $extension;
        move_to_dir($temporary_name, $newFileName, $federation_newsletter->get_dir());
        $federation_newsletter->file_name = $newFileName;
        $federation_newsletter->create_thumbnail();
        $federation_newsletter->save();
    }

}
