<?php

/**
 *
 * @author nkayamba
 *        
 */
abstract class NezaController implements IController {
	protected $model;
	function __construct(IModel $model) {
		$this->model = $model;
	}
	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see IController::index()
	 */
	public function index() {
		return array (
				'success' => true 
		);
	}
	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see IController::action()
	 */
	public function action($name) {
		$result = null;
		switch ($name) {
			case 'save' :
				$result = $this->model->save ();
				break;
			case 'delete' :
				$result = $this->model->delete ();
				break;
			case 'list' :
				$result = $this->model->records ();
				break;
			default :
				$result = $this->$name ();
				break;
		}
		return $result;
	}
}