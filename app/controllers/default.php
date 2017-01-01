<?php
class DefaultController extends NezaController {
	function __construct(){
		parent::__construct(new DefaultModel('DefaultRecord'));
	}
}