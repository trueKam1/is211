<?php
namespace Controllers;

use Services\FileStorage;
use Templates\OrderTemplate;
use Services\OrderDBStorage;
use Services\ProductDBStorage;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Order {

    public function sendMail($email) {
        $mail = new PHPMailer();

        if (isset($email) && !empty($email)) {
            try {
                $mail->SMTPDebug = 2;
                $mail->CharSet = 'UTF-8';
                $mail->SetFrom("v.milevskiy@coopteh.ru","Burger krig");
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'ssl://smtp.mail.ru';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'v.milevskiy@coopteh.ru';                     //SMTP username
                $mail->Password   = 'hF8xTWxXyKcCnEg1n9Wz';
                $mail->Subject = 'Заявка с сайта: Burger Krig';
                $mail->Port       = 465;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Body = 'Информационное сообщение c сайта Burger Krig <br><br>
                ------------------------------------------<br>
                <br>
                Спасибо!<br>
                <br>
                Ваш заказ успешно создан и передан службе доставки.<br>
                <br>
                Сообщение сгенерировано автоматически.';       
    
                if ($mail->send()) {
                    return true;
                } else {
                    throw new Exception('Ошибка с отправкой письма');
                }
            } catch (Exception $error) {
                $message =  $error->getMessage();
            }
        }    
        return false;
    }
    public function create(): string 
    {
        $objStorage = new FileStorage();
        //$orderStorage = new OrderDBStorage();
        //$productStorage = new ProductDBStorage();

        $arr = [];
        $arr['fio'] = urldecode( $_POST['fio'] );
        $arr['email'] = $_POST['email'];
        $arr['address'] = urldecode( $_POST['address'] );
        $arr['phone'] = $_POST['phone'];
        $arr['created_at'] = date("Y-m-d H:i:s");

        $products = $objStorage->loadData('data.json');
        //$products = $productStorage->loadData('product');
        session_start();
        $all_sum = 0;
        $items = [];
        foreach ($products as $product) {
            $id = $product['id'];
            if (array_key_exists($id, $_SESSION['basket'])) {
                $item = [];
                $item['id'] = $id;
                $item['name'] = urldecode( $product['name'] );
                $item['quantity'] = $_SESSION['basket'][$id]['quantity'];                
                $item['price'] = $product['price'];
                $item['sum'] = $item['price'] * $item['quantity'];
                $all_sum += $item['sum'];
                array_push($items, $item);
            }
        }
        $arr['all_sum'] = $all_sum;
        $arr['products'] = $items;

        $objStorage->saveData('orders.json', $arr);
        //$orderStorage->saveData('order', $arr);

        // отправка емайл
        $this->sendMail($_POST['email']);

        $_SESSION['flash'] = "Спасибо! Ваш заказ успешно создан и передан службе доставки";
        $_SESSION['basket'] = [];
        header('Location: /');

        return '';
    }

    public function get(): string
    {
        session_start();

        if (!isset($_SESSION['basket'])) {
            $_SESSION['basket'] = [];
        }

        $objStorage = new FileStorage();
        $products = $objStorage->loadData('data.json');

        $all_sum = 0;
        $str_list = '<h1 class="mb-5">Создание заказа</h1>';
        $str_list .= '<h3>Корзина</h3>';

        foreach ($products as $product) {
            $id = $product['id'];
            if (array_key_exists($id, $_SESSION['basket'])) {
                $quantity = $_SESSION['basket'][$id]['quantity'];
                $name = $product['name'];
                $price = $product['price'];

                $sum = $price * $quantity;
                $all_sum += $sum;
                $str_list .= <<<LINE
                <div class="row">
                    <div class="col-6">
                    {$name}
                    </div>
                    <div class="col-2">
                    {$quantity} ед.
                    </div>
                    <div class="col-2">
                    {$sum} ₽
                    </div>
                </div>
                LINE;
            }
        }
        if ($all_sum === 0) {
            $str_list .= <<<LINE
                <div class="row">
                    <div class="col-12">
                    - нет добавленных товаров -
                    </div>
                </div>
                LINE;
        } else {
            $str_list .= <<<LINE
                <div class="row">
                    <div class="col-6">
                    <hr>
                    Общая сумма заказа:
                    </div>
                    <div class="col-2">
                    <hr>
                    &nbsp;
                    </div>
                    <div class="col-2">
                    <hr>
                    {$all_sum} ₽
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        &nbsp;
                    </div>
                    <div class="col-6 float-end">
                        <form action="/basket_clear" method="POST">
                        <button type="submit" class="btn btn-secondary mt-3">Очистить корзину</button>
                        </form>
                    </div>
                </div>                    
            LINE;
       
            // Форма ввода данных для доставки заказа
            $str_list .= <<<LINE
            <div class="row">
                <div class="col-8">
                    <form action="/orders" method="POST">
                        <label for="name">Ваше ФИО:</label>
                        <input type="text" id="name" class="form-control" name="fio" required>
                                    
                        <label for="adr">Адрес:</label>
                        <textarea id="adr" name="address" class="form-control" rows="2" required></textarea>
                        
                        <label for="phone">Телефон:</label>
                        <input type="text" id="phone" class="form-control" name="phone" required>
                        
                        <label for="email">Email:</label>
                        <input type="email" id="email" class="form-control" name="email" required>

                        <div class="float-end mb-5"><button type="submit" class="btn btn-primary mt-3">Создать заказ</button></div>
                    </form>
                </div>
            </div>
            LINE;
        }

        $objTemplate = new OrderTemplate();
        $template = $objTemplate->getTemplate( $str_list );

        return $template;
    }
}