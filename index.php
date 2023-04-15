<?php
    
    session_start();

    spl_autoload_register();

    error_reporting(E_ALL);
	ini_set('display_errors', 'on');

    use Helper\DB;
    use Helper\UserController;
    use Helper\GeneratorShortURL;
  
    
    // Файл настроек
    $setting = require_once 'setting.php';
    
    // Подключение к БД
    DB::setLink(mysqli_connect($setting['DB']['host'], $setting['DB']['login'], $setting['DB']['password'], $setting['DB']['database']));
    
    $uri = htmlspecialchars($_SERVER['REQUEST_URI']);
    
    // Подключение главной страницы
    if (preg_match("#/#", $uri, $match)) {
        $content = include 'templates/home.php';
    }   
    
    // Подключение страницы регистрации
    if (preg_match("#/register#", $uri, $match)) {

        // Проверка на авторизацию, если пользователь авторизован, перекинуть на главную
        if(isset($_SESSION['auth'])) {
            
            $_SESSION['flash'] = 'Вы уже авторизованы';
            header('Location: /');
        }
        
        $content = UserController::register();
    }   
    
    if (preg_match("#/auth#", $uri, $match)) {
        
        // Проверка на авторизацию, если пользователь авторизован, перекинуть на главную
        if(isset($_SESSION['auth'])) {
            
            $_SESSION['flash'] = 'Вы уже авторизованы';
            header('Location: /');
        }
        
        $content = UserController::auth();
    }   
    
    // Странциа профиля с ссылками
    if (preg_match("#/user/(?<id>[0-9a-z]+)#", $uri, $match)) {
        
        // Проверка на авторизацию и совпадения id своего профиля
        if(!isset($_SESSION['auth'])) {
            
            $_SESSION['flash'] = 'Cначала зарегистируйтесь';
            header('Location: /register');
            
            if($_SESSION['id'] != $match['id']) {
                $_SESSION['flash'] = 'Не ваш профиль';
                header('Location: /');
            }
        }
        
        $content = UserController::profile();
    }

    // Страница выхода из профиля
    if (preg_match("#/logout#", $uri, $match)) {
        
        session_destroy();
        $_SESSION['flash'] = 'Вы вышли из профиля';
        header('Location: /');
    }   
    
     // Страница для ответа AJAX запроса
    if (preg_match("#/geturl#", $uri, $match)) {
        
        if(isset($_POST['url']) and $_POST['url'] != '') {
            
            $url = htmlspecialchars($_POST['url']);
            
            // Проверка на авторизацию, записывает в базу данных ИД пользователя для отслеживания
            if(isset($_SESSION['id'])) {
                
                echo GeneratorShortURL::getShortURL($url, $_SESSION['id']);
                exit();
                
            } else {
                
                echo GeneratorShortURL::getShortURL($url);
                exit();
                
            }
        }
    }
    
    // Переадресация коротких сылок
    if (preg_match("#/res/(?<url>[0-9a-z]+)#", $uri, $match)) {
        
        if($match['url']){
            
            $url = DB::getUrl($match['url']);
            
            // Если в базе данных не такой ссылки возвращать 404 иначе делаем переадресацию
            if (!$url) {
                header("Location: /404");
            }
            
            //Добавление протокола если ссылка указана без него, иначе просто добавляет путь к домену
            
            if(!preg_match("#^(http://)|(https://)#",$url)) {
                $url = "http://" .$url;
            }
            
            DB::incrementCount($match['url']);
            header("Location:  $url");

        }
    }
    
    $flash = '';
    
    if(isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
    }
    
    // Подключение основного шаблона и хедера
    $layout = file_get_contents ('templates/layout.php');
    $header = include_once ('templates/header.php');
    
    // Формирование в шаблона
    $layout = str_replace('{{ flash }}',	$flash, $layout);
    $layout = str_replace('{{ content }}',	$content, $layout);
    $layout = str_replace('{{ header }}',	$header, $layout);
    
    echo $layout;
    
?>