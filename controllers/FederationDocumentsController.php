<?php

class SuperEightFestivals_FederationDocumentsController extends Omeka_Controller_AbstractActionController
{
    public function init()
    {
        // Set the model class so this controller can perform some functions,
        // such as $this->findById()
        $this->_helper->db->setDefaultModelName('SuperEightFestivalsFederationDocument');
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

        $federation_document = new SuperEightFestivalsFederationDocument();
        $form = $this->_getForm($federation_document);
        $this->view->form = $form;
        $this->view->document = $federation_document;
        $this->_processForm($federation_document, $form, 'add');
    }

    public function editAction()
    {
        $request = $this->getRequest();

        $documentID = $request->getParam('documentID');
        $federation_document = get_federation_document_by_id($documentID);
        $this->view->federation_document = $federation_document;

        $form = $this->_getForm($federation_document);
        $this->view->form = $form;
        $this->_processForm($federation_document, $form, 'edit');
    }

    public function deleteAction()
    {
        $request = $this->getRequest();

        $documentID = $request->getParam('documentID');
        $federation_document = get_federation_document_by_id($documentID);
        $this->view->federation_document = $federation_document;

        $form = $this->_getDeleteForm();
        $this->view->form = $form;
        $this->_processForm($federation_document, $form, 'delete');
    }

    protected function _getForm(SuperEightFestivalsFederationDocument $federation_document = null): Omeka_Form_Admin
    {
        $formOptions = array(
            'type' => 'super_eight_festivals_federation_document'
        );

        $form = new Omeka_Form_Admin($formOptions);

        $form->addElementToEditGroup(
            'select', 'contributor_id',
            array(
                'id' => 'contributor_id',
                'label' => 'Contributor',
                'description' => "The person who contributed the item",
                'multiOptions' => get_parent_contributor_options(),
                'value' => $federation_document->contributor_id,
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'text', 'title',
            array(
                'id' => 'title',
                'label' => 'Title',
                'description' => "The federation document's title",
                'value' => $federation_document->title,
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'text', 'description',
            array(
                'id' => 'description',
                'label' => 'Description',
                'description' => "The federation document's description",
                'value' => $federation_document->description,
                'required' => false,
            )
        );

        $form->addElementToEditGroup(
            'file', 'file',
            array(
                'id' => 'file',
                'label' => 'File',
                'description' => "The federation document file",
                'required' => $federation_document->file_name == "" || !file_exists($federation_document->get_path()),
            )
        );

        $form->addElementToEditGroup(
            'text', 'file_url_web',
            array(
                'id' => 'file_url_web',
                'label' => 'URL',
                'description' => "The URL (link) to the record",
                'value' => $federation_document->file_url_web,
                'required' => false,
            )
        );

//        $form->addElementToEditGroup(
//            'textarea', 'embed',
//            array(
//                'id' => 'embed',
//                'label' => 'Embed Code',
//                'description' => "The federation document's embed code",
//                'value' => $federation_document->embed,
//                'required' => false,
//            )
//        );

        return $form;
    }

    private function _processForm(SuperEightFestivalsFederationDocument $federation_document, Zend_Form $form, $action)
    {
        $this->view->federation_document = $federation_document;

        if ($this->getRequest()->isPost()) {
            try {
                if (!$form->isValid($_POST)) {
                    $this->_helper->flashMessenger('There was an error on the form. Please try again.', 'error');
                    return;
                }

                try {
                    if ($action == 'delete') {
                        $federation_document->delete();
                        $this->_helper->flashMessenger("The federation document '" . $federation_document->title . "' has been deleted.", 'success');
                    } else if ($action == 'add') {
                        $federation_document->setPostData($_POST);
                        if ($federation_document->save()) {
                            $this->_helper->flashMessenger("The federation document '" . $federation_document->title . "' has been added.", 'success');

                            // do file upload
                            $this->upload_file($federation_document);
                        }
                    } else if ($action == 'edit') {
                        // get the original so that we can use old information which doesn't persist well (e.g. files)
                        $originalRecord = get_federation_document_by_id($federation_document->id);
                        // set the data of the record according to what was submitted in the form
                        $federation_document->setPostData($_POST);
                        // if there is no pending upload, use the old files
                        if (!has_temporary_file('file')) {
                            $federation_document->file_name = $originalRecord->file_name;
                            $federation_document->thumbnail_file_name = $originalRecord->thumbnail_file_name;
                        }
                        if ($federation_document->save()) {
                            // display result dialog
                            $this->_helper->flashMessenger("The federation document '" . $federation_document->title . "' has been edited.", 'success');

                            // only change files if there is a file waiting
                            if (has_temporary_file('file')) {
                                // delete old files
                                $originalRecord->delete_files();
                                // do file upload
                                $this->upload_file($federation_document);
                            }
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

    private function upload_file(SuperEightFestivalsFederationDocument $federation_document)
    {
        list($original_name, $temporary_name, $extension) = get_temporary_file("file");
        $newFileName = uniqid($federation_document->get_internal_prefix() . "_") . "." . $extension;
        move_to_dir($temporary_name, $newFileName, $federation_document->get_dir());
        $federation_document->file_name = $newFileName;
        $federation_document->save();
    }

}
