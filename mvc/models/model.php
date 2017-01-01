<?php
/**
 *
 * @author nkayamba
 *        
 */
abstract class NezaModel implements IModel {
	protected $recordCls;
	protected $db;
	function __construct($recordCls) {
		$this->recordCls = $recordCls;
		$this->db = new NezaDatabase ();
		$this->db->setDebugLevel(DB_DEBUG);
	}
	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see IModel::records()
	 */
	function records() {
		$list = array ();
		for($i = 0; $i < 10; $i ++) {
			$record = new $this->recordCls ();
			$flds = get_object_vars ( $record );
			foreach ( $flds as $fld => $val ) {
				$record->set ( $fld, $fld . ' ' . ($i + 1) );
			}
			$list [] = $record;
		}
		return $list;
	}
	function transform(array $data) {
		$temp = $data;
		// make necessary transformation
		return $temp;
	}
	function paramsCopy(array $source, array $dest) {
		$res = array_intersect_key ( $source, array_flip ( $dest ) );
		
		return $this->transform ( $res );
	}
	
	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see IModel::save()
	 */
	function save() {
		$record = new $this->recordCls ();
		$table = $record->getTable ();
		$record->prepare ( $_GET );
		$data = $record->getData ();
		$format = $record->getDataFormat ();
		return $this->db->insert ( $table, $data, $format );
	}
	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see IModel::delete()
	 */
	function delete() {
	}
	
	
}