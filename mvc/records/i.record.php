<?php
interface IRecord {
	function prepare($data, $pk='id',$new=true);
	function getTable();
	function getData();
	function getDataFormat();
	function filter($fld, $val);
}