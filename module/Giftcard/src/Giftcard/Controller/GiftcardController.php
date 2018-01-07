<?php

namespace Giftcard\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Giftcard\Form\GiftcardForm;
use Giftcard\Model\Giftcard;
use Giftcard\Model\GiftcardTable;

class GiftcardController extends AbstractActionController
{
    protected $giftcardTable;

    public function getGiftcardTable()
    {
        if (!$this->giftcardTable) {
            $sm = $this->getServiceLocator();
            $this->giftcardTable = $sm->get('Giftcard\Model\GiftcardTable');
        }
        return $this->giftcardTable;
    }


    public function indexAction()
    {
        return new ViewModel(array(
            'giftcards' => $this->getGiftcardTable()->fetchAll(),
            'name' => 'Hello',
        ));
    }

    public function addAction()
    {
        $form = new GiftcardForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {


            $giftcard = new Giftcard();

            $form->setInputFilter($giftcard->getInputFilter());

            $form->setData($request->getPost());

            if ($form->isValid()) {

                $giftcard->exchangeArray($form->getData());
                $this->getGiftcardTable()->saveGiftcard($giftcard);

                // Redirect to list of giftcards
                return $this->redirect()->toRoute('giftcard');
            }
        }
        return array('form' => $form);
    }

    public function editAction()
    {

        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('giftcard', array(
                'action' => 'add'
            ));
        }

        // Get the Giftcard with the specified id.  An exception is thrown
        // if it cannot be found, in which case go to the index page.

        try {
            $giftcard = $this->getGiftcardTable()->getGiftcard($id);
        }
        catch (\Exception $ex) {
            return $this->redirect()->toRoute('giftcard', array(
                'action' => 'index'
            ));
        }

        $form  = new GiftcardForm();
        $form->bind($giftcard);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($giftcard->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getGiftcardTable()->saveGiftcard($giftcard);

                // Redirect to list of giftcards
                return $this->redirect()->toRoute('giftcard');
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
            return $this->redirect()->toRoute('giftcard');
        }

        $request = $this->getRequest();

        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getGiftcardTable()->deleteGiftcard($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('giftcard');
        }

        return array(
            'id'    => $id,
            'giftcard' => $this->getGiftcardTable()->getGiftcard($id)
        );
    }
}