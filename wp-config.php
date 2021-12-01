<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
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
define( 'DB_NAME', 'eductr_db' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'vbFl$;WY-M^U%YLt)e7{`M3S,F~|nl?*SLsijdDaX<mW857,se<EGW_v:) gNAM9' );
define( 'SECURE_AUTH_KEY',  '=%OByeHQ%k^<usSm>1p@I&;;w-7w|KO>1^;V`md-O@NcRb38~OuKFpU{G*%jD?wV' );
define( 'LOGGED_IN_KEY',    'p5`wINC$bbw*zClP<]IEk*I[ynLF<1YFzL$.18v1z`Y8Bb10p7,YRS_%A#O&VZNC' );
define( 'NONCE_KEY',        '%Ytuje)e-kk4.O5M!}?lHWHGu?+aXI~gv{`AaKDiYxrf*H._^}RoVFSR@XMrvcK[' );
define( 'AUTH_SALT',        ':ISra}yu<vlW[8tdH26K ]H_TXIPq+Ua70UBex-.4wi_.RE}DG}gc5s.qIu?mOvO' );
define( 'SECURE_AUTH_SALT', '*$7_8#V?m*Vp3+2G.pIA(xH$;zSflbtP}UeFt(<[Z^&.w558}pUGopk,>kw>}Et}' );
define( 'LOGGED_IN_SALT',   '(13M>Le)k/ir,]cM6O}moe q8<rLIk&3afiYc)3m1Ej$E9-7KB%QSzCVWgf0X>&e' );
define( 'NONCE_SALT',       'QV,]Si*/2BDp*i8OZ[IR9q4~X2^8`%+>?V2Swjwtu9}g^zrWIb=7~B#*8T%&kdm1' );

/**#@-*/

/**
 * WordPress database table prefix.
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

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
