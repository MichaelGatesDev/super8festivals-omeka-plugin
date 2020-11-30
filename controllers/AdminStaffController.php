<?php

class SuperEightFestivals_AdminStaffController extends Omeka_Controller_AbstractActionController
{
    public function indexAction()
    {
    }

    public function singleAction()
    {
        $request = $this->getRequest();

        $staffID = $request->getParam('staff');
        $staff = SuperEightFestivalsStaff::get_by_id($staffID);
        $this->view->staff = $staff;
    }
}
