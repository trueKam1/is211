<?php
namespace Services;

use Interfaces\FileStorageInterface;
use Services\DBStorage;
use PDO;

class OrderDBStorage extends DBStorage implements FileStorageInterface
{
    public function saveData($nameFile, $arr)
    {
        $sql = "INSERT INTO `order`
        (fio, address, phone, sum, created)
        VALUES (
            '{$arr['fio']}',
            '{$arr['address']}',
            '{$arr['phone']}',
            '{$arr['all_sum']}',
            '{$arr['created_at']}'
        )";     

        $this->connection->exec($sql);
        $last_id = $this->connection->lastInsertId();

        foreach($arr['products'] as $item) {
            $sql_item = "INSERT INTO `order_item`
            (order_id, product_id, count, price, sum)
            VALUES (
                '{$last_id}',
                '{$item['id']}',
                '{$item['quantity']}',
                '{$item['price']}',
                '{$item['sum']}'
            )";  
            $this->connection->exec($sql_item);
        }
    }
    public function loadData($nameFile): ?array
    {
        return NULL;
    }
}
