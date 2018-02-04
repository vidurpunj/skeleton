<?php

namespace AlbumImage\Model;

use Zend\Db\TableGateway\TableGateway;

use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\ResultSet;

use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;


class AlbumImageTable
{

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {

      $db = $this->tableGateway->getAdapter();
      $sql = new Sql($db);
      $columns = array('id', 'name');
      $select = $sql->select();
      $select->from('album_images');
      $select->join('album','album_images.album_id = album.id',array());
      $statement = $sql->prepareStatementForSqlObject($select);
      $result = $statement->execute();
      $resultSet = new ResultSet;
      $resultSet->initialize($result);
      //  print_r($resultSet);
      //  exit();
       return $resultSet;

        // $resultSet = $this->tableGateway->select();
        // return $resultSet;

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

    public function getAlbumsList()
    {
        $db = $this->tableGateway->getAdapter();
        $sql = new Sql($db);
        $columns = array('id', 'title');
        $select = $sql->select();

        $select->from('album')->columns($columns);
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        $resultSet = new ResultSet;
        $resultSet->initialize($result);

         return $resultSet;

        //        echo "<pre>";
//        print_r($resultSet->toArray());
//        exit();


//        echo "<pre>";
//        print_r($resultSet->toArray());
//        exit();
    }


}
