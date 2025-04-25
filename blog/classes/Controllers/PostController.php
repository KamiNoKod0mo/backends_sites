<?php
	
	namespace classes\Controllers;

	class PostController{
		public function index(){

			\classes\Views\MainView::render('post');

			if (isset($_POST['post'])) {
				$title = $_POST['title'];
				$art = $_POST['textarea'];
				if (isset($_POST['new'])){
					$new = intval($_POST['new']);
				}else{
					$new = 0;
				}
				if (isset($_FILES['imagem'])){

					$imagem = $_FILES['imagem'];
					if($imagem['type'] == 'image/jpeg' || $imagem['type'] == 'imagem/jpg' ||$imagem['type'] == 'imagem/png'){
						$tamanho = intval($imagem['size']/1024);
						if($tamanho < 500){
							$extension = explode('.', $imagem['name']);
							
							$imagemN = uniqid().'-'.$title.'.'.array_pop($extension);
							move_uploaded_file($imagem['tmp_name'], "classes/Views/pages/covers-up/".$imagemN);
						}else{
							echo "Imagem invalida";
						}
					}else{
						echo "Imagem invalida";
					}
				}else{
					$img = '';
				}
				

				if ($title != '' and $art !='') {
					function getNextSequence(){
						$counter = \classes\Mongo::conexao2()->findOneAndUpdate(
					        ['id' => 'post_id'],
					        ['$inc' => ['seq' => 1]],
					        
					    );
					    return $counter['seq'];
					}


					$newPost = [
					    'id' => getNextSequence(), // ID auto-incrementado
					    'title' => $title,
					    'text' => $art,
					    'cover'=> "classes/Views/pages/covers-up/".$imagemN,
					    'type' => $new
					];


					$collection = \classes\Mongo::conexao1();
					$resu = $collection->insertOne($newPost);

					// Verificar inserção
					if ($resu->getInsertedCount() > 0) {
					    echo "Post inserido com sucesso! ID: " . $newPost['id'];
					} else {
					    echo "Erro ao inserir post.";
					}
				}else{
					echo "prencha os campos";
				}

			}

		}
	}

?>