<?php

namespace AlbumImage\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use AlbumImage\Model\AlbumImage;          // <-- Add this import
use AlbumImage\Form\AlbumImageForm;       // <-- Add this import

class AlbumImageController  extends AbstractActionController
{

    protected $album_imageTable;

    public function getAlbumImageTable()
    {
        if (!$this->album_imageTable) {
            $sm = $this->getServiceLocator();
            $this->album_imageTable = $sm->get('AlbumImage\Model\AlbumImageTable');
        }
        return $this->album_imageTable;
    }

    public function indexAction()
    {
        return new ViewModel(array(
            'album_images' => $this->getAlbumImageTable()->fetchAll(),
            'name' => 'Hello',
        ));
    }

    //Add Action
    public function addAction()
    {
        $form = new AlbumImageForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $album_image = new AlbumImage();
            $form->setInputFilter($album_image->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $album_image->exchangeArray($form->getData());
                $this->getAlbumImageTable()->saveAlbumImage($album_image);

                // Redirect to list of album_images
                return $this->redirect()->toRoute('album_image');
            }
        }
        return array('form' => $form);
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('album_image', array(
                'action' => 'add'
            ));
        }

        // Get the AlbumImage with the specified id.  An exception is thrown
        // if it cannot be found, in which case go to the index page.
        try {
            $album_image = $this->getAlbumImageTable()->getAlbumImage($id);
        }
        catch (\Exception $ex) {
            return $this->redirect()->toRoute('album_image', array(
                'action' => 'index'
            ));
        }

        $form  = new AlbumImageForm();
        $form->bind($album_image);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($album_image->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getAlbumImageTable()->saveAlbumImage($album_image);

                // Redirect to list of album_images
                return $this->redirect()->toRoute('album_image');
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
            return $this->redirect()->toRoute('album_image');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getAlbumImageTable()->deleteAlbumImage($id);
            }

            // Redirect to list of album_images
            return $this->redirect()->toRoute('album_image');
        }

        return array(
            'id'    => $id,
            'album_image' => $this->getAlbumImageTable()->getAlbumImage($id)
        );
    }
}