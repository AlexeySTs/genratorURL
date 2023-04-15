<?php
    $header = '<div class=header_line>
                <div class="link_home"> 
                    <a class="link_head" href="/">Главная</a>
                </div>
                <div class="link_auth">
                    {{ header_line }}
                </div>
            </div>';

    if(isset($_SESSION['auth'])) {
        $header_line = "
            <a class = \"link_head\" href=\"/user/$_SESSION[id]\">$_SESSION[email]</a>
            <a class = \"link_head\" href=\"/logout\">Выйти</a>
        ";
    } else {
        $header_line = "
            <a class = \"link_head\" href=\"/auth\">Войти</a>
            <a class = \"link_head\" href=\"/register\">Регистрация</a>
        ";
    }
    
    $header = str_replace('{{ header_line }}',	$header_line, $header);
    
    
   
    return $header;
?>