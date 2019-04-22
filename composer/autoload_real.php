<?php

// autoload_real.php @generated by Composer
return ComposerAutoloaderInit30260c7069db57dc85d078d75ddef1a6::getLoader();

class ComposerAutoloaderInit30260c7069db57dc85d078d75ddef1a6
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInit30260c7069db57dc85d078d75ddef1a6', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader();
        spl_autoload_unregister(array('ComposerAutoloaderInit30260c7069db57dc85d078d75ddef1a6', 'loadClassLoader'));

        $useStaticLoader = PHP_VERSION_ID >= 50600 && !defined('HHVM_VERSION') && (!function_exists('zend_loader_file_encoded') || !zend_loader_file_encoded());
        if ($useStaticLoader) {
            require_once __DIR__ . '/autoload_static.php';

            call_user_func(\Composer\Autoload\ComposerStaticInit30260c7069db57dc85d078d75ddef1a6::getInitializer($loader));
        } else {
            $map = require __DIR__ . '/autoload_namespaces.php';
            foreach ($map as $namespace => $path) {
                $loader->set($namespace, $path);
            }

            $map = require __DIR__ . '/autoload_psr4.php';
            foreach ($map as $namespace => $path) {
                $loader->setPsr4($namespace, $path);
            }

            $classMap = require __DIR__ . '/autoload_classmap.php';
            if ($classMap) {
                $loader->addClassMap($classMap);
            }
        }

        $loader->register(true);

        if ($useStaticLoader) {
            $includeFiles = Composer\Autoload\ComposerStaticInit30260c7069db57dc85d078d75ddef1a6::$files;
        } else {
            $includeFiles = require __DIR__ . '/autoload_files.php';
        }
        foreach ($includeFiles as $fileIdentifier => $file) {
            composerRequire30260c7069db57dc85d078d75ddef1a6($fileIdentifier, $file);
        }

        return $loader;
    }
}

function composerRequire30260c7069db57dc85d078d75ddef1a6($fileIdentifier, $file)
{
    if (empty($GLOBALS['__composer_autoload_files'][$fileIdentifier])) {
        require $file;

        $GLOBALS['__composer_autoload_files'][$fileIdentifier] = true;
    }
}

class slimBrowscapConnector
{
	public static function get_browser_from_browscap( $_browser = array(), $_cache_path = '' ) {
		$fileCache = new \Doctrine\Common\Cache\FilesystemCache( $_cache_path );
		$cache = new \Roave\DoctrineSimpleCache\SimpleCacheAdapter( $fileCache );
		$browscap = new \BrowscapPHP\Browscap( $cache );

		try {
			$search_object = $browscap->getBrowser();
		}
		catch( Exception $e ) {
			$search_object = '';
		}

		if ( is_object( $search_object ) && $search_object->browser != 'Default Browser' && $search_object->browser != 'unknown' ) {
			$_browser[ 'browser' ] = $search_object->browser;
			$_browser[ 'browser_version' ] = floatval( $search_object->version );
			$_browser[ 'platform' ] = strtolower( $search_object->platform );

			// Browser Types:
			//      0: default (desktop, not touch)
			//      1: crawler
			//      2: mobile
			//		3: touch, not mobile
			if ( $search_object->ismobiledevice || $search_object->istablet ) {
				$_browser[ 'browser_type' ] = 2;
			}
			else if ( stripos( $search_object->device_pointing_method, 'touch' ) !== false ) {
				$_browser[ 'browser_type' ] = 3;	
			}
			else if ( !$search_object->crawler ) {
				$_browser[ 'browser_type' ] = 0;
			}
		}

		return $_browser;
	}
}