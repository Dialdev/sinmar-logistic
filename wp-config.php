<?php
// ** SpaceWeb technical domain BEGIN **
if (strpos($_SERVER['HTTP_HOST'], '.swtest.ru') !== false) {
    if (!defined('WP_HOME')) define('WP_HOME','http://' . $_SERVER['HTTP_HOST'] . '');
    if (!defined('WP_SITEURL')) define('WP_SITEURL', 'http://' . $_SERVER['HTTP_HOST'] . '');
}
// ** SpaceWeb technical domain END **
    
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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */
define('DISABLE_WP_CRON', true);
define('WP_MEMORY_LIMIT', '512');
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'sinmar_2017');

/** MySQL database username */
define('DB_USER',       '042020006_2017');

/** MySQL database password */
define('DB_PASSWORD',       'SinMar1720');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',       'WI(gCUvS%2%#!LmuPa)yOpk(8zuZ9V^mFcMi)hWWM03BnPK^lzFJeSLw#h0!2ZEF');
define('SECURE_AUTH_KEY',       'yegB4qIG8f8)xopKt3Fot%N3kgGw%l%d47QK3k81rBtUkMQdK%F&89uZp04fu5Y%');
define('LOGGED_IN_KEY',       '2o^mQzxEwLYG!aAJd8&Ws%ShRF4KkwaJsPZN)JJ#L#Ao7@@DXKUPv(FBwJ9BLX&u');
define('NONCE_KEY',       'Bv#%QHcBTVkaMqPHDLk9UALo%fzFsn^MUxAvITUa*SaDN%D6EEvOA#i&#QWRe6vf');
define('AUTH_SALT',       '!90xH5dtcdHvmw)XfpUwI9VCEE9Q6LpgilY5X#yaIoIZ5xLkmkr7tTbP4S7nRl2*');
define('SECURE_AUTH_SALT',       '2Mhhc1NDsBJzxd%FtjM#XgTxf*&PjRZa^NAIVHk^x7ZDkER!wWF1OKC0B0y)YMtH');
define('LOGGED_IN_SALT',       'fbtY4MT9i!DVR3dq(#YCp!9u!OPzVNutWi)fsY(nm#GCrVWvYcGvRkN^ZNLrojU0');
define('NONCE_SALT',       'TyveLxKTL)les1zMax(BR^PUi8w0@VgXBpkMFUba%J&JYsvsL1@I#LvTjX4Zc^(l');
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

define( 'WP_ALLOW_MULTISITE', true );

define ('FS_METHOD', 'direct');
?>