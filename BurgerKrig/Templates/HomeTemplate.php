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
          <img src="img/red_1.avif" class="d-block w-40" alt="...">
        </div>
          <div class="infoCardPlace">
          <h1>Чёрный - стиль</h1>
          <h1 class="infoCardPlaceMarging">Белый - фальшь</h1>
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
        <div class="aboutAScard">
          <h1>ABOUT AS</h1>
          <h3 class="aboutAScardText">
            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Impedit, earum quis perspiciatis necessitatibus voluptatem minima sed. Corporis vero ex laboriosam maiores omnis quo aperiam saepe libero, exercitationem adipisci sed voluptatibus voluptate aspernatur eligendi mollitia dicta esse reiciendis quaerat impedit! Similique, harum consequatur! Reiciendis libero perferendis accusamus aspernatur incidunt ad voluptatum dolor! Ipsam repellat maiores suscipit, sunt delectus cupiditate quo. Recusandae culpa similique necessitatibus voluptatibus quas possimus, dolore odio veritatis quo aperiam asperiores totam ex, sed repellendus inventore ea! Culpa, id.
          </h3>
        </div>
        END;
        $resultTemplate =  sprintf($template, 'Главная страница', $str);
        return $resultTemplate;
    }
}