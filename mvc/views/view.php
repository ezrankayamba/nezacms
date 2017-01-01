<?php
class NezaView implements IView {
	protected $template = 'default';
	function render($data=array()){
		require_once 'app/templates/'.$this->template.'.php';
	}
}