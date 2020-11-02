<?php

class SuperEightFestivals_AdminFederationMagazinesController extends Omeka_Controller_AbstractActionController
{
    public function init()
    {
        // Set the model class so this controller can perform some functions,
        // such as $this->findById()
        $this->_helper->db->setDefaultModelName('SuperEightFestivalsFederationMagazine');
    }

    public function indexAction()
    {
        $request = $this->getRequest();

        $this->redirect("/super-eight-festivals/federation/");
    }

    public function addAction()
    {
        $request = $this->getRequest();

        $federation_magazine = new SuperEightFestivalsFederationMagazine();
        $form = $this->_getForm($federation_magazine);
        $this->view->form = $form;
        $this->view->magazine = $federation_magazine;
        $this->_processForm($federation_magazine, $form, 'add');
    }

    public function editAction()
    {
        $request = $this->getRequest();

        $magazineID = $request->getParam('magazineID');
        $federation_magazine = SuperEightFestivalsFederationMagazine::get_by_id($magazineID);
        $this->view->federation_magazine = $federation_magazine;

        $form = $this->_getForm($federation_magazine);
        $this->view->form = $form;
        $this->_processForm($federation_magazine, $form, 'edit');
    }

    public function deleteAction()
    {
        $request = $this->getRequest();

        $magazineID = $request->getParam('magazineID');
        $federation_magazine = SuperEightFestivalsFederationMagazine::get_by_id($magazineID);
        $this->view->federation_magazine = $federation_magazine;

        $form = $this->_getDeleteForm();
        $this->view->form = $form;
        $this->_processForm($federation_magazine, $form, 'delete');
    }

    protected function _getForm(SuperEightFestivalsFederationMagazine $federation_magazine = null): Omeka_Form_Admin
    {
        $formOptions = array(
            'type' => 'super_eight_festivals_federation_magazine'
        );

        $form = new Omeka_Form_Admin($formOptions);

        $form->addElementToEditGroup(
            'select', 'contributor_id',
            array(
                'id' => 'contributor_id',
                'label' => 'Contributor',
                'description' => "The person who contributed the item",
                'multiOptions' => get_parent_contributor_options(),
                'value' => $federation_magazine->contributor_id,
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'text', 'title',
            array(
                'id' => 'title',
                'label' => 'Title',
                'description' => "The federation magazine's title",
                'value' => $federation_magazine->title,
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'text', 'description',
            array(
                'id' => 'description',
                'label' => 'Description',
                'description' => "The federation magazine's description",
                'value' => $federation_magazine->description,
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'file', 'file',
            array(
                'id' => 'file',
                'label' => 'File',
                'description' => "The federation magazine file",
                'required' => $federation_magazine->file_name == "" || !file_exists($federation_magazine->get_path()),
                'accept' => get_form_accept_string(array_merge(get_image_types(), get_document_types())),
            )
        );

        return $form;
    }

    private function _processForm(SuperEightFestivalsFederationMagazine $federation_magazine, Zend_Form $form, $action)
    {
        $this->view->federation_magazine = $federation_magazine;

        if ($this->getRequest()->isPost()) {
            try {
                if (!$form->isValid($_POST)) {
                    $this->_helper->flashMessenger('There was an error on the form. Please try again.', 'error');
                    return;
                }
                try {
                    // delete
                    if ($action == 'delete') {
                        $federation_magazine->delete();
                        $this->_helper->flashMessenger("The federation magazine '" . $federation_magazine->title . "' has been deleted.", 'success');
                    } // add
                    else if ($action == 'add') {
                        $federation_magazine->setPostData($_POST);
                        if ($federation_magazine->save()) {
                            // do file upload
                            $this->upload_file($federation_magazine);
                            $this->_helper->flashMessenger("The federation magazine '" . $federation_magazine->title . "' has been added.", 'success');
                        }
                    } // edit
                    else if ($action == 'edit') {
                        // get the original so that we can use old information which doesn't persist well (e.g. files)
                        $originalRecord = SuperEightFestivalsFederationMagazine::get_by_id($federation_magazine->id);
                        // set the data of the record according to what was submitted in the form
                        $federation_magazine->setPostData($_POST);
                        // if there is no pending upload, use the old files
                        if (!has_temporary_file('file')) {
                            $federation_magazine->file_name = $originalRecord->file_name;
                            $federation_magazine->thumbnail_file_name = $originalRecord->thumbnail_file_name;
                        } else {
                            // temporarily set file name to uploaded file name
                            $federation_magazine->file_name = get_temporary_file("file")[0];
                        }
                        if ($federation_magazine->save()) {
                            // only change files if there is a file waiting
                            if (has_temporary_file('file')) {
                                // delete old files
                                $originalRecord->delete_files();
                                // do file upload
                                $this->upload_file($federation_magazine);
                            }
                            // display result dialog
                            $this->_helper->flashMessenger("The federation magazine '" . $federation_magazine->title . "' has been edited.", 'success');
                        }
                    }


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

    private function upload_file(SuperEightFestivalsFederationMagazine $federation_magazine)
    {
        list($original_name, $temporary_name, $extension) = get_temporary_file("file");
        $newFileName = uniqid($federation_magazine->get_internal_prefix() . "_") . "." . $extension;
        move_tempfile_to_dir($temporary_name, $newFileName, get_uploads_dir());
        $federation_magazine->file_name = $newFileName;
        $federation_magazine->create_thumbnail();
        $federation_magazine->save();
    }

}
