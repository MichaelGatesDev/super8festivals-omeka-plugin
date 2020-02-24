<?php

class SuperEightFestivals_FestivalsController extends Omeka_Controller_AbstractActionController
{

    public function init()
    {
        // Set the model class so this controller can perform some functions,
        // such as $this->findById()
        $this->_helper->db->setDefaultModelName('SuperEightFestivalsFestival');
    }

    public function indexAction()
    {
        $this->_helper->redirector('browse');
        return;
    }

    public function addAction()
    {
        // Create new festival
        $festival = new SuperEightFestivalsFestival();
        $form = $this->_getForm($festival);
        $this->view->form = $form;
        $this->view->festival = $festival;
        $this->_processForm($festival, $form, 'add');
    }

    public function editAction()
    {
        $festival = $this->_helper->db->findById();
        $form = $this->_getForm($festival);
        $this->view->form = $form;
        $this->view->festival = $festival;
        $this->_processForm($festival, $form, 'edit');
    }

    public function viewAction()
    {
        $festival = $this->_helper->db->findById();
        $this->view->festival = $festival;
    }

    protected function _getForm(SuperEightFestivalsFestival $festival = null): Omeka_Form_Admin
    {
        $formOptions = array(
            'type' => 'super_eight_festivals_festival'
        );

        $form = new Omeka_Form_Admin($formOptions);

        $form->addElementToEditGroup(
            'select', 'city_id',
            array(
                'id' => 'city_id',
                'label' => 'City',
                'description' => "The city in which the festival was held (required)",
                'multiOptions' => get_parent_city_options(),
                'value' => $festival->city_id,
                'required' => true,
            )
        );

        $form->addElementToEditGroup(
            'text', 'year',
            array(
                'id' => 'year',
                'label' => 'Year',
                'description' => "The year in which the festival occurred (required)",
                'value' => $festival->year,
                'required' => true
            )
        );

        $form->addElementToEditGroup(
            'text', 'title',
            array(
                'id' => 'title',
                'label' => 'Title',
                'description' => "The title of the festival",
                'value' => $festival->title,
                'required' => false
            )
        );

        $form->addElementToEditGroup(
            'text', 'description',
            array(
                'id' => 'description',
                'label' => 'Description',
                'description' => "The description of the festival",
                'value' => $festival->description,
                'required' => false
            )
        );

        return $form;
    }

    /**
     * @param $festival SuperEightFestivalsFestival
     * @param $form Omeka_Form
     * @param $action
     */
    private function _processForm($festival, $form, $action)
    {
        // Set the page object to the view.
        $this->view->super_eight_festivals_festival = $festival;

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
                $festival->setPostData($_POST);

                if ($festival->save()) {
                    if ($action == 'add') {
                        $this->_helper->flashMessenger(__('The festival "%s" has been added.', $festival->year . " " . $festival->title), 'success');
                    } else if ($action == 'edit') {
                        $this->_helper->flashMessenger(__('The festival "%s" has been edited.', $festival->year . " " . $festival->title), 'success');
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
