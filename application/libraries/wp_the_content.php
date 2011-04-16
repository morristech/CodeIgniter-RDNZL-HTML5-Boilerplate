<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class WP_The_Content{
	/**
	*	WP_The_Content, by Wes Broadway (wesbroadway@gmail.com)
	*	WP Version: 3.1.1
	*	Purpose: to provide some text-handling capabilities like Wordpress.
	*
	*	To that end, this is a verbatim copy/paste of 3 functions, but with two edits.
	*	File to copy from: (wordpress)/wp-includes/formatting.php
	*		Functions to copy
	*		-----------------
	*		function wpautop($pee, $br = 1), 							line 181
	*		function _autop_newline_preservation_helper($matches)		line 232
	*		function clean_pre($matches), 								line 154
	*
	*	Mods made: the wpautop() function uses preg_replace_callback to reference globally-scoped functions
	*	We'd like to use $this->method_name, so just change the 2nd parameter in preg_replace_callback (the 
	*	function name, as a string), to be like this: array(&$this, 'method_name'). That way we send $this to itself.
	*
	*	2 edits to be made, line number's reference wp-includes/formatting.php, as of this writing:
	*
	*	From line 211, change from this:
	*		$pee = preg_replace_callback('/<(script|style).*?<\/\\1>/s', '_autop_newline_preservation_helper', $pee);	
	*
	*		to this:
	*		$pee = preg_replace_callback('/<(script|style).*?<\/\\1>/s', array(&$this, '_autop_newline_preservation_helper'), $pee);
	*
	*	From line 218, change from this:
	*		$pee = preg_replace_callback('!(<pre[^>]*>)(.*?)</pre>!is', 'clean_pre', $pee );
	*
	*		to this:
	*		$pee = preg_replace_callback('!(<pre[^>]*>)(.*?)</pre>!is', array(&$this, 'clean_pre'), $pee );
	*
	*	That's it. Enjoy.
	*/

	/*---------------------------*/
	/* BEGIN WORDPRESS FUNCTIONS */
	/*---------------------------*/
	
	/**
	 * Replaces double line-breaks with paragraph elements.
	 *
	 * A group of regex replaces used to identify text formatted with newlines and
	 * replace double line-breaks with HTML paragraph tags. The remaining
	 * line-breaks after conversion become <<br />> tags, unless $br is set to '0'
	 * or 'false'.
	 *
	 * @since 0.71
	 *
	 * @param string $pee The text which has to be formatted.
	 * @param int|bool $br Optional. If set, this will convert all remaining line-breaks after paragraphing. Default true.
	 * @return string Text which has been converted into correct paragraph tags.
	 */
	function wpautop($pee, $br = 1) {
	
		if ( trim($pee) === '' )
			return '';
		$pee = $pee . "\n"; // just to make things a little easier, pad the end
		$pee = preg_replace('|<br />\s*<br />|', "\n\n", $pee);
		// Space things out a little
		$allblocks = '(?:table|thead|tfoot|caption|col|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|select|option|form|map|area|blockquote|address|math|style|input|p|h[1-6]|hr|fieldset|legend|section|article|aside|hgroup|header|footer|nav|figure|figcaption|details|menu|summary)';
		$pee = preg_replace('!(<' . $allblocks . '[^>]*>)!', "\n$1", $pee);
		$pee = preg_replace('!(</' . $allblocks . '>)!', "$1\n\n", $pee);
		$pee = str_replace(array("\r\n", "\r"), "\n", $pee); // cross-platform newlines
		if ( strpos($pee, '<object') !== false ) {
			$pee = preg_replace('|\s*<param([^>]*)>\s*|', "<param$1>", $pee); // no pee inside object/embed
			$pee = preg_replace('|\s*</embed>\s*|', '</embed>', $pee);
		}
		$pee = preg_replace("/\n\n+/", "\n\n", $pee); // take care of duplicates
		// make paragraphs, including one at the end
		$pees = preg_split('/\n\s*\n/', $pee, -1, PREG_SPLIT_NO_EMPTY);
		$pee = '';
		foreach ( $pees as $tinkle )
			$pee .= '<p>' . trim($tinkle, "\n") . "</p>\n";
		$pee = preg_replace('|<p>\s*</p>|', '', $pee); // under certain strange conditions it could create a P of entirely whitespace
		$pee = preg_replace('!<p>([^<]+)</(div|address|form)>!', "<p>$1</p></$2>", $pee);
		$pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee); // don't pee all over a tag
		$pee = preg_replace("|<p>(<li.+?)</p>|", "$1", $pee); // problem with nested lists
		$pee = preg_replace('|<p><blockquote([^>]*)>|i', "<blockquote$1><p>", $pee);
		$pee = str_replace('</blockquote></p>', '</p></blockquote>', $pee);
		$pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)!', "$1", $pee);
		$pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee);
		if ($br) {
			// modify preg_replace_callback as described above
			$pee = preg_replace_callback('/<(script|style).*?<\/\\1>/s', array(&$this, '_autop_newline_preservation_helper'), $pee);
			$pee = preg_replace('|(?<!<br />)\s*\n|', "<br />\n", $pee); // optionally make line breaks
			$pee = str_replace('<WPPreserveNewline />', "\n", $pee);
		}
		$pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*<br />!', "$1", $pee);
		$pee = preg_replace('!<br />(\s*</?(?:p|li|div|dl|dd|dt|th|pre|td|ul|ol)[^>]*>)!', '$1', $pee);
		if (strpos($pee, '<pre') !== false)
			// modify preg_replace_callback as described above
			$pee = preg_replace_callback('!(<pre[^>]*>)(.*?)</pre>!is', array(&$this, 'clean_pre'), $pee );
		$pee = preg_replace( "|\n</p>$|", '</p>', $pee );
	
		return $pee;
	}
	
	/**
	 * Newline preservation help function for wpautop
	 *
	 * @since 3.1.0
	 * @access private
	 * @param array $matches preg_replace_callback matches array
	 * @returns string
	 */
	function _autop_newline_preservation_helper( $matches ) {
		return str_replace("\n", "<WPPreserveNewline />", $matches[0]);
	}

	/**
	 * Accepts matches array from preg_replace_callback in wpautop() or a string.
	 *
	 * Ensures that the contents of a <<pre>>...<</pre>> HTML block are not
	 * converted into paragraphs or line-breaks.
	 *
	 * @since 1.2.0
	 *
	 * @param array|string $matches The array or string
	 * @return string The pre block without paragraph/line-break conversion.
	 */
	function clean_pre($matches) {
		if ( is_array($matches) )
			$text = $matches[1] . $matches[2] . "</pre>";
		else
			$text = $matches;
	
		$text = str_replace('<br />', '', $text);
		$text = str_replace('<p>', "\n", $text);
		$text = str_replace('</p>', '', $text);
	
		return $text;
	}

	/*---------------------------*/
	/* END WORDPRESS FUNCTIONS 	 */
	/*---------------------------*/
}


?>