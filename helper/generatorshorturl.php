<?php
    namespace Helper;
    
    use Helper\DB;
    
    class GeneratorShortURL 
    {
        static public function getShortURL ($url, $user_id = null) 
        {
            
            if ($user_id) {
                
                $id = DB::addUrl($url, $user_id);
            } else {
                
                $id = DB::addUrl($url);
            }
            
            // Преобразуем id в тридцатидвухричную систему счисления
            $convert_id = base_convert($id,10,32); 
            
            // Возвращаем уникальный url
            return "$_SERVER[SERVER_NAME]/res/$convert_id"; 
            
        }
        
    }
    
    
?>