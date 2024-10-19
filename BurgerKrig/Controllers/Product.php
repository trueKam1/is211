<?php
namespace Controllers;

use Services\FileStorage;
use Services\ProductDBStorage;
use Templates\ProductTemplate;

class Product {
    public function get(int $id): string 
    {
        $objStorage = new FileStorage();
        $products = $objStorage->loadData('data.json');

        foreach ($products as $product) {
            if ($product['id'] == $id) {
                $objTemplate = new ProductTemplate();
                $template = $objTemplate->getPageTemplate( $product );
                return $template;
            }
        }

        /*$code = 404;  
        $text = 'Not Found';  
        $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
        header($protocol . ' ' . $code . ' ' . $text);*/
        return '404';
    }
    public function getAll(): string
    {
        $objStorage = new FileStorage();
        $products = $objStorage->loadData('data.json');
        
        //$objStorage = new ProductDBStorage();
        //$products = $objStorage->loadData('product');

        $objTemplate = new ProductTemplate();
        $template = $objTemplate->getTemplate( $products );

        return $template;
    }

}