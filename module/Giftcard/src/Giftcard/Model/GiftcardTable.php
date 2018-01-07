<?php
namespace Giftcard\Model;

use Zend\Db\TableGateway\TableGateway;

class GiftcardTable{

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function saveGiftcard(Giftcard $giftcard)
    {

        $data = array(
            'name' => $giftcard->name,
            'price'  => $giftcard->price,
        );

        $id = (int) $giftcard->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getGiftcard($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Giftcard id does not exist');
            }
        }
    }

    //Used while update need to fetch the Giftcard with that id
    public function getGiftcard($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    //delete gift card
    public function deleteGiftcard($id){
        $this->tableGateway->delete(array('id' => (int) $id));
    }
}