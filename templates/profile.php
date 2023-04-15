<?php
    
    $url_list = '';
    
    foreach ($arr_url as $elem) {
        
        $url = $_SERVER['SERVER_NAME']. '/res/' . base_convert($elem['id'],10,32);
        
        $url_list .= 
                "<p class=\"url_elem\">
                    ссылка: <a class=\"url_name\">$url</a> </br>
                    Кол-во переходов: $elem[count];
                </p>
                ";
    }
    
    
    
    $profile = '<div class="testbox">
                    <h1>Список ссылок</h1>
                    <div class= "url_list">
                        {{ url_list }}
                    </div>
                </div>';


    
    $profile = str_replace('{{ url_list }}',	$url_list, $profile);

    return $profile;
?>