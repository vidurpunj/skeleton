<?php
namespace Division\Model;

use Zend\Db\TableGateway\TableGateway;

class DivisionTable
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

    public function saveDivision(Division $division)
    {
        $data = array(
            'name' => $division->name,
            'content'  => $division->content,
            'url'  => $division->url,
        );

        $id = (int) $division->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getDivision($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Division id does not exist');
            }
        }
    }

    //Used while update need to fetch the Division with that id
    public function getDivision($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }
    public function deleteDivision($id)
    {

        $this->tableGateway->delete(array('id' => (int) $id));
    }
}