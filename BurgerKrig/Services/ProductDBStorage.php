<?php
namespace Services;

use Interfaces\FileStorageInterface;
use Services\DBStorage;
use PDO;

class ProductDBStorage extends DBStorage implements FileStorageInterface 
{
    public function saveData($nameFile, $arr)
    {

    }
    public function loadData($nameFile): ?array
    {
        $sql = "SELECT * FROM product";
        $result = $this->connection->query($sql);
        $row = $result->fetchAll();
        return $row;
    }
}
