<?php

class SuperEightFestivals_AdminFederationBylawsController extends Omeka_Controller_AbstractActionController
{
    public function init()
    {
        // Set the model class so this controller can perform some functions,
        // such as $this->findById()
        $this->_helper->db->setDefaultModelName('SuperEightFestivalsFederationBylaw');
    }

    public function indexAction()
    {
        $this->redirect("/super-eight-festivals/federation/");
    }

    public function addAction()
    {
        $request = $this->getRequest();

        $federation_bylaw = new SuperEightFestivalsFederationBylaw();
        $form = $this->_getForm($federation_bylaw);
        $this->view->form = $form;
        $this->view->bylaw = $federation_bylaw;
        $this->_processForm($federation_bylaw, $form, 'add');
    }

    public function editAction()
    {
        $request = $this->getRequest();

        $bylawID = $request->getParam('bylawID');
        $federation_bylaw = SuperEightFestivalsFederationBylaw::get_by_id($bylawID);
        $this->view->federation_bylaw = $federation_bylaw;

        $form = $this->_getForm($federation_bylaw);
        $this->view->form = $form;
        $this->_processForm($federation_bylaw, $form, 'edit');
    }

    public function deleteAction()
    {
        $request = $this->getRequest();

        $bylawID = $request->getParam('bylawID');
        $federation_bylaw = SuperEightFestivalsFederationBylaw::get_by_id($bylawID);
        $this->view->federation_bylaw = $federation_bylaw;

        $form = $this->_getDeleteForm();
        $this->view->form = $form;
        $this->_processForm($federation_bylaw, $form, 'delete');
    }

    protected function _getForm(SuperEightFestivalsFederationBylaw $federation_bylaw = null): Omeka_Form_Admin
    {
        $formOptions = array(
            'type' => 'super_eight_festivals_federation_bylaw'
        );

        $form = new Omeka_Form_Admin($formOptions);

        $file = $federation_bylaw->get_file();

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
                'description' => "The federation bylaw's title",
                'value' => $file ? $file->title : "",
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'text', 'description',
            array(
                'id' => 'description',
                'label' => 'Description',
                'description' => "The federation bylaw's description",
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

    private function _processForm(SuperEightFestivalsFederationBylaw $banner, Zend_Form $form, $action)
    {
        $this->view->banner = $banner;

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
        }

        $fileInputName = "file";
        try {
            switch ($action) {
                case "add":
                    $banner->setPostData($_POST);
                    if ($banner->save()) {
                        $banner->upload_file($fileInputName, $this->getParam("title", ""), $this->getParam("description", ""));
                        $this->_helper->flashMessenger("Federation By-Law successfully added.", 'success');
                    }
                    break;
                case "edit":
                    $banner->setPostData($_POST);

                    if ($banner->save()) {
                        // get the original record so that we can use old information which doesn't persist (e.g. files)
                        $originalRecord = SuperEightFestivalsFederationBylaw::get_by_id($banner->id);
                        $banner->file_id = $originalRecord->file_id;

                        // only change files if there is a file waiting
                        if (has_temporary_file($fileInputName)) {
                            // delete old files
                            $originalFile = $originalRecord->get_file();
                            $originalFile->delete_files();

                            // upload new file
                            $banner->upload_file($fileInputName, $this->getParam("title", ""), $this->getParam("description", ""));
                        }

                        // display result dialog
                        $this->_helper->flashMessenger("Federation By-Law successfully updated.", 'success');
                    }
                    break;
                case "delete":
                    $banner->delete();
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
