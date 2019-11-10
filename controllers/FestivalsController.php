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
        $this->_processForm($festival, $form, 'add');
    }

    public function editAction()
    {
        $festival = $this->_helper->db->findById();
        $form = $this->_getForm($festival);
        $this->view->form = $form;
        $this->_processForm($festival, $form, 'edit');
    }

    /**
     * @param SuperEightFestivalsFestival|null $festival
     * @return Omeka_Form_Admin
     */
    protected function _getForm($festival = null)
    {
        $formOptions = array(
            'type' => 'super_eight_festivals_festival'
        );

        $form = new Omeka_Form_Admin($formOptions);

        $form->addElementToEditGroup(
            'select', 'city_id',
            array(
                'id' => 'city_id',
                'label' => 'City ID',
                'description' => "The ID of the city (required)",
                'multiOptions' => get_parent_city_options($festival->city_id),
                'value' => $festival->city_id,
                'required' => true,
            )
        );

        $form->addElementToEditGroup(
            'text', 'name',
            array(
                'id' => 'name',
                'label' => 'Festival',
                'description' => "The name of the festival (required)",
                'value' => $festival->name,
                'required' => true
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

        if (class_exists('Omeka_Form_Element_SessionCsrfToken')) {
            try {
                $form->addElement('sessionCsrfToken', 'csrf_token');
            } catch (Zend_Form_Exception $e) {
                echo $e;
            }
        }

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

                $festival->country_id = get_parent_country_id($festival->city_id);

                if ($festival->save()) {
                    if ($action == 'add') {
                        $this->_helper->flashMessenger(__('The festival "%s" has been added.', $festival->name), 'success');
                    } else if ($action == 'edit') {
                        $this->_helper->flashMessenger(__('The festival "%s" has been edited.', $festival->name), 'success');
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
