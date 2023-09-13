<?php

namespace NamePlugin;

class NameApi {
    public $api_url;
	
	public function __construct($initValue = true){ // конструктор, в данном случае просто возвращает true, если другое не предусмотрено логикой кода. Нужен для правильного создания класса
    $this->initProperty = $initValue;
}

    public function list_vacansies($post, $vid = 0) {
        global $wpdb;

        $ret = array();

        if (!is_object($post)) {
            return false;
        }

        $page = 0;
        $found = false;
       
        
		
		do{ //будем использовать do..while, поскольку цикл выполняется по крайне мере раз и даже если запрос будет провален , то мы в итоге сможем вернуть в конце функции false
//		или пустой массив при провале;
		$params = "status=all&id_user=" . $this->self_get_option('superjob_user_id') . "&with_new_response=0&order_field=date&order_direction=desc&page={$page}&count=100";
        $res = $this->api_send($this->api_url . '/hr/vacancies/?' . $params); // получаем страницу
        
		
        if ($res !== false ) {
			//
           $res_o = json_decode($res);
		   
		   if (isset($res_o->objects)){ // ниже переберем массив из вакансий из полученной страницы 
			   
			   
			   foreach($res_o->objects as $res_vacancy)
               {
				   
				   
				   if($res_vacancy->id==$vid && ($vid>0)){ // конкретная вакансия
					   
					   array_push($ret,$res_vacancy);
					   return $ret;// выше добавим вакансию в массив как единственный элемент и выйдем из функции вернув массив
					   // не используем break, поскольку им мы не прервем родительский цикл а только выйдем с foreach
					   
				   }
				     
					 array_push($ret,$res_vacancy); // добавляем вакансию в массив
				   
                    

               }

			   
			  
			  } 
        
		 
		 
		 $page++;
		
        } 			

          
		
		} while($res !== false);
	

     if(empty($ret)){
     return false;
		            } 
    else { 
	return $ret;
	} // если вакансий нет вернем false иначе массив с вакансиями
	
    }    
    public function api_send() { //какая-то функция, которая возвращает массив вакансий или false при их отсутствии
        return '';
    }
    public function self_get_option($option_name) {
        return '';
    }
}

?>
