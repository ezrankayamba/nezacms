<?php
class NezaApplication {
	private static $app = null;
	public $inputs = array ();
	public $session = null;
	private function __construct() {
	}
	public function init() {
		$ctr = 'default';
		$vw = $ctr;
		$fn = 'index';
		if (isset ( $_GET ['ctr'] )) {
			$ctr = $_GET ['ctr'];
			$vw = $ctr;
			if (isset ( $_GET ['fn'] )) {
				$fn = $_GET ['fn'];
			}
			if (isset ( $_GET ['vw'] )) {
				$vw = $_GET ['vw'];
			}
		}
		// Load inputs
		$this->loadInputs ();
		$res = $this->handleControllerCall ( $this, $ctr, $fn );
		$this->handleViewRendering ( $this, $vw, $res );
	}
	private function loadInputs() {
		$type;
		if (isset ( $_GET ) && ! empty ( $_GET )) {
			$type = 'get';
			foreach ( $_GET as $key => $val ) {
				$this->inputs [$type] [$key] = $val;
			}
		}
		if (isset ( $_POST ) && ! empty ( $_POST )) {
			$type = 'post';
			foreach ( $_POST as $key => $val ) {
				$this->inputs [$type] [$key] = $val;
			}
		}
		if (isset ( $_FILES ) && ! empty ( $_FILES )) {
			$type = 'files';
			foreach ( $_FILES as $key => $val ) {
				$this->inputs [$type] [$key] = $val;
			}
		}
	}
	public static function getInstance() {
		if (! NezaApplication::$app) {
			$theApp = new NezaApplication ();
			
			NezaApplication::$app = $theApp;
		}
		
		return NezaApplication::$app;
	}
	/**
	 *
	 * @param string $ctr,
	 *        	controller name without 'Controller' postfix
	 * @param string $fn        	
	 */
	private function handleControllerCall(NezaApplication $app, $ctr, $fn) {
		$name = ucfirst ( $ctr );
		$name = $name . 'Controller';
		$controller = new $name ();
		return $controller->action ( $app, $fn );
	}
	/**
	 *
	 * @param string $vw,
	 *        	the view to handle rendering of page
	 * @param array $res        	
	 */
	private function handleViewRendering(NezaApplication $app, $vw, $res = array(), $data = array()) {
		$name = ucfirst ( $vw );
		$name = $name . 'View';
		$data ['response'] = $res;
		$view = new $name ();
		$view->render ( $app, $data );
	}
	public function link($path, $relative = false) {
		if ($relative) {
			$url = $path;
		} else {
			$url = '/' . APP_NAME . '/app/assets/'.$path;
		}
		return $url;
	}
	public function formAction($path, $relative = false) {
		if ($relative) {
			$url = $path;
		} else {
			$url = '/' . APP_NAME . '/' . $path;
		}
		return $url;
	}
}
class NSession extends NObject {
	public static function init() {
		if (! NSession::isActive ()) {
			session_start ();
		}
	}
	public static function isActive() {
		return ! (session_id () == '' || ! isset ( $_SESSION ));
	}
	public static function stop() {
		if (NSession::isActive ()) {
			session_unset ();
			session_destroy ();
		}
	}
}
class NInput extends NObject {
	private $type = 'post';
	private $key, $value;
	private $dataType;
	function __construct($key, $value, $dataType = 'string', $type = 'post') {
		$this->type = $type;
		$this->dataType = $dataType;
		$this->key = $key;
		$this->value = $value;
	}
}
abstract class NObject {
	function set($key, $val) {
		if (property_exists ( $this, $key )) {
			$this->$key = $this->filter ( $key, $val );
		}
	}
	function get($key) {
		if (property_exists ( $this, $key )) {
			return $this->$key;
		}
		return null;
	}
	function filter($fld, $val) {
		return $val;
	}
}
