<?php

namespace WP_CLI;

/**
 * The missing plugin class, to complement WP_Theme.
 */
class Plugin {

	public $file;
	public $name;
	public $details;

	function __construct( $file ) {
		$this->file = $file;
	}

	/**
	 * Converts a plugin basename back into a friendly slug.
	 */
	public function get_name() {
		if ( !is_null( $this->name ) )
			return $this->name;

		if ( false === strpos( $this->file, '/' ) )
			$name = basename( $this->file, '.php' );
		else
			$name = dirname( $this->file );

		return $name;
	}

	public function get_status() {
		if ( is_plugin_active_for_network( $this->file ) )
			return 'active-network';

		if ( is_plugin_active( $this->file ) )
			return 'active';

		return 'inactive';
	}

	public function get_details() {
		if ( !is_null( $this->details ) )
			return $this->details;

		$plugin_folder = get_plugins(  '/' . plugin_basename( dirname( $this->file ) ) );
		$plugin_file = basename( $this->file );

		return $plugin_folder[$plugin_file];
	}
}

