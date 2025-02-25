<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'grazeanddeli' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '1HvETn6y57y3DQH1dQn4DWSsMUdqxgKG7tsSdaP4f13c7CSBlO3D1TiptqUsJceT');
define('SECURE_AUTH_KEY',  'ww0w9QJuLRa8OGxreuRu4b6BKBHDnJKaoafvxeauspfvlokwtWrjubcvzKk8kVD4');
define('LOGGED_IN_KEY',    'jPwTid4yevoFmdw1U6k00avg8xbnGow5nVMs3HfauFrQUhKVWoJFDiIpwAXVE7GN');
define('NONCE_KEY',        'BdTqHV8sjDicBQti3okZMfpMSHyVNNGh8pLetJLpJwPhVkpMTBfjnD0hniXc1aAP');
define('AUTH_SALT',        'Rd2ESb51pJcu6aAzUmi9gqu9JadLLVUJb2H03Uitg1W8dqT2kH7Ujlur4BQqjXC4');
define('SECURE_AUTH_SALT', 'VpEv1x16YtabrmfnM7dbBVD9SvmDTfIfaIg0w5MCnf8H5Xmz35kzQ5kk60Fg8o6X');
define('LOGGED_IN_SALT',   'LnuCtUjdkUK2iQEhQhZWtdgSQqN7bENDsgjiHHtlFRqD2nNMFfRh8gjlFQXWs7Ps');
define('NONCE_SALT',       'ly4yAVpMAOZVOgAywVamcfwqHdvcslKBm1Tx9E492ys7Ny0QCmynfJYRufWUW4ex');

/**
 * Other customizations.
 */
define('FS_METHOD','direct');
define('FS_CHMOD_DIR',0755);
define('FS_CHMOD_FILE',0644);
define('WP_TEMP_DIR',dirname(__FILE__).'/wp-content/uploads');

/**
 * Turn off automatic updates since these are managed externally by Installatron.
 * If you remove this define() to re-enable WordPress's automatic background updating
 * then it's advised to disable auto-updating in Installatron.
 */
define('AUTOMATIC_UPDATER_DISABLED', true);


/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
