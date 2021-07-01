<?php

namespace Elhelper\inc;
class DB {

	static function valid_check( $data ) {
		global $wpdb;

		$sql_where       = '';
		$sql_where_count = count( $data );
		$i               = 1;
		foreach ( $data as $key => $row ) {
			if ( $i < $sql_where_count ) {
				$sql_where .= "`$key` = '$row' and ";
			} else {
				$sql_where .= "`$key` = '$row'";
			}
			$i ++;
		}
		$sql     = 'SELECT * FROM ' . self::_table() . " WHERE $sql_where";
		$results = $wpdb->get_results( $sql );
		if ( count( $results ) != 0 ) {
			return false;
		} else {
			return true;
		}
	}

	private static function _table() {
		global $wpdb;
		$tablename = str_replace( '\\', '_', strstr( strtolower( get_called_class() ), '\\' ) );

		return $wpdb->prefix . $tablename;
	}


	static function get_table() {
		return static::_table();
	}


	static function get( $value, $column ) {
		global $wpdb;

		return $wpdb->get_row( self::_fetch_sql( $value, $column ) );
	}

	private static function _fetch_sql( $value, $column ) {
		global $wpdb;
		$sql = sprintf( 'SELECT * FROM %s WHERE %s = %%s', self::_table(), $column );

		return $wpdb->prepare( $sql, $value );
	}

	static function insert( $data ) {
		global $wpdb;
		$wpdb->insert( self::_table(), $data );
	}

	static function update( $data, $where ) {
		global $wpdb;
		$wpdb->update( self::_table(), $data, $where );
	}

	static function delete( $value ) {
		global $wpdb;
		$sql = sprintf( 'DELETE FROM %s WHERE %s = %%s', self::_table(), static::$primary_key );

		return $wpdb->query( $wpdb->prepare( $sql, $value ) );
	}

	/*	static function fetch( $value ) {
			global $wpdb;
			$value = intval( $value );
			$sql   = 'SELECT * FROM ' . self::_table() . " WHERE `ads_id` = '$value' order by `created_at` DESC";

			return $wpdb->get_results( $sql );
		}*/

}
