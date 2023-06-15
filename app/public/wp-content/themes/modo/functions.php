<?php

declare( strict_types=1 );

namespace App;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require __DIR__ . '/vendor/autoload.php';

use App\Site\Theme;

Theme::get_instance();