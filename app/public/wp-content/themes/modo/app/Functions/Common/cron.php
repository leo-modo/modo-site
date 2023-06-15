<?php

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

class Modo_Cron {

	public static $instance;

	public static function get_instance(): Modo_Cron {
		if ( self::$instance === null ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public static function manual_lancher($hook_name = ''){

		if(empty($hook_name)){
			return;
		}

		$event = (object) [
			'hook'      => $hook_name,
			'timestamp' => 1,
			'schedule'  => false,
			'args'      => [],
		];

		$crons = _get_cron_array();
		$key   = md5( serialize( $event->args ) );

		$crons[ $event->timestamp ][ $event->hook ][ $key ] = array(
			'schedule' => $event->schedule,
			'args'     => $event->args,
		);
		ksort( $crons );

		_set_cron_array( $crons );

		sleep( 1 );

		spawn_cron();

	}
}