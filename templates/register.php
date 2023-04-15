<?php
    
    $register = '<div class="testbox">
                    <h1>Регистрация</h1>
                    <form method="POST" action = "">
                    
                        <label> Email
                            <input type="text" name="email" value = "{{ value_email }}"></input>
                            {{ err_email }}
                        </label><br>
                        
                        <label> Пароль
                            <input type = "password" name="password"></input>
                            {{ err_pass }}
                        </label><br>
                        
                        <label> Подтвердите пароль
                            <input type = "password" name="password_confirm"></input>
                        </label><br>
                        
                        <input type="submit"></input>
                        
                    </form>
                </div>';

    $value_email = '';
    $err_email = '';
    $err_pass= '';
    
    if(isset($_POST['email'])) {
        $value_email = $_POST['email'];
        
    }
    
    if(isset($_SESSION['pass_errors']) AND $_SESSION['pass_errors'] != '') {
        $err_pass = 
            "<span class = \"reg_errors\">
                $_SESSION[pass_errors]
            </span>";
                    
        unset($_SESSION['pass_errors']);
    }
    
    if(isset($_SESSION['email_errors']) AND $_SESSION['email_errors'] != '') {
        
        $err_email = 
            "<span class = \"reg_errors\">
                $_SESSION[email_errors]
            </span>";
            
        unset($_SESSION['email_errors']);
    }
    
    
    $register = str_replace('{{ err_pass }}',	$err_pass, $register);
    $register = str_replace('{{ err_email }}',	$err_email, $register);
    $register = str_replace('{{ value_email }}',	$value_email, $register);
    
    
   
    return $register;
?>