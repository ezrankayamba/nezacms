<?php
/**
 * @author nkayamba
 *
 */
interface IController {
	public function index();
	public function action(NezaApplication $app, $name);
}