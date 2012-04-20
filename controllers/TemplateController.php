<?php

class KlearMatrix_TemplateController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        $this->_helper->layout->disableLayout();

    }


    public function listAction()
    {

    }



    public function editAction()
    {

    }

    public function newAction()
    {

    }

    public function paginatorAction()
    {

    }


    public function deleteAction()
    {

    }

    public function multilangAction() {

        if ($templateItem = $this->getRequest()->getParam("item")) {

            switch($templateItem) {
                case "list":
                case "field":
                    $this->_helper->viewRenderer('multilang/' . $templateItem);
                    break;

            }
        }


    }


    public function fieldAction()
    {
        if ($fieldType = $this->getRequest()->getParam("type")) {

            switch($fieldType) {
                case "text":
                case "textarea":
                case "select":
                case "multiselect":
                case "password":
                case "number":
                case "file":
                case "datepicker":
                    $this->_helper->viewRenderer('fields/' . $fieldType);
                    break;

            }
        }


    }

}