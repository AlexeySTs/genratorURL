<?php
    namespace Helper;
    
    use Helper\DB;
    class Validator 
    {
        static public function checkPassword($password, $password_confirm) {
            
            // Проверка пароля на длинну, маленькую букву, большую букву, и цифру
            // Валидатор генерирует ошибки в сессию которые подключаются в шаблоне при успехе возвращает true 
            
            $flag = true;
            $pass_errors = '';
            
            if(!preg_match('#^[0-9a-zA-Z!@\#$%?$]{8,16}#',$password)) {
                $flag = false;
                $pass_errors .= 'Пароль должен быть длинной от 8 до 16 символов <br>';
            }
            
            if (!preg_match('#[a-z]#',$password)) {
                $flag = false;
                $pass_errors .= 'Пароль должен содержать одну маленькую букву <br>';
            }
            
            if (!preg_match('#[A-Z]#',$password)) {
                $flag = false;
                $pass_errors .= 'Пароль должен содержать одну больную букву <br>';
            }
            
            if (!preg_match('#[0-9]#',$password)) {
                $flag = false;
                $pass_errors .= 'Пароль должен содержать одну цифру<br>';
            }
            
            if ($password !== $password_confirm) {
                $flag = false;
                $pass_errors .= 'Пароли несовпадают<br>';
            }
            
            if (!$flag) {
                $_SESSION['pass_errors'] = $pass_errors;
            }
            
            return $flag;
        }
        
        static public function checkEmail($str) {
            
            // Проверка емаила на корректность и занятость в БД
            // Валидатор генерирует ошибки в сессию которые подключаются в шаблоне при успехе возвращает true 
            $flag = true;
            
            $email_errors = '';
            
            if(!preg_match('#^[a-z0-9\-_]+@[a-z0-9\-_]+\.[a-z]{2,}$#',$str)) {
                $flag = false;
                $email_errors .= 'Некорректный емаил<br>';
                $_SESSION['email_errors'] = $email_errors;
                return $flag;
                
            }
            
            if(DB::checkEmail($str)) {
                    $flag = false;
                    $email_errors .= 'Емаил уже занят<br> ';
                }
    
            if (!$flag) {
                $_SESSION['email_errors'] = $email_errors;
            }

            return $flag;
            
        }
    }
?>