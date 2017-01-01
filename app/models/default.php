<?php
class DefaultModel extends NezaModel {
	
}
class DefaultRecord extends NezaRecord {
	function filter($fld, $val){
		return $val;
	}
	function getTable(){
		return null;
	}
}