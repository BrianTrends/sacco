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
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'sacco' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
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
define( 'AUTH_KEY',         'XcW]_E0!0`$z6Q$3pP(C<gCE|%*A9!fhTo,:zB:k +&c^`::^iS-eU!H~8v#<54R' );
define( 'SECURE_AUTH_KEY',  'L;&srfUK`9en=cNrHG9yzKv~64m#xRGXT~FO}rw@{d]1bU(l1!~%tM)jby/C1a$2' );
define( 'LOGGED_IN_KEY',    'A9r>+~exg)&Z)(P&30F?j#<h,B5A,6n6L%i ,VP4Kn^y#m3%@CsEnzMeTpmcn?9R' );
define( 'NONCE_KEY',        '6|:#uF8Go.c+^>QtA*YimS[O{nD2-X>g`L6PP`uPheufje@;zv!J<f=sbbtab1r/' );
define( 'AUTH_SALT',        'XmZQ#w)b<J K|ovLB99<nM2?I#1 hu$=OC9ft3TqGP5EZ)`fQo,x:bKANB;-mmnz' );
define( 'SECURE_AUTH_SALT', 'Z;6l>c`xmTx Sg5!R<Tj@FC-<+7+]TkY4bx%gY3&CC,CCj+m{adecE!q^i~,9*)N' );
define( 'LOGGED_IN_SALT',   'V{w5FsWjjV{#|_)Orw}jet Dgq9XV7QqLme<^bo~j:-S.X-Y!rG!Ld>lP{}r,.Yi' );
define( 'NONCE_SALT',       'T.#ra]t#B/r0Dsd=0XEr4)$:zc]At#,}E7M!B{Sjt1~u9&1U(]CNT}S2mA[X0/53' );

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
