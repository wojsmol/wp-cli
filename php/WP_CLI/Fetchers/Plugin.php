<?php

namespace WP_CLI\Fetchers;

class Plugin extends Base {

	protected $msg = "The '%s' plugin could not be found.";

	public function get( $name ) {
		$plugins = get_plugins( '/' . $name );

		// some-plugin/the-plugin.php
		while ( !empty( $plugins ) ) {
			$file = key( $plugins );
			array_shift( $plugins );

			// ignore files inside a plugin's subdirectory (like WP does)
			if ( dirname( $file ) == '.' ) {
				$plugin = new \WP_CLI\Plugin( $name . '/' . $file );
				$plugin->name = $name;
				return $plugin;
			}
		}

		// some-plugin.php
		$file = $name . '.php';

		$plugins = get_plugins();

		if ( isset( $plugins[ $file ] ) ) {
			$plugin = new \WP_CLI\Plugin( $file );
			$plugin->name = $name;
			return $plugin;
		}

		return false;
	}
}

