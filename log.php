<?php

class Log extends Fuel\Core\Log
{
	/**
	 * Initialize the class
	 */
	public static function _init()
	{
		// load the file config
		\Config::load('file', true);

		// make sure the log directories exist
		try
		{
			// determine the name and location of the logfile
			$rootpath = \Config::get('log_path');
			$filename = $rootpath.date('Ymd').'.'.\Config::get('log_extension');

			// get the required folder permissions
			$permission = \Config::get('file.chmod.folders', 0777);

			if ( ! is_dir($rootpath))
			{
				mkdir($rootpath, 0777, true);
				chmod($rootpath, $permission);
			}

			$handle = fopen($filename, 'a');
		}
		catch (\Exception $e)
		{
			\Config::set('log_threshold', \Fuel::L_NONE);
			throw new \FuelException('Unable to create or write to the log file. Please check the permissions on '.\Config::get('log_path').'. ('.$e->getMessage().')');
		}

		if ( ! filesize($filename))
		{
			fwrite($handle, "<?php defined('COREPATH') or exit('No direct script access allowed'); ?>".PHP_EOL.PHP_EOL);
			chmod($filename, \Config::get('file.chmod.files', 0666));
		}
		fclose($handle);

		// create the monolog instance
		static::$monolog = new \Monolog\Logger('fuelphp');

		// create the streamhandler, and activate the handler
		$stream = new \Monolog\Handler\StreamHandler($filename, \Monolog\Logger::DEBUG);
		$formatter = new \Monolog\Formatter\LineFormatter("%level_name% - %datetime% --> %message%".PHP_EOL, "Y-m-d H:i:s");
		$stream->setFormatter($formatter);
		static::$monolog->pushHandler($stream);
	}

}
