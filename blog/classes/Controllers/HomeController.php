<?php
	
	namespace classes\Controllers;

	class HomeController{


		public function index(){

			

			\classes\Views\MainView::render('home');
			
			

		}

	}

?>