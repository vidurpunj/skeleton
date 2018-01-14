<?php

namespace AlbumImage\Form;

use Zend\Form\Form;

class AlbumImageForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('album_image');

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));
        $this->add(array(
            'name' => 'album_id',
            'type' => 'Text',
            'options' => array(
                'label' => 'Album Id',
            ),
        ));

//        $this->add(array(
//            'type' => 'Zend\Form\Element\Select',
//            'name' => 'number',
//            'options' => array(
//                'label' => 'Select an Album',
//                'empty_option' => 'Please select an author',
//
//                'options' => array('1' => 'one', '2' => 'Two', '3' => 'two', '4' => 'Four'))
//        ));

        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        ));
    }
}