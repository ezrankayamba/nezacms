<?php
require_once 'data/config.php';
class NezaDatabase {
	protected $debug = 'none';
	private static $conn = null;
	public static function msqli() {
		if (! NezaDatabase::$conn) {
			NezaDatabase::$conn = new mysqli ( DB_HOST, DB_USER, DB_PASS, DB_NAME );
		}
		return NezaDatabase::$conn;
	}
	protected function connect() {
		return NezaDatabase::msqli ();
	}
	public function lastId() {
		return $this->connect ()->lastInsertId ();
	}
	public function query($query) {
		$db = $this->connect ();
		$result = $db->query ( $query );
		
		while ( $row = $result->fetch_object () ) {
			$results [] = $row;
		}
		
		return $results;
	}
	function setDebugLevel($level) {
		$this->debug = $level;
	}
	function log($text) {
		if ($this->debug == 'none') {
		} else {
			echo 'DB Log:: >> ' . $text . '<br/>';
		}
	}
	public function insert($table, $data, $format) {
		// Check for $table or $data not set
		if (empty ( $table ) || empty ( $data )) {
			$this->log ( 'Empty data or no table. ' . $table );
			print_r ( $data );
			return false;
		}
		// Connect to the database
		$db = $this->connect ();
		
		// Cast $data and $format to arrays
		$data = ( array ) $data;
		$format = ( array ) $format;
		
		// Build format string
		$format = implode ( '', $format );
		$format = str_replace ( '%', '', $format );
		
		list ( $fields, $placeholders, $values ) = $this->prep_query ( $data );
		
		print_r ( $values );
		echo '<br/>';
		// Prepend $format onto $values
		array_unshift ( $values, $format );
		print_r ( $values );
		echo '<br/>';
		
		// Prepary our query for binding
		$sql = "INSERT INTO {$table} ({$fields}) VALUES ({$placeholders})";
		echo 'SQL: ' . $sql . "<br/>";
		$stmt = $db->prepare ( $sql );
		// Dynamically bind values
		call_user_func_array ( array (
				$stmt,
				'bind_param' 
		), $this->ref_values ( $values ) );
		
		// Execute the query
		$res = $stmt->execute ();
		
		$this->log ( "Result: " . $res );
		
		// Check for successful insertion
		if ($stmt->affected_rows) {
			return true;
		}
		
		return false;
	}
	public function update($table, $data, $format, $where, $where_format) {
		// Check for $table or $data not set
		if (empty ( $table ) || empty ( $data )) {
			return false;
		}
		
		// Connect to the database
		$db = $this->connect ();
		
		// Cast $data and $format to arrays
		$data = ( array ) $data;
		$format = ( array ) $format;
		
		// Build format array
		$format = implode ( '', $format );
		$format = str_replace ( '%', '', $format );
		$where_format = implode ( '', $where_format );
		$where_format = str_replace ( '%', '', $where_format );
		$format .= $where_format;
		
		list ( $fields, $placeholders, $values ) = $this->prep_query ( $data, 'update' );
		
		// Format where clause
		$where_clause = '';
		$where_values = '';
		$count = 0;
		
		foreach ( $where as $field => $value ) {
			if ($count > 0) {
				$where_clause .= ' AND ';
			}
			
			$where_clause .= $field . '=?';
			$where_values [] = $value;
			
			$count ++;
		}
		// Prepend $format onto $values
		array_unshift ( $values, $format );
		$values = array_merge ( $values, $where_values );
		// Prepary our query for binding
		$stmt = $db->prepare ( "UPDATE {$table} SET {$placeholders} WHERE {$where_clause}" );
		
		// Dynamically bind values
		call_user_func_array ( array (
				$stmt,
				'bind_param' 
		), $this->ref_values ( $values ) );
		
		// Execute the query
		$stmt->execute ();
		
		// Check for successful insertion
		if ($stmt->affected_rows) {
			return true;
		}
		
		return false;
	}
	public function select($query, $data, $format) {
		// Connect to the database
		$db = $this->connect ();
		
		// Prepare our query for binding
		$stmt = $db->prepare ( $query );
		
		// Normalize format
		$format = implode ( '', $format );
		$format = str_replace ( '%', '', $format );
		
		// Prepend $format onto $values
		array_unshift ( $data, $format );
		
		// Dynamically bind values
		call_user_func_array ( array (
				$stmt,
				'bind_param' 
		), $this->ref_values ( $data ) );
		
		// Execute the query
		$stmt->execute ();
		
		// Fetch results
		$result = $stmt->get_result ();
		
		// Create results object
		while ( $row = $result->fetch_object () ) {
			$results [] = $row;
		}
		return $results;
	}
	public function delete($table, $id) {
		// Connect to the database
		$db = $this->connect ();
		
		// Prepary our query for binding
		$stmt = $db->prepare ( "DELETE FROM {$table} WHERE ID = ?" );
		
		// Dynamically bind values
		$stmt->bind_param ( 'd', $id );
		
		// Execute the query
		$stmt->execute ();
		
		// Check for successful insertion
		if ($stmt->affected_rows) {
			return true;
		}
	}
	private function prep_query($data, $type = 'insert') {
		// Instantiate $fields and $placeholders for looping
		$fields = '';
		$placeholders = '';
		$values = array ();
		
		// Loop through $data and build $fields, $placeholders, and $values
		foreach ( $data as $field => $value ) {
			$fields .= "{$field},";
			$values [] = $value;
			
			if ($type == 'update') {
				$placeholders .= $field . '=?,';
			} else {
				$placeholders .= '?,';
			}
		}
		
		// Normalize $fields and $placeholders for inserting
		$fields = substr ( $fields, 0, - 1 );
		$placeholders = substr ( $placeholders, 0, - 1 );
		
		return array (
				$fields,
				$placeholders,
				$values 
		);
	}
	private function ref_values($array) {
		$refs = array ();
		foreach ( $array as $key => $value ) {
			$refs [$key] = &$array [$key];
		}
		print_r ( $refs );
		echo '<br/>';
		return $refs;
	}
	function run_sql_file($location) {
		$db = $this->connect ();
		// load file
		$commands = file_get_contents ( $location );
		
		// delete comments
		$lines = explode ( "\n", $commands );
		$commands = '';
		foreach ( $lines as $line ) {
			$line = trim ( $line );
			if ($line && ! $this->startsWith ( $line, '--' )) {
				$commands .= $line . "\n";
			}
		}
		
		// convert to array
		$commands = explode ( ";", $commands );
		
		// run commands
		$total = $success = 0;
		foreach ( $commands as $command ) {
			if (trim ( $command )) {
				$success += (mysqli_query ( $db, $command ) == false ? 0 : 1);
				$total += 1;
			}
		}
		
		// return number of successful queries and total number of queries found
		return array (
				"success" => $success,
				"total" => $total 
		);
	}
	
	// Here's a startsWith function
	function startsWith($haystack, $needle) {
		$length = strlen ( $needle );
		return (substr ( $haystack, 0, $length ) === $needle);
	}
}