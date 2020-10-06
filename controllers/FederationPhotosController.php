<?php

class SuperEightFestivals_FederationPhotosController extends Omeka_Controller_AbstractActionController
{
    public function init()
    {
        // Set the model class so this controller can perform some functions,
        // such as $this->findById()
        $this->_helper->db->setDefaultModelName('SuperEightFestivalsFederationPhoto');
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

        $federation_photo = new SuperEightFestivalsFederationPhoto();
        $form = $this->_getForm($federation_photo);
        $this->view->form = $form;
        $this->view->photo = $federation_photo;
        $this->_processForm($federation_photo, $form, 'add');
    }

    public function editAction()
    {
        $request = $this->getRequest();

        $photoID = $request->getParam('photoID');
        $federation_photo = SuperEightFestivalsFederationPhoto::get_by_id($photoID);
        $this->view->federation_photo = $federation_photo;

        $form = $this->_getForm($federation_photo);
        $this->view->form = $form;
        $this->_processForm($federation_photo, $form, 'edit');
    }

    public function deleteAction()
    {
        $request = $this->getRequest();

        $photoID = $request->getParam('photoID');
        $federation_photo = SuperEightFestivalsFederationPhoto::get_by_id($photoID);
        $this->view->federation_photo = $federation_photo;

        $form = $this->_getDeleteForm();
        $this->view->form = $form;
        $this->_processForm($federation_photo, $form, 'delete');
    }

    protected function _getForm(SuperEightFestivalsFederationPhoto $federation_photo = null): Omeka_Form_Admin
    {
        $formOptions = array(
            'type' => 'super_eight_festivals_federation_photo'
        );

        $form = new Omeka_Form_Admin($formOptions);

        $form->addElementToEditGroup(
            'select', 'contributor_id',
            array(
                'id' => 'contributor_id',
                'label' => 'Contributor',
                'description' => "The person who contributed the item",
                'multiOptions' => get_parent_contributor_options(),
                'value' => $federation_photo->contributor_id,
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'text', 'title',
            array(
                'id' => 'title',
                'label' => 'Title',
                'description' => "The federation photo's title",
                'value' => $federation_photo->title,
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'text', 'description',
            array(
                'id' => 'description',
                'label' => 'Description',
                'description' => "The federation photo's description",
                'value' => $federation_photo->description,
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'file', 'file',
            array(
                'id' => 'file',
                'label' => 'File',
                'description' => "The federation photo file",
                'required' => $federation_photo->file_name == "" || !file_exists($federation_photo->get_path()),
                'accept' => get_form_accept_string(get_image_types()),
            )
        );

        return $form;
    }

    private function _processForm(SuperEightFestivalsFederationPhoto $federation_photo, Zend_Form $form, $action)
    {
        $this->view->federation_photo = $federation_photo;

        if ($this->getRequest()->isPost()) {
            try {
                if (!$form->isValid($_POST)) {
                    $this->_helper->flashMessenger('There was an error on the form. Please try again.', 'error');
                    return;
                }
                try {
                    // delete
                    if ($action == 'delete') {
                        $federation_photo->delete();
                        $this->_helper->flashMessenger("The federation photo '" . $federation_photo->title . "' has been deleted.", 'success');
                    } else if ($action == 'add') {
                        $federation_photo->setPostData($_POST);
                        if ($federation_photo->save()) {
                            // do file upload
                            $this->upload_file($federation_photo);
                            $this->_helper->flashMessenger("The federation photo '" . $federation_photo->title . "' has been added.", 'success');
                        }
                    } else if ($action == 'edit') {
                        // get the original so that we can use old information which doesn't persist well (e.g. files)
                        $originalRecord = SuperEightFestivalsFederationPhoto::get_by_id($federation_photo->id);
                        // set the data of the record according to what was submitted in the form
                        $federation_photo->setPostData($_POST);
                        // if there is no pending upload, use the old files
                        if (!has_temporary_file('file')) {
                            $federation_photo->file_name = $originalRecord->file_name;
                            $federation_photo->thumbnail_file_name = $originalRecord->thumbnail_file_name;
                        } else {
                            // temporarily set file name to uploaded file name
                            $federation_photo->file_name = get_temporary_file("file")[0];
                        }
                        if ($federation_photo->save()) {
                            // only change files if there is a file waiting
                            if (has_temporary_file('file')) {
                                // delete old files
                                $originalRecord->delete_files();
                                // do file upload
                                $this->upload_file($federation_photo);
                            }
                            // display result dialog
                            $this->_helper->flashMessenger("The federation photo '" . $federation_photo->title . "' has been edited.", 'success');
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

    private function upload_file(SuperEightFestivalsFederationPhoto $federation_photo)
    {
        list($original_name, $temporary_name, $extension) = get_temporary_file("file");
        $newFileName = uniqid($federation_photo->get_internal_prefix() . "_") . "." . $extension;
        move_tempfile_to_dir($temporary_name, $newFileName, get_uploads_dir());
        $federation_photo->file_name = $newFileName;
        $federation_photo->create_thumbnail();
        $federation_photo->save();
    }

}
