<?php
namespace Templates;

use Templates\BaseTemplate;

class HomeTemplate extends BaseTemplate {
    public function getHomeTemplate(): string 
    {
        $template = parent::getBaseTemplate();
        $str = '';
        // Добавим flash сообщение
        session_start();
        if (isset($_SESSION['flash'])) {
            $str .= <<<END
                <div id="liveAlertBtn" class="alert alert-info alert-dismissible" role="alert">
                    <div>{$_SESSION['flash']}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                    onclick="this.parentNode.style.display='none';"></button>
                </div>
            END;
            unset($_SESSION['flash']);
        }
        $str .= <<<END
        <div>
          <img src="img/premium_photo-1708110921381-5da0d7eb2e0f.avif" class="d-block w-40" alt="...">
        </div>
        <div>
          
        </div>
        <div class="coleser">
          <div class="card" style="width: 20rem;">
            <img src="img/itemPlaseholder.png" class="card-img-top" alt="...">
            <div class="card-body">
              <p class="card-text">Some text</p>
            </div>
          </div>
          <div class="card" style="width: 20rem;">
            <img src="img/itemPlaseholder.png" class="card-img-top" alt="...">
            <div class="card-body">
              <p class="card-text">Some text</p>
            </div>
          </div>
          <div class="card" style="width: 20rem;">
            <img src="img/itemPlaseholder.png" class="card-img-top" alt="...">
            <div class="card-body">
              <p class="card-text">Some text</p>
            </div>
          </div>
        </div>
        END;
        $resultTemplate =  sprintf($template, 'Главная страница', $str);
        return $resultTemplate;
    }
}