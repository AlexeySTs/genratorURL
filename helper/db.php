<?php
	namespace Helper;
	
    class DB {
        private static $link;
		
		static public function setLink($link) {
		    self::$link = $link;
		}
		
		static public function addURL($url, $user_id = "null") { 
		    
		    // Добавление УРЛ в таблицу, если пользователен авторизован добавить связи с ним
		    mysqli_query(self::$link, "INSERT INTO `url_list` (`id`, `url`, `user_id`, `count`) VALUES (NULL, '$url', $user_id, '0')") or die(mysqli_error(self::$link));
		    return mysqli_insert_id(self::$link);
		}
		
		static public function getURL($id) { 
		    
		    // Конвертация из адреса для ссылки в обычный id
		    $convert_id = base_convert($id,32,10);
		    
		    //Получаем ссылку для переадресации и возвращаем её
		    $query = mysqli_query(self::$link, "SELECT url FROM `url_list`WHERE `id` = $convert_id") or die(mysqli_error(self::$link));
		    
		    $result = mysqli_fetch_assoc($query)['url'];
		    return $result;
		    
		}
		
		
		static public function delURL($id) {
		    // Удаление УРЛ из таблицы
		    mysqli_query(self::$link,"DELETE FROM url_list WHERE id = $id");
		
		}
		
		static public function checkEmail($email) {
		    
		    // Проверка на занятость емаила
		    $query = mysqli_query(self::$link, "SELECT id FROM users WHERE `email` = '$email'");
		    $res = mysqli_fetch_assoc($query);

		    if ($res == null) {
		        return false;
		    }
		    
		    return true;
		}
		
		static public function incrementCount($id) {
		    
		    // Получаем обычный id и добавляем к счётчику 1;
		    $convert_id = base_convert($id,32,10);
		    
		    $query = mysqli_query(self::$link, "UPDATE `url_list` SET `count` = `count` + 1 WHERE `id` = $convert_id") or die(mysqli_error(self::$link));
		    
		    return;
		    
		}
		
		static public function checkUser($email, $password) {
		    
		    // Проверка на совпадения логина и пароля для авторизации, при успешном возвращаем id
		    
		    $query = mysqli_query(self::$link, "SELECT * FROM users WHERE `email` = '$email'");
		    $result = mysqli_fetch_assoc($query);
		    
		    if ($result) {
		        $hash = $result['password'];
		        if (password_verify($password, $hash)) {
		            return $result['id'];
		        } else {
		            return false;
		        }
		    } else { 
		        return false;
		    }
		    
		}
		
		
		static public function addUser($email, $password) {
		    
		    // Добавление пользователя
		    
		    $hash = password_hash($password,PASSWORD_DEFAULT);
		    
		    mysqli_query(self::$link, "INSERT INTO users SET email = '$email', password = '$hash'");
		    return mysqli_insert_id(self::$link);
		}
		
		static public function getUserUrl($id) {
		    
		    // Получение всех ссылок пользователя
		    
		    $query = mysqli_query(self::$link, "SELECT * FROM url_list WHERE user_id = $id");
		   
		    for ($result = []; $elem = mysqli_fetch_assoc($query); $result[] = $elem);
		    
		    return $result;
		}
    }
    
?>