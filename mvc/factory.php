<?php
class NezaApplication {
	public static function init() {
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
		$res = NezaApplication::handleControllerCall ( $ctr, $fn );
		NezaApplication::handleViewRendering ( $vw, $res );
	}
	/**
	 *
	 * @param string $ctr,
	 *        	controller name without 'Controller' postfix
	 * @param string $fn        	
	 */
	private static function handleControllerCall($ctr, $fn) {
		$name = ucfirst ( $ctr );
		$name = $name . 'Controller';
		$controller = new $name ();
		return $controller->action ( $fn );
	}
	/**
	 *
	 * @param string $vw,
	 *        	the view to handle rendering of page
	 * @param array $res        	
	 */
	private static function handleViewRendering($vw, $res = array(), $data=array()) {
		$name = ucfirst ( $vw );
		$name = $name . 'View';
		$data['response']=$res;
		$view = new $name ();
		$view->render ();
	}
}