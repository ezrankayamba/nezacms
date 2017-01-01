<?php
abstract class NezaRecord implements IRecord {
	function prepare($data, $pk = 'id', $new = true) {
		$flds = get_object_vars ( $this );
		foreach ( $flds as $fld => $val ) {
			$this->set ( $fld, $data [$fld] );
		}
	}
	function set($key, $val) {
		if (property_exists ( $this, $key )) {
			$this->$key = $this->filter($key, $val);
		}
	}
	function get($key) {
		if (property_exists ( $this, $key )) {
			return $this->$key;
		}
		return null;
	}
	function getData() {
		$data = array ();
		$flds = get_object_vars ( $this );
		foreach ( $flds as $fld => $val ) {
			$data [$fld] = $val;
		}
		return $data;
	}
	function getDataFormat() {
		$dataFormat = array ();
		$flds = get_object_vars ( $this );
		foreach ( $flds as $fld => $val ) {
			echo $fld . ', ' . $val;
			if (is_double ( $val ) || is_float ( $val )) {
				$dataFormat [] = '%d';
			} elseif (is_string ( $val )) {
				$dataFormat [] = '%s';
			} elseif (is_int ( $var ) || is_numeric($val)) {
				$dataFormat [] = '%i';
			} else {
				echo 'Unknown data type!'.$fld.'=>'.$val.'<br/>';
			}
		}
		return $dataFormat;
	}
	abstract function getTable();
	abstract function filter($fld, $val);
}