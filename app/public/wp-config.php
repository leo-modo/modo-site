<?php
define( 'WP_CACHE', false ); // Added by WP Rocket

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'kF1OT2aLgEG47yMibaMpZo5aUTBMr5ClErfJvQot5IRu9j5P1Jw7lTwtQLs3Ael1zOllbrdW41TSdsxn75lypg==');
define('SECURE_AUTH_KEY',  'kGFuq48drnHU9hOdYAZ1PMWJCKpW4EI2py5c/q1naFc5RMYnWfqaxL/WhfCNbMjl9Zktj2V8WmOUPnOTc4zNpw==');
define('LOGGED_IN_KEY',    'tXlk3d/5Y6G9DVd1SRQsefQqd5+I6YxGa7uWgUEJKfeTXfrGCD+C5k3pyGNzCIiMHUMepmwJAtTFwwZ8ZMeDXA==');
define('NONCE_KEY',        'Aiwkm8DML29L6pNF5On4feDbxM2Fc7Gxbz/QVT2ue0Z71jF1MrhiHnBATQGUhrbN4ra0/IvFG2lVMo8eG+ljVw==');
define('AUTH_SALT',        'slxPSLiQI6miWgEkCxZEZKgvphkEu2HNmCRu4YJmkWZmPKxqoyednc9sf7BK+PzPo33ATuoN5YYsTb4Cz1XvUg==');
define('SECURE_AUTH_SALT', 'Rqd6LSBRp+yEwSUVwKg4ZHOTk+LVBNU2GC2DBDbNSX7XUT/i0BXRUAuQJEtg8OrwvtSM3W3kLvRWWSzfazMaVg==');
define('LOGGED_IN_SALT',   'gRflG0uA02WROTAYaZmsBiy0pHAKarQv4iIRJUxR0h1Vc1DnZBZjbbmJvHo2iao4xlNS6azMe+Fcw0numn0VNw==');
define('NONCE_SALT',       'fOhc0k9vLaBXGq/Ws/1EIYyyW2hje72FfH5xAQMbtLJRdGYIZe9mERBgQzZX5vhm8hM+mZcf/1bS+ncebNynUw==');


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'modo_';


/* Add any custom values between this line and the "stop editing" line. */



/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', true );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
