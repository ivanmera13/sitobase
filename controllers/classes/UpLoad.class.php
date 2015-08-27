<?php

class upload {
	
	#params
	static $path_dir;
	
	# Storage the value of post variables 
	var $post = array();
	
	# Storage and decoded value of get variables
	var $get = array();
	
	#
	var $file = array();
	
	function upload() {
		// Initialize the post variable
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			#If post value contain data assing to variable
			if(isset($_POST) && count($_POST) > 0){
				$this->post = $_POST;
				if(get_magic_quotes_gpc()){
					// Get rid of magic quotes and slashes if presente
					array_walk_recursive($this->post, array($this, 'stripslash_gpc'));
				}
			}
			
			#If files contain data assing to variable 
			if(isset($_FILES) && count($_FILES) > 0){
				$this->file = $_FILES;
			}
		}
		
		// Initialize the get variable
		$this->get = $_GET;
		
		// Decode the URl 
		array_walk_recursive($this->get, array($this, 'urldecode'));
		
	}
	
	/*
	 * 	Function register news
	 */
	 
	function registerPostNews()
	{
		#variables to register post
		$news = array();
		$options = array();
		if(isset($this->post) && !empty($this->post)){
			#if post article is set in hidden 
			if($this->post['hidden'] == 'postArticle'){
	 			$news = $this->post;

				#set params to pass into function
				$options['title'] = $news['title'];
				$options['news'] = nl2br($news['text_area']);
				$options['type_publish'] = $news['type_publish'];
				$options['date'] = '';
				$options['category'] = $news['category'];
				
				$test = setNews($options);
	 		}
	 	
	 	}
		# lo que deberia retornar es true 
		return $test;
	}
	
	/**/
	
	function getPostNews($options)
	{
		
	}
	
	/**/
	
	function editPostNews($options){
		
	}
	
	function deletePostNews($news){
		
	}
	 
	 /*
	  *	Function register products 
	  */
	  
	function register_products()
	{
		$products = array();
		$productsPhoto = array();
		$error = array('Error');
		$options = array();
		  
		if(isset($this->post) && !empty($this->post)){
			if ($this->post['hidden'] == 'postProduct') {
				$products = $this->post;
				$products['desc_product'] = nl2br($this->post['desc_product']);
				
				if(strpos($products['title'], ' ')){
					$products['folder'] = '\\'.str_replace(' ', '_', $products['title']).'_'.date('Y-m-d');
				}else{ $products['folder'] = '\\'.$products['title'].'_'.date('Y-m-d'); }
				
				$options['product'] = $products['title'];
				$options['desc_product'] = $products['desc_product'];
				$options['precio_product'] = $products['precio_product'];
				$options['idcategoria'] = $products['idcategoria'];
				$options['folderproduct'] = $products['folderproduct'];
				
				#aqui pasamos los valores a la base de datos 
				#set_product($options);
				
				# if have image files
				if (isset($this->file) && !empty($this->file)) {
					#count all files 
					$count = count($this->file['archivo']['name']);
					#get information of files
					for($i=0;$i<$count;$i++){
						$ext = explode('.', $this->file['archivo']['name'][$i]);
						$num=count($ext)-1;
						if($ext[$num] <> 'jpg'){
							return $error;
						}
						$data[$i]['name']=$this->file['archivo']['name'][$i];
						$data[$i]['path']=$this->file['archivo']['tmp_name'][$i];
						$data[$i]['size']=$this->file['archivo']['size'][$i];
						$data[$i]['type']=$this->file['archivo']['type'][$i];
						$data[$i]['extension']=$ext[$num];
						$data[$i]['string']= $this->get_string();
					}
					$productsPhoto['files'] = $data;
						
					# if exist folder otherwise create folder
					$folder = "C:\Program Files (x86)\Apache Software Foundation\Apache2.2\htdocs\ivan".$products['folder'];
					if (!file_exists($folder)) {
				    	mkdir($folder, 0777, true);	
					}
					
					#move files to folder 
					#get id product
					#$idProduct = get_productId($products['title']);
					for ($fl=0; $fl < count($productsPhoto['files']) ; $fl++) { 
						//move_uploaded_file($_FILES['nombre_archivo_cliente']['tmp_name'], $nombreDirectorio.$nombreFichero);
						$new_fichero = $products['title'] .'_'. $productsPhoto['files'][$fl]['string'].'.'.$productsPhoto['files'][$fl]['extension'];
						$newPath = $folder.'\\';
						copy($productsPhoto['files'][$fl]['path'], $newPath.$new_fichero);
						
						#insert into database the info for the products
						#apuntamos a consults.inc.php para guardar cada foto del producto
						/*
						 * set_product()
						 * 
						 * */
					}					
				}
			  }
		  }
		#return true
		return $products;
		#return true;
	  }
	
	/**/	
	function getRegisterProduct($options){
		
	}
	
	/**/
	
	function editRegisterProduct($options)
	{
		
	}
	
	function deleteRegisterProduct($news){
		
	}

	
	/*
	 * Create Categorie for  products
	 * */
	function setCatProduct(){
		$categori = array();
		if(isset($this->post) && !empty($this->post)){
			if ($this->post['hidden'] == 'setCategoriProduct') {
				$categori = $this->post;
				if ($categori['category'] != ' ') {
					#set_productCategory($categori['category']);
				}
			}
		}
		return $categori;
	}
	
	/*
	 * modiy catego
	 * */
	function modCatProduct($productCat){
		if(isset($productCat) && !empty($productCat)){
			#alterCatProduct($productCat);
		}
		return true;
	}
	
	/*
	 * Delete cartegoria
	 * */
	function DelCatProduct($productCat){
		if(isset($productCat) && !empty($productCat)){
			#deleteCatProduct($productCat)
		}
		return true;
	}
	
	// photograp categor
	/*
	 * Create Categorie for Photograp
	 * */
	function setCatPhoto(){
		$categori = array();
		if(isset($this->post) && !empty($this->post)){
			if ($this->post['hidden'] == 'setCategoriPhoto') {
				$categori = $this->post;
				if ($categori['category'] != ' ') {
					#set_productCategory($categori['category']);
				}
			}
		}
		return $categori;
	}
	
	/*
	 * modiy catego
	 * */
	function modCatPhoto($photoCat){
		if(isset($photoCat) && !empty($photoCat)){
			#alterCatPhoto($photoCat);
		}
		return true;
	}
	
	/*
	 * Delete cartegoria
	 * */
	function DelCatPhoto($photoCat){
		if(isset($photoCat) && !empty($photoCat)){
			#deleteCatPhoto($photoCat)
		}
		return true;
	}
	
	// News cate
	
	/*
	 * Create Categorie for news
	 * */
	function setCatNews(){
		$categori = array();
		if(isset($this->post) && !empty($this->post)){
			if ($this->post['hidden'] == 'setCategoriNews') {
				$categori['category'] = $this->post['category'];
				if ($categori['category'] != ' ') {
					setCatNews($categori);
				}
			}
		}
		return TRUE;
	}
	
	/*
	 * modiy catego
	 * */
	function modCatNews(){
		if(isset($this->post) && !empty($this->post)){
			if ($this->post['hidden'] == 'modCategoriNews') {
				$categori = $this->post;
				alterCatNews($categori);
			}
		}
		return true;
	}
	
	/*
	 * Delete cartegoria
	 * */
	function DelCatNews(){
		if(isset($this->post) && !empty($this->post)){
			if ($this->post['hidden'] == 'delCategoriNews') {
				$categori = $this->post;
				deleteCatNews($newsCat);
			}
		}
		return true;
		
	}
	
	//
	function getCatNews(){
		$data = array();
		$data = getCateNews();
		return $data;
	}
	
	function get_param(){
		return array('post'=>$this->post, 'File'=>$this->file, 'get'=>$this->get);
	}
	
	function get_string(){
		$strings = 'abcdefghijklmNopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'; 
		# string long
		$long = 6; 		
		$new_string = '';
		
		#loop to string
		for ($i=0; $i <= $long; $i++){ 
			$rand = rand(0, strlen($strings)); 
			$new_string .= $strings[$rand]; 
		} 
		return $new_string; 
	}
		
	/*
	*	stripslash gpc
	*/
	
	protected function stripslash_gpc(&$value){
		$value = stripslashes($value);
	}
	
	/*
	 *	htmlspecialcarfy 
	 */
	 protected function htmlspecialcarfy(&$value){
		$value = htmlspecialchars($value);
	}

	/*
	 *	URL Decode 
	 */
	 protected function urldecode(&$value){
		$value = urldecode($value);
	}
	
}

?>