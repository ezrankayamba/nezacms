<?php
interface IView {
	/**
	 * @param array $data
	 */
	function render(NezaApplication $app, $data=array());
}