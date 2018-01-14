<?php

namespace AlbumImage\Model;

use Zend\Db\TableGateway\TableGateway;

class AlbumImageTable
{

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

    //Used while update need to fetch the Album with that id
    public function getAlbumImage($id)
    {
        $id = (int)$id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveAlbumImage(AlbumImage $album_image)
    {
        $data = array(
            'album_id' => $album_image->album_id,
        );

        $id = (int)$album_image->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getAlbumImage($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('AlbumImage id does not exist');
            }
        }
    }

    public function deleteAlbumImage($id)
    {
        $this->tableGateway->delete(array('id' => (int)$id));
    }
}