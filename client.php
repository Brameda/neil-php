<?php

session_start();

require_once 'exceptions.php';
require_once 'libs/Requests/library/Requests.php';

Requests::register_autoloader();

class TradeApiClient{

	private $server;
	private $channel;
	private $username;
	private $password;

	function __construct($server, $username, $password, $channel){
		$this->server = $server;
		$this->username = $username;
		$this->password = $password;
		$this->channel = $channel;
	}
	
	private function build_headers(){
		$headers = array(
			'Accept' => 'application/json',
			'REMOTE_ADDR' => $_SERVER['REMOTE_ADDR'],
			'HTTP_X_FORWARDED_FOR' => $_SERVER['REMOTE_ADDR']
		);
		
		return $headers;
	}
	
	
	private function build_url($path, $params){
		$url = $this->server . '/api/v1/channel/' . $this->channel .'/'. $path . '/';
		
		// Add API KEY to each request
		$api_key = $this->get_user_key();
		if ($api_key){
			$params = array_merge($params, array('key'=>$api_key));
		}
		
		if (!empty($params)){
			$url = $url . '?' . http_build_query($params);
		}
		
		return $url;
	}
	
	
	private function get($path, $params=array()){
		$headers = $this->build_headers();		
		$url = $this->build_url($path, $params);
		
		return Requests::get($url, $headers=$headers);
	}
	
	
	private function post($path, $params=array(), $data=array()){
		$headers = $this->build_headers();	
		$url = $this->build_url($path, $params);
		
		return Requests::post($url, $headers=$headers, $data=$data);
	}
	
	
	function navigation(){
		$response = $this->get('collection/navigation');
		
		if ($response->status_code == 200){
			return json_decode($response->body, true);
		}
	}
	
	function category($path='/', $order_by=Null, $limit=50, $offset=0){
		
		
		$response = $this->get('collection/categories', array('path'=> $path));
		
		if ($response->status_code == 200){
			return json_decode($response->body, true);
		} else {
			
			$error = json_decode($response->body, true);
			$error = $error['error'];
			
			if($error['code'] == 301){
				throw new Exception($message=$error['url'], $code=$error['code']);
			}
			
			if($error['code'] == 404){
				throw new Exception($message=$error['message'], $code=$error['code']);
			}
		}
	}
	
	function product($slug){
		$response = $this->get('collection/products/'.$slug);
		
		if ($response->status_code == 200){
			return json_decode($response->body, true);
		} else {
			
			$error = json_decode($response->body, true);
			$error = $error['error'];
			
			if($response->status_code == 404){
				throw new Exception($message=$error['message'], $code=$error['code']);
			}
		}
	}
	
	function search($query){
		$response = $this->get('collection/search', array('q'=> $query));
		
		if ($response->status_code == 200){
			return json_decode($response->body, true);
		}
	}
	
	private function get_user_key(){
		if(isset($_SESSION['trade-api-key'])){
			return $_SESSION['trade-api-key'];
		} else {
			return Null;
		}
	}
	
	function is_login(){
		if(isset($_SESSION['trade-api-key'])){
			return true;
		} else {
			return false;
		}
	}
	
	function login($username, $password){
		$response = $this->post('account/authenticate', array(), $data = array('email'=>$username, 'password'=>$password));
		
		if ($response->status_code == 200){
			$json = json_decode($response->body, true);
			if ($json['authenticate']) {
				$_SESSION['trade-api-key'] = $json['api_key'];
				return true;
			}
		} 
		return false;
	}
	
	function logout(){
		if(isset($_SESSION['trade-api-key'])){
			unset($_SESSION['trade-api-key']); 
			return true;
		}
		return false;
	}
}
?>