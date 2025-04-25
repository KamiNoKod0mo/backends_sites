<?php
	namespace classes\Views;

	/**
	 * 
	 */
	class MainView{

		public static function render($filename){
			//echo 'pages/'.$filename.'.php';
			include('pages/'.$filename.'.php');
		}



	}

?>