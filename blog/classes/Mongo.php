<?php
	
namespace classes;
require 'vendor/autoload.php';

use MongoDB\Client; // Certifique-se de usar o namespace correto

class Mongo {
    public static function conexao1() {
        try {
            $con = new Client('mongodb://localhost:27017'); // Instancia correta

            $bd = $con->blog;
            $collection = $bd->post;

            /*
            $data = $collection->find();

            foreach ($data as $document) {
		        echo json_encode($document, JSON_PRETTY_PRINT) . "\n";
		    }

		    foreach($data as $key=>$value){
				echo $value['title'];
				echo '<br/>';
			}
			*/
			return $collection;
        } catch (\Exception $e) {
            return "Erro ao conectar ao MongoDB: " . $e->getMessage();
        }
       
    }

    public static function conexao2(){
    	try {
    		$con = new Client('mongodb://localhost:27017'); // Instancia correta

        	$bd = $con->blog;	
        	$collection = $bd->counters;

        	return $collection;
    	}catch (\Exception $e) {
            return "Erro ao conectar ao MongoDB: " . $e->getMessage();
        }
    }
}


// db.post.insertOne({id: 0,title:"Teste",text:"texto grande", img:$INCLUDE_PATH_STATIC."covers-up/", type:1})
// db.counters.insertOne({_id: "post_id", seq: 0})