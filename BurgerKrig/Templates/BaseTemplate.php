<?php
namespace Templates;

class BaseTemplate {  
    public function getBaseTemplate() {
        //21 строка не признаёт путь к файлу
        $template = <<<END
        <!DOCTYPE html>
        <html lang="ru">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>%s</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
            <link rel="stylesheet" href="css/styles.css">
            </head>
        <body>
            <header class="header">
                <a class="header-logo" href="/">
                <img class="header-logo-image" src="icons/logo.png" alt="Logo" width="135" height="25" loading="lazy"/></a>
                <nav class="header-menu">
                    <ul class="header-menu-list">
                        <li class="header-menu-item">
                            <a class="header-menu-link" href="/">Home</a>
                        </li>
                        <li class="header-menu-item">
                            <a class="header-menu-link" href="/">Pages</a>
                        </li>
                        <li class="header-menu-item">
                            <a class="header-menu-link" href="/">Portfolio</a>
                        </li>
                        <li class="header-menu-item">
                            <a class="header-menu-link" href="/products">Shop</a>
                        </li>
                        <li class="header-menu-item">
                            <a class="header-menu-link" href="/orders"><img class="header-menu-image" src="img/chopchop.png" alt="Cart" width="40" height="40" loading="lazy"/></a>
                        </li>
                    </ul>
                </nav>
            </header>
            %s
        </div>
        <div class="footer-extra">
            <div class="footer-extra-inner container">
                <div class="footer-copyright">
                    © <time datetime="2022">2022</time> OOO Dimas INC, All Rights Reserved
                </div>
            </div>
        </div>
        </footer>
        </body>
        </html>
        END;
        return $template;
    }
}