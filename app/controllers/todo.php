<?php
class TodoController extends NezaController {
	function __construct(){
		parent::__construct(new TodoModel('Todo'));
	}
}