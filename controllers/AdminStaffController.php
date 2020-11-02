<?php

class SuperEightFestivals_AdminStaffController extends Omeka_Controller_AbstractActionController
{
    public function init()
    {
        // Set the model class so this controller can perform some functions,
        // such as $this->findById()
        $this->_helper->db->setDefaultModelName('SuperEightFestivalsStaff');
    }

    public function indexAction()
    {
    }

    public function addAction()
    {
        // Create new staff
        $staff = new SuperEightFestivalsStaff();
        $form = $this->_getForm($staff);
        $this->view->form = $form;
        $this->_processForm($staff, $form, 'add');
    }

    public function editAction()
    {
        $request = $this->getRequest();

        $staffID = $request->getParam('staffID');
        $staff = SuperEightFestivalsStaff::get_by_id($staffID);
        $form = $this->_getForm($staff);
        $this->view->form = $form;
        $this->_processForm($staff, $form, 'edit');
    }

    public function deleteAction()
    {
        $request = $this->getRequest();

        $staffID = $request->getParam('staffID');
        $staff = SuperEightFestivalsStaff::get_by_id($staffID);
        $this->view->staff = $staff;

        $form = $this->_getDeleteForm();
        $this->view->form = $form;
        $this->_processForm($staff, $form, 'delete');
    }

    protected function _getForm(SuperEightFestivalsStaff $staff = null)
    {
        $formOptions = array(
            'type' => 'super_eight_festivals_staff'
        );

        $form = new Omeka_Form_Admin($formOptions);

        $form->addElementToEditGroup(
            'text', 'email',
            array(
                'id' => 'email',
                'label' => 'Email',
                'description' => "The staff's email",
                'value' => $staff->email,
                'required' => false
            )
        );

        $form->addElementToEditGroup(
            'text', 'first_name',
            array(
                'id' => 'first_name',
                'label' => 'First Name',
                'description' => "The staff's first name",
                'value' => $staff->first_name,
                'required' => false
            )
        );

        $form->addElementToEditGroup(
            'text', 'last_name',
            array(
                'id' => 'last_name',
                'label' => 'Last Name',
                'description' => "The staff's last name",
                'value' => $staff->last_name,
                'required' => false
            )
        );

        $form->addElementToEditGroup(
            'text', 'organization_name',
            array(
                'id' => 'organization_name',
                'label' => 'Organization Name',
                'description' => "The name of the staff's organization",
                'value' => $staff->organization_name,
                'required' => false
            )
        );

        $form->addElementToEditGroup(
            'text', 'role',
            array(
                'id' => 'role',
                'label' => 'Role',
                'description' => "The role of the staff member",
                'value' => $staff->role,
                'required' => false
            )
        );

        $form->addElementToEditGroup(
            'file', 'file',
            array(
                'id' => 'file',
                'label' => 'File',
                'description' => "The image file",
                'accept' => get_form_accept_string(get_image_types()),
            )
        );

        return $form;
    }

    private function _processForm(SuperEightFestivalsStaff $staff, Zend_Form $form, $action)
    {
        $this->view->staff = $staff;

        if ($this->getRequest()->isPost()) {
            try {
                if (!$form->isValid($_POST)) {
                    $this->_helper->flashMessenger('There was an error on the form. Please try again.', 'error');
                    return;
                }
                try {
                    // delete
                    if ($action == 'delete') {
                        $staff->delete();
                        $this->_helper->flashMessenger("The staff has been deleted.", 'success');
                    } //add
                    else if ($action == 'add') {
                        $staff->setPostData($_POST);
                        if ($staff->save()) {
                            // do file upload
                            $this->upload_file($staff);
                            $this->_helper->flashMessenger("The staff has been added.", 'success');
                        }
                    } //edit
                    else if ($action == 'edit') {
                        // get the original so that we can use old information which doesn't persist well (e.g. files)
                        $originalRecord = SuperEightFestivalsStaff::get_by_id($staff->id);
                        // set the data of the record according to what was submitted in the form
                        $staff->setPostData($_POST);
                        // if there is no pending upload, use the old files
                        if (!has_temporary_file('file')) {
                            $staff->file_name = $originalRecord->file_name;
                            $staff->thumbnail_file_name = $originalRecord->thumbnail_file_name;
                        } else {
                            // temporarily set staff file name to uploaded file name
                            $staff->file_name = get_temporary_file("file")[0];
                        }
                        if ($staff->save()) {
                            // only change files if there is a file waiting
                            if (has_temporary_file('file')) {
                                // delete old files
                                if ($originalRecord != null) {
                                    $originalRecord->delete_files();
                                }
                                // do file upload
                                $this->upload_file($staff);
                            }
                            // display result dialog
                            $this->_helper->flashMessenger("The staff has been edited.", 'success');
                        }
                    }


                    $this->redirect("/super-eight-festivals/staff");
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

    private function upload_file(SuperEightFestivalsStaff $staff)
    {
        if (!has_temporary_file("file")) return;

        list($original_name, $temporary_name, $extension) = get_temporary_file("file");
        $newFileName = uniqid() . "." . $extension;
        move_tempfile_to_dir($temporary_name, $newFileName, get_uploads_dir());
        $staff->file_name = $newFileName;
        $staff->create_thumbnail();
        $staff->save();
    }

}
