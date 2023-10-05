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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */
define('WP_HOME', 'https://trial.plugin-labs.com/');
define('WP_SITEURL', 'https://trial.plugin-labs.com/');

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'pluginla_trial_pluginla_laps' );

/** Database username */
define( 'DB_USER', 'pluginla_m_user' );

/** Database password */
define( 'DB_PASSWORD', 'v}OOy^=20*Id4t#TY3' );

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
define( 'AUTH_KEY',         '|]GqQ#%pV(zu2xdQNjRULfi+>w3C!]?]<AP?r=ItUjzJuo,4#qeK+2bdI?{lSuqZ' );
define( 'SECURE_AUTH_KEY',  '0[_<nDla]*A5-ghuKh!ZAJPB-GGd^G3lr(Zt7<?K47e[Yse(YX^dT0e6jgO7^}>b' );
define( 'LOGGED_IN_KEY',    'm_<PWg<u,H>uq, F`6{2Ai!z9Lx;~w7h&DR6r1)=|0=!s.LRe# sZhv,2P+948K4' );
define( 'NONCE_KEY',        'B[yAt>AjQ[Qtx^Z6StUYnPv~zZot*l 7qc89+U&1Bz&BDHYEa}8AE,2WyHbMFg]4' );
define( 'AUTH_SALT',        'BePSyYM_l.5ECTfi@[_x4.a~0_wTR${>Z}9{mYprZfxlL(@7X<wLbU^d%1L-{g,3' );
define( 'SECURE_AUTH_SALT', 'UmH7>#_:6xQb;0TK[,vt>mx#xT,z,LxZCFa~;:GK`IQ(KaAb/(r-_q2dyX>y=-d/' );
define( 'LOGGED_IN_SALT',   ':Do:2uUD?Ocrj[:}?c`|qxUHd7Zy.(npBXg]Ot9X_aU,,YS&{t<u^C:!yzO<*,g@' );
define( 'NONCE_SALT',       'F/NL.@K^;2s<tJ: E<tOlcKfD6-2Ai^;P(`fDoD:s2jKdz(@DAQ8hw3,=eGkO#v>' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'pl_';

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */

define('ALLOW_UNFILTERED_UPLOADS', true);

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';