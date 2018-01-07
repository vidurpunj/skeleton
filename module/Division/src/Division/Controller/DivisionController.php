<?php
namespace Division\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Division\Form\DivisionForm;
use Division\Model\Division;
use Division\Model\DivisionTable;

class DivisionController extends AbstractActionController
{

    protected $divisionTable;

    public function getDivisionTable()
    {
        if (!$this->divisionTable) {
            $sm = $this->getServiceLocator();
            $this->divisionTable = $sm->get('Division\Model\DivisionTable');
        }
        return $this->divisionTable;
    }

    public function indexAction()
    {
        return new ViewModel(array(
            'divisions' => $this->getDivisionTable()->fetchAll(),
            'name' => 'Hello',
        ));
    }

    //Add Action
    public function addAction()
    {

        $form = new DivisionForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $division = new Division();
            $form->setInputFilter($division->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $division->exchangeArray($form->getData());
                $this->getDivisionTable()->saveDivision($division);

                // Redirect to list of divisions
                return $this->redirect()->toRoute('division');
            }
        }
        return array('form' => $form);
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('division', array(
                'action' => 'add'
            ));
        }

        // Get the Division with the specified id.  An exception is thrown
        // if it cannot be found, in which case go to the index page.
        try {
            $division = $this->getDivisionTable()->getDivision($id);
        }
        catch (\Exception $ex) {
            return $this->redirect()->toRoute('division', array(
                'action' => 'index'
            ));
        }

        $form  = new DivisionForm();
        $form->bind($division);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($division->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getDivisionTable()->saveDivision($division);

                // Redirect to list of divisions
                return $this->redirect()->toRoute('division');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('division');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getDivisionTable()->deleteDivision($id);
            }

            // Redirect to list of divisions
            return $this->redirect()->toRoute('division');
        }

        return array(
            'id'    => $id,
            'division' => $this->getDivisionTable()->getDivision($id)
        );
    }
}