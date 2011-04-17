<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Manage_users
 *
 * Extension of the Tank Auth Library, an Authentication library for Code Igniter.
 *
 */
class Manage_users extends Tank_Auth
{
	function get_users(){
		$users = $this->ci->users->get_users();
		return $users;
	}
}
?>