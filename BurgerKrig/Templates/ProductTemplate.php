<?php
namespace Templates;

use Templates\BaseTemplate;

class ProductTemplate extends BaseTemplate {
    public function getTemplate(array $arr): string 
    {
        $template = parent::getBaseTemplate();
        $str= '';
        // Добавим flash сообщение
        session_start();
        if (isset($_SESSION['flash'])) {
            $str .= <<<END
                <div id="liveAlertBtn" class="alert alert-success alert-dismissible" role="alert">
                    <div>{$_SESSION['flash']}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                    onclick="this.parentNode.style.display='none';"></button>
                </div>
                <script>

                        setTimeout(
                            function() {
                              var elem = document.getElementById("liveAlertBtn");
                              elem.style.display = "none";
                            }, 3000
                          );

                </script>
            END;
            unset($_SESSION['flash']);
        }
        $str .= <<<END
            <div class="row Rowcardsets">
        END;

        // для каждого товара
        foreach( $arr as $key => $item ) {

            $element_template= <<<END
            <div class="col">
                <div class="card bg-secondary cardsets" style="width: 18rem;">
                    <img src="%s" alt="...">
                    <div class="card-body ">
                        <h5 class="card-title">%s</h5>
                        <p class="card-text">%s</p>
                        <p class="card-text">%d ₽</p>
                        <form action="/basket" method="POST">
                          <input type="hidden" name="id" value="%s">
                          <button type="submit" class="btn btn-primary mt-3">Добавить в корзину</button>
                        </form>
                    </div>
                </div>
            </div>
            END;
            $str.= sprintf(
                $element_template, 
                'https://localhost/'.$item['image'],
                $item['name'],
                $item['description'],
                $item['price'],
                $item['id']
            );
        }
        $resultTemplate = sprintf($template, 'Каталог продукции', $str);
        return $resultTemplate;
    }

    public function getPageTemplate(array $arr): string 
    {
        $template = parent::getBaseTemplate();

        $element_template= <<<END
        <div class="row mb-5">
            <div class="col-6">
                <img src="%s" class="w-100">
            </div>
            <div class="col-6">
                <div class="block">
                    <h2>%s</h2>
                    <p>%s</p>
                    <p>%s</p>
                    <h2>%d ₽</h2>
                    <form action="/basket" method="POST">
                      <input type="hidden" name="id" value="%s">
                      <button type="submit" class="btn btn-primary mt-3">Добавить в корзину</button>
                    </form>
                </div>
            </div>
        </div>
        END;

        $str= sprintf(
            $element_template, 
            'https://localhost/'.$arr['image'],
            $arr['name'],
            $arr['description'],
            $arr['weigth'],
            $arr['price'],
            $arr['id']
        );      

        $resultTemplate =  sprintf($template, 'Страница товара', $str);
        return $resultTemplate;
    }
}