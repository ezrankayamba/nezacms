<?php
interface IView {
	/**
	 * @param array $data
	 */
	function render($data=array());
}