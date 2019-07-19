<?php
/**
 * Theme storage manipulations
 *
 * @package WordPress
 * @subpackage SAVEO
 * @since SAVEO 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Get theme variable
if (!function_exists('saveo_storage_get')) {
	function saveo_storage_get($var_name, $default='') {
		global $SAVEO_STORAGE;
		return isset($SAVEO_STORAGE[$var_name]) ? $SAVEO_STORAGE[$var_name] : $default;
	}
}

// Set theme variable
if (!function_exists('saveo_storage_set')) {
	function saveo_storage_set($var_name, $value) {
		global $SAVEO_STORAGE;
		$SAVEO_STORAGE[$var_name] = $value;
	}
}

// Check if theme variable is empty
if (!function_exists('saveo_storage_empty')) {
	function saveo_storage_empty($var_name, $key='', $key2='') {
		global $SAVEO_STORAGE;
		if (!empty($key) && !empty($key2))
			return empty($SAVEO_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return empty($SAVEO_STORAGE[$var_name][$key]);
		else
			return empty($SAVEO_STORAGE[$var_name]);
	}
}

// Check if theme variable is set
if (!function_exists('saveo_storage_isset')) {
	function saveo_storage_isset($var_name, $key='', $key2='') {
		global $SAVEO_STORAGE;
		if (!empty($key) && !empty($key2))
			return isset($SAVEO_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return isset($SAVEO_STORAGE[$var_name][$key]);
		else
			return isset($SAVEO_STORAGE[$var_name]);
	}
}

// Inc/Dec theme variable with specified value
if (!function_exists('saveo_storage_inc')) {
	function saveo_storage_inc($var_name, $value=1) {
		global $SAVEO_STORAGE;
		if (empty($SAVEO_STORAGE[$var_name])) $SAVEO_STORAGE[$var_name] = 0;
		$SAVEO_STORAGE[$var_name] += $value;
	}
}

// Concatenate theme variable with specified value
if (!function_exists('saveo_storage_concat')) {
	function saveo_storage_concat($var_name, $value) {
		global $SAVEO_STORAGE;
		if (empty($SAVEO_STORAGE[$var_name])) $SAVEO_STORAGE[$var_name] = '';
		$SAVEO_STORAGE[$var_name] .= $value;
	}
}

// Get array (one or two dim) element
if (!function_exists('saveo_storage_get_array')) {
	function saveo_storage_get_array($var_name, $key, $key2='', $default='') {
		global $SAVEO_STORAGE;
		if (empty($key2))
			return !empty($var_name) && !empty($key) && isset($SAVEO_STORAGE[$var_name][$key]) ? $SAVEO_STORAGE[$var_name][$key] : $default;
		else
			return !empty($var_name) && !empty($key) && isset($SAVEO_STORAGE[$var_name][$key][$key2]) ? $SAVEO_STORAGE[$var_name][$key][$key2] : $default;
	}
}

// Set array element
if (!function_exists('saveo_storage_set_array')) {
	function saveo_storage_set_array($var_name, $key, $value) {
		global $SAVEO_STORAGE;
		if (!isset($SAVEO_STORAGE[$var_name])) $SAVEO_STORAGE[$var_name] = array();
		if ($key==='')
			$SAVEO_STORAGE[$var_name][] = $value;
		else
			$SAVEO_STORAGE[$var_name][$key] = $value;
	}
}

// Set two-dim array element
if (!function_exists('saveo_storage_set_array2')) {
	function saveo_storage_set_array2($var_name, $key, $key2, $value) {
		global $SAVEO_STORAGE;
		if (!isset($SAVEO_STORAGE[$var_name])) $SAVEO_STORAGE[$var_name] = array();
		if (!isset($SAVEO_STORAGE[$var_name][$key])) $SAVEO_STORAGE[$var_name][$key] = array();
		if ($key2==='')
			$SAVEO_STORAGE[$var_name][$key][] = $value;
		else
			$SAVEO_STORAGE[$var_name][$key][$key2] = $value;
	}
}

// Merge array elements
if (!function_exists('saveo_storage_merge_array')) {
	function saveo_storage_merge_array($var_name, $key, $value) {
		global $SAVEO_STORAGE;
		if (!isset($SAVEO_STORAGE[$var_name])) $SAVEO_STORAGE[$var_name] = array();
		if ($key==='')
			$SAVEO_STORAGE[$var_name] = array_merge($SAVEO_STORAGE[$var_name], $value);
		else
			$SAVEO_STORAGE[$var_name][$key] = array_merge($SAVEO_STORAGE[$var_name][$key], $value);
	}
}

// Add array element after the key
if (!function_exists('saveo_storage_set_array_after')) {
	function saveo_storage_set_array_after($var_name, $after, $key, $value='') {
		global $SAVEO_STORAGE;
		if (!isset($SAVEO_STORAGE[$var_name])) $SAVEO_STORAGE[$var_name] = array();
		if (is_array($key))
			saveo_array_insert_after($SAVEO_STORAGE[$var_name], $after, $key);
		else
			saveo_array_insert_after($SAVEO_STORAGE[$var_name], $after, array($key=>$value));
	}
}

// Add array element before the key
if (!function_exists('saveo_storage_set_array_before')) {
	function saveo_storage_set_array_before($var_name, $before, $key, $value='') {
		global $SAVEO_STORAGE;
		if (!isset($SAVEO_STORAGE[$var_name])) $SAVEO_STORAGE[$var_name] = array();
		if (is_array($key))
			saveo_array_insert_before($SAVEO_STORAGE[$var_name], $before, $key);
		else
			saveo_array_insert_before($SAVEO_STORAGE[$var_name], $before, array($key=>$value));
	}
}

// Push element into array
if (!function_exists('saveo_storage_push_array')) {
	function saveo_storage_push_array($var_name, $key, $value) {
		global $SAVEO_STORAGE;
		if (!isset($SAVEO_STORAGE[$var_name])) $SAVEO_STORAGE[$var_name] = array();
		if ($key==='')
			array_push($SAVEO_STORAGE[$var_name], $value);
		else {
			if (!isset($SAVEO_STORAGE[$var_name][$key])) $SAVEO_STORAGE[$var_name][$key] = array();
			array_push($SAVEO_STORAGE[$var_name][$key], $value);
		}
	}
}

// Pop element from array
if (!function_exists('saveo_storage_pop_array')) {
	function saveo_storage_pop_array($var_name, $key='', $defa='') {
		global $SAVEO_STORAGE;
		$rez = $defa;
		if ($key==='') {
			if (isset($SAVEO_STORAGE[$var_name]) && is_array($SAVEO_STORAGE[$var_name]) && count($SAVEO_STORAGE[$var_name]) > 0) 
				$rez = array_pop($SAVEO_STORAGE[$var_name]);
		} else {
			if (isset($SAVEO_STORAGE[$var_name][$key]) && is_array($SAVEO_STORAGE[$var_name][$key]) && count($SAVEO_STORAGE[$var_name][$key]) > 0) 
				$rez = array_pop($SAVEO_STORAGE[$var_name][$key]);
		}
		return $rez;
	}
}

// Inc/Dec array element with specified value
if (!function_exists('saveo_storage_inc_array')) {
	function saveo_storage_inc_array($var_name, $key, $value=1) {
		global $SAVEO_STORAGE;
		if (!isset($SAVEO_STORAGE[$var_name])) $SAVEO_STORAGE[$var_name] = array();
		if (empty($SAVEO_STORAGE[$var_name][$key])) $SAVEO_STORAGE[$var_name][$key] = 0;
		$SAVEO_STORAGE[$var_name][$key] += $value;
	}
}

// Concatenate array element with specified value
if (!function_exists('saveo_storage_concat_array')) {
	function saveo_storage_concat_array($var_name, $key, $value) {
		global $SAVEO_STORAGE;
		if (!isset($SAVEO_STORAGE[$var_name])) $SAVEO_STORAGE[$var_name] = array();
		if (empty($SAVEO_STORAGE[$var_name][$key])) $SAVEO_STORAGE[$var_name][$key] = '';
		$SAVEO_STORAGE[$var_name][$key] .= $value;
	}
}

// Call object's method
if (!function_exists('saveo_storage_call_obj_method')) {
	function saveo_storage_call_obj_method($var_name, $method, $param=null) {
		global $SAVEO_STORAGE;
		if ($param===null)
			return !empty($var_name) && !empty($method) && isset($SAVEO_STORAGE[$var_name]) ? $SAVEO_STORAGE[$var_name]->$method(): '';
		else
			return !empty($var_name) && !empty($method) && isset($SAVEO_STORAGE[$var_name]) ? $SAVEO_STORAGE[$var_name]->$method($param): '';
	}
}

// Get object's property
if (!function_exists('saveo_storage_get_obj_property')) {
	function saveo_storage_get_obj_property($var_name, $prop, $default='') {
		global $SAVEO_STORAGE;
		return !empty($var_name) && !empty($prop) && isset($SAVEO_STORAGE[$var_name]->$prop) ? $SAVEO_STORAGE[$var_name]->$prop : $default;
	}
}
?>