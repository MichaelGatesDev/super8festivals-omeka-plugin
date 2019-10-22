<?php

class SuperEightFestivals_CountriesController extends Omeka_Controller_AbstractActionController
{
    /**
     * @var DatabaseHelper|null
     */
    private $databaseHelper = null;

    public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
    {
        parent::__construct($request, $response, $invokeArgs);
        $this->databaseHelper = new DatabaseHelper(new DatabaseManager());
    }


    public function indexAction()
    {
        return;
    }

    public function addAction()
    {
        // Create new country
        $country = new Super8FestivalsCountry();
        $form = $this->_getForm();
        $this->view->form = $form;
        $this->processCountryForm($country, $form, 'add');
        return;
    }

    public function browseAction()
    {
        $this->view->assign('databaseHelper', $this->databaseHelper);
        return;
    }

    protected function _getForm()
    {
        $form = new Omeka_Form_Admin(array('type' => 'super8festivals_country'));

        $form->addElementToEditGroup(
            'text', 'country_name',
            array(
                'id' => 'super8festivals-country-name',
                'label' => 'Country Name',
                'description' => "The name of the country (required)",
                'required' => true
            )
        );
        $form->addElementToEditGroup(
            'text', 'country_latitude',
            array(
                'id' => 'super8festivals-country-latitude',
                'label' => 'Country Latitude',
                'description' => "The latitudinal position of the capital or center of mass (required)",
                'required' => true
            )
        );

        $form->addElementToEditGroup(
            'text', 'country_longitude',
            array(
                'id' => 'super8festivals-country-longitude',
                'label' => 'Country Longitude',
                'description' => "The longitudinal position of the capital or center of mass (required)",
                'required' => true
            )
        );

        return $form;
    }

    /**
     * @param $country Super8FestivalsCountry
     * @param $form Omeka_Form
     * @param $action
     */
    private function processCountryForm($country, $form, $action)
    {
        // Set the page object to the view.
        $this->view->super8festivalsCountry = $country;

//        echo json_encode($_POST);

        if ($this->getRequest()->isPost()) {
            try {
                if (!$form->isValid($_POST)) {
                    $this->_helper->flashMessenger('There was an error on the form. Please try again.', 'error');
                    return;
                }
            } catch (Zend_Form_Exception $e) {
                echo $e;
                $this->_helper->flashMessenger($e);
            }
            try {
                $country->setPostData($_POST);
                if ($country->save()) {
                    if ($action == 'add') {
                        $this->_helper->flashMessenger(__('The country "%s" has been added.', $country->name), 'success');
                    } else if ($action == 'edit') {
                        $this->_helper->flashMessenger(__('The country "%s" has been edited.', $country->name), 'success');
                    }
                    $this->_helper->redirector('index');
                    return;
                }
                // Catch validation errors.
            } catch (Omeka_Validate_Exception $e) {
                $this->_helper->flashMessenger($e);
                echo $e;
            } catch (Omeka_Record_Exception $e) {
                $this->_helper->flashMessenger($e);
                echo $e;
            }
        }
    }

}
