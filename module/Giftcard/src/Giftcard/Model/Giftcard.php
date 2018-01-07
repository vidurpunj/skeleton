<?php
namespace Giftcard\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Giftcard
{
    public $id;
    public $name;
    public $price;

    // For the index action
    public function exchangeArray($data)
    {
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->name = (!empty($data['name'])) ? $data['name'] : null;
        $this->price = (!empty($data['price'])) ? $data['price'] : null;
    }

    // Add the following method:
    //For the edit Action
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function getInputFilter()
     {
         if (!$this->inputFilter) {
             $inputFilter = new InputFilter();

             $inputFilter->add(array(
                 'name' => 'id',
                 'required' => true,
                 'filters' => array(
                     array('name' => 'Int'),
                 ),
             ));

             $inputFilter->add(array(
                 'name' => 'name',
                 'required' => true,
                 'filters' => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name' => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min' => 1,
                             'max' => 100,
                         ),
                     ),
                 ),
             ));

             $inputFilter->add(array(
                 'name' => 'price',
                 'required' => true,
                 'filters' => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name' => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min' => 1,
                             'max' => 100,
                         ),
                     ),
                 ),
             ));

             $this->inputFilter = $inputFilter;
         }

         return $this->inputFilter;
     }
}