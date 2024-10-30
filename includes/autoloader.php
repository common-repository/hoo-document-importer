<?php
namespace HooDocImporter;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * autoloader.
 */
class Autoloader {
    /**
	 * Default path for autoloader.
	 *
	 * @var string
	 */
	private static $default_path;

	/**
	 * Default namespace for autoloader.
	 *
	 * @var string
	 */
	private static $default_namespace;
	/**
	 * Run autoloader.
	 *
	 */
	public static function run( $default_path = '', $default_namespace = '' ) {
		if ( '' === $default_path ) {
			$default_path = HOO_DOC_IMPORTER_CLASSES_DIR;
		}

		if ( '' === $default_namespace ) {
			$default_namespace = __NAMESPACE__;
		}

		self::$default_path = $default_path;
		self::$default_namespace = $default_namespace;

		spl_autoload_register( [ __CLASS__, 'autoload' ] );
	}

    /**
	 * Autoload.
	 *
	 * For a given class, check if it exist and load it.
	 *
	 */
	private static function autoload( $class ) {
		if ( 0 !== strpos( $class, self::$default_namespace . '\\' ) ) {
			return;
		}

		$class = str_replace('\\', '/', $class);
		$vendor = substr($class, 0, strpos($class, '/'));
		$FileDir = str_replace($vendor, self::$default_path, $class);
        $classFile = $FileDir.'.php';

		if(is_file($classFile) && !class_exists($class)) include $classFile;
    }
}