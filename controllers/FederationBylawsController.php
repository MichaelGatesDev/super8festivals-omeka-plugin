<?php

class SuperEightFestivals_FederationBylawsController extends Omeka_Controller_AbstractActionController
{
    public function init()
    {
        // Set the model class so this controller can perform some functions,
        // such as $this->findById()
        $this->_helper->db->setDefaultModelName('SuperEightFestivalsFederationBylaw');
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
        $federation_bylaw = get_federation_bylaw_by_id($bylawID);
        $this->view->federation_bylaw = $federation_bylaw;

        $form = $this->_getForm($federation_bylaw);
        $this->view->form = $form;
        $this->_processForm($federation_bylaw, $form, 'edit');
    }

    public function deleteAction()
    {
        $request = $this->getRequest();

        $bylawID = $request->getParam('bylawID');
        $federation_bylaw = get_federation_bylaw_by_id($bylawID);
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

        $form->addElementToEditGroup(
            'select', 'contributor_id',
            array(
                'id' => 'contributor_id',
                'label' => 'Contributor',
                'description' => "The person who contributed the item",
                'multiOptions' => get_parent_contributor_options(),
                'value' => $federation_bylaw->contributor_id,
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'text', 'title',
            array(
                'id' => 'title',
                'label' => 'Title',
                'description' => "The federation bylaw's title",
                'value' => $federation_bylaw->title,
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'text', 'description',
            array(
                'id' => 'description',
                'label' => 'Description',
                'description' => "The federation bylaw's description",
                'value' => $federation_bylaw->description,
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'file', 'file',
            array(
                'id' => 'file',
                'label' => 'File',
                'description' => "The federation bylaw file",
                'required' => $federation_bylaw->file_name == "" || !file_exists($federation_bylaw->get_path()),
            )
        );

        return $form;
    }

    private function _processForm(SuperEightFestivalsFederationBylaw $federation_bylaw, Zend_Form $form, $action)
    {
        $this->view->federation_bylaw = $federation_bylaw;

        if ($this->getRequest()->isPost()) {
            try {
                if (!$form->isValid($_POST)) {
                    $this->_helper->flashMessenger('There was an error on the form. Please try again.', 'error');
                    return;
                }
                try {
                    // delete
                    if ($action == 'delete') {
                        $federation_bylaw->delete();
                        $this->_helper->flashMessenger("The federation bylaw '" . $federation_bylaw->title . "' has been deleted.", 'success');
                    } // add
                    else if ($action == 'add') {
                        $federation_bylaw->setPostData($_POST);
                        if ($federation_bylaw->save()) {
                            // do file upload
                            $this->upload_file($federation_bylaw);
                            $this->_helper->flashMessenger("The federation bylaw '" . $federation_bylaw->title . "' has been added.", 'success');
                        }
                    } // edit
                    else if ($action == 'edit') {
                        // get the original so that we can use old information which doesn't persist well (e.g. files)
                        $originalRecord = get_federation_bylaw_by_id($federation_bylaw->id);
                        // set the data of the record according to what was submitted in the form
                        $federation_bylaw->setPostData($_POST);
                        // if there is no pending upload, use the old files
                        if (!has_temporary_file('file')) {
                            $federation_bylaw->file_name = $originalRecord->file_name;
                            $federation_bylaw->thumbnail_file_name = $originalRecord->thumbnail_file_name;
                        } else {
                            // temporarily set file name to uploaded file name
                            $federation_bylaw->file_name = get_temporary_file("file")[0];
                        }
                        if ($federation_bylaw->save()) {
                            // only change files if there is a file waiting
                            if (has_temporary_file('file')) {
                                // delete old files
                                $originalRecord->delete_files();
                                // do file upload
                                $this->upload_file($federation_bylaw);
                            }
                            // display result dialog
                            $this->_helper->flashMessenger("The federation bylaw '" . $federation_bylaw->title . "' has been edited.", 'success');
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

    private function upload_file(SuperEightFestivalsFederationBylaw $federation_bylaw)
    {
        list($original_name, $temporary_name, $extension) = get_temporary_file("file");
        $newFileName = uniqid($federation_bylaw->get_internal_prefix() . "_") . "." . $extension;
        move_to_dir($temporary_name, $newFileName, $federation_bylaw->get_dir());
        $federation_bylaw->file_name = $newFileName;
        $federation_bylaw->create_thumbnail();
        $federation_bylaw->save();
    }

}
