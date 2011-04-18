<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Blog
 *
 * This model represents blog data. It operates the following tables:
 * - blog
 * - blog_meta
 *
 * @package	RDNZL_Blog
 * @author	Wes Broadway (http://wesbroadway.com)
 */
class Blog extends CI_Model
{
	private $table_name			= 'blog';		// main blog posts data
	private $meta_table_name	= 'blog_meta';	// blog post meta data
}

