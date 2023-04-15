<?
    namespace Helper;

    use Helper\DB;
    use Helper\Validator;
    
    class UserController
    {
        static public function register () 
        {
            // Проверка полей регистрации, если поял заполнены выполнить валидацию и зарегестрировать,
            if(isset($_POST['email']) and isset($_POST['password']) and isset($_POST['password_confirm'])) {
                
                $password = $_POST['password'];
                $email = $_POST['email'];
                $password_confirm = $_POST['password_confirm'];
        
                $flag1 = Validator::checkPassword($password, $password_confirm);
                $flag2 = Validator::checkEmail($email);
                
                // в случае успешной валидации заносим в БД пользователя и переводим на главную
                if ($flag1 and $flag2) {
                    
                    $id = DB::addUser($email, $password);
                    
                    $_SESSION['id'] = $id;
                    $_SESSION['auth'] = true;
                    $_SESSION['email'] = $email;
                    $_SESSION['flash'] = 'Регистрация успешна';
  
                    unset($_POST);
                    header('Location: /');
                }
                
            // не успешная валидация продолжает выполнение и подключает шаблон в свыводом ошибок
            }
            
            return include_once('templates/register.php');
        }
        
        static public function auth () 
        {
            // Проверка на заполнение полей, если поля заполнены, то проверяем пароль пользователя в БД
            if(isset($_POST['email']) and isset($_POST['password'])) {
                
                $email = $_POST['email'];
                $password = $_POST['password'];
                
                $id = DB::checkUser($email, $password);
                if($id) {
                    $_SESSION['id'] = $id;
                    $_SESSION['auth'] = true;
                    $_SESSION['email'] = $email;
                        
                    $_SESSION['flash'] = 'Вход выполнен';
                    
                    //После успешной проверки заполняем сессию и переадресовываем на главную
                    unset($_POST);
                    header("Location: /");
                } else {
                    
                    //Не успешная проверка делает ошибку и выводит её в шаблоне
                    $_SESSION['err_auth'] = 'Неверрно введён логин или пароль';
                };
  
    }
            return include_once('templates/auth.php');
        }
        
        static public function profile () 
        
        // Подключение шаблона профиля
        {
            $arr_url = DB::getUserUrl($_SESSION['id']);
            return include_once('templates/profile.php');
        }
    }
?>