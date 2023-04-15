<?php
    // Шаблон с переменными
    $auth = '<div class="testbox">
                    <h1>Вход</h1>
                    <form method="POST" action = "">
                    
                        <label> Email
                            <input type="text" name="email" value = "{{ value_email }}"></input>
                        </label><br>
                        
                        <label> Пароль
                            <input type = "password" name="password"></input>
                        </label><br>
                        
                        {{ err_auth }}
                        
                        <input type="submit"></input>
                        
                    </form>
                </div>';

    $err_auth = '';
    $value_email = '';
    
    // Заполнение емаил если раньше было введено
    if(isset($_POST['email'])) {
        $value_email = $_POST['email'];
    }
    
    // Вывод ошибок авторизации
    if(isset($_SESSION['err_auth']) AND $_SESSION['err_auth'] != '') {
        $err_auth = 
            "<span class = \"reg_errors\">
                $_SESSION[err_auth]
            </span>";
                    
        unset($_SESSION['err_auth']);
    }
    
    
    // Вставление ошибок и старого емаил в шаблон
    $auth = str_replace('{{ err_auth }}',	$err_auth, $auth);
    $auth = str_replace('{{ value_email }}',	$value_email, $auth);
    
    return $auth;
?>