<?php

class SuperEightFestivals_AdminFederationMagazinesController extends Omeka_Controller_AbstractActionController
{

    public function indexAction()
    {
        $this->redirect("/super-eight-festivals/federation/");
    }

    public function addAction()
    {
        $request = $this->getRequest();

        $magazine = new SuperEightFestivalsFederationMagazine();
        $form = $this->_getForm($magazine);
        $this->view->form = $form;
        $this->view->magazine = $magazine;
        $this->_processForm($magazine, $form, 'add');
    }

    public function editAction()
    {
        $request = $this->getRequest();

        $magazineID = $request->getParam('magazineID');
        $magazine = SuperEightFestivalsFederationMagazine::get_by_id($magazineID);
        $this->view->magazine = $magazine;

        $form = $this->_getForm($magazine);
        $this->view->form = $form;
        $this->_processForm($magazine, $form, 'edit');
    }

    public function deleteAction()
    {
        $request = $this->getRequest();

        $magazineID = $request->getParam('magazineID');
        $magazine = SuperEightFestivalsFederationMagazine::get_by_id($magazineID);
        $this->view->magazine = $magazine;

        $form = $this->_getDeleteForm();
        $this->view->form = $form;
        $this->_processForm($magazine, $form, 'delete');
    }

    protected function _getForm(SuperEightFestivalsFederationMagazine $magazine = null): Omeka_Form_Admin
    {
        $formOptions = array(
            'type' => 'super_eight_festivals_federation_magazine'
        );

        $form = new Omeka_Form_Admin($formOptions);

        $file = $magazine->get_file();

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
            'text', 'title',
            array(
                'id' => 'title',
                'label' => 'Title',
                'description' => "The federation magazine's title",
                'value' => $file ? $file->title : "",
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'text', 'description',
            array(
                'id' => 'description',
                'label' => 'Description',
                'description' => "The federation magazine's description",
                'value' => $file ? $file->description : "",
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'file', 'file',
            array(
                'id' => 'file',
                'label' => 'File',
                'description' => "The document/image file",
                'required' => !$file || $file->file_name == "" || !file_exists($file->get_path()),
                'accept' => get_form_accept_string(array_merge(get_image_types(), get_document_types())),
            )
        );

        return $form;
    }

    private function _processForm(SuperEightFestivalsFederationMagazine $magazine, Zend_Form $form, $action)
    {
        $this->view->magazine = $magazine;

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
            return;
        }

        $fileInputName = "file";
        try {
            switch ($action) {
                case "add":
                    $magazine->setPostData($_POST);
                    $magazine->save(true);

                    $file = $magazine->upload_file($fileInputName);
                    $file->contributor_id = $this->getParam("contributor", 0);
                    $file->title = $this->getParam("title", "");
                    $file->description = $this->getParam("description", "");
                    $file->save();

                    $this->_helper->flashMessenger("Federation By-Law successfully added.", 'success');
                    break;
                case "edit":
                    $magazine->setPostData($_POST);
                    $magazine->save(true);

                    // get the original record so that we can use old information which doesn't persist (e.g. files)
                    $originalRecord = SuperEightFestivalsFederationMagazine::get_by_id($magazine->id);
                    $magazine->file_id = $originalRecord->file_id;

                    // only change files if there is a file waiting
                    if (has_temporary_file($fileInputName)) {
                        // delete old files
                        $originalFile = $originalRecord->get_file();
                        $originalFile->delete_files();

                        // upload new file
                        $file = $magazine->upload_file($fileInputName);
                        $file->contributor_id = $this->getParam("contributor", 0);
                        $file->title = $this->getParam("title", "");
                        $file->description = $this->getParam("description", "");
                        $file->save();
                    } else {
                        $file = $originalRecord->get_file();
                        $file->contributor_id = $this->getParam("contributor", 0);
                        $file->title = $this->getParam("title", "");
                        $file->description = $this->getParam("description", "");
                        $file->save();
                    }

                    // display result dialog
                    $this->_helper->flashMessenger("Federation By-Law successfully updated.", 'success');
                    break;
                case "delete":
                    $magazine->delete();
                    $this->_helper->flashMessenger("Federation By-Law successfully deleted.", 'success');
                    break;
            }
        } catch (Omeka_Record_Exception $e) {
            $this->_helper->flashMessenger($e->getMessage(), 'error');
        } catch (Omeka_Validate_Exception $e) {
            $this->_helper->flashMessenger($e->getMessage(), 'error');
        }

        $this->redirect("/super-eight-festivals/federation/");
    }

}
