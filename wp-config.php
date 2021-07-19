<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://ru.wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define( 'DB_NAME', 'pv_friendzona' );

/** Имя пользователя MySQL */
define( 'DB_USER', 'pv_friendzona' );

/** Пароль к базе данных MySQL */
define( 'DB_PASSWORD', '555666' );

/** Имя сервера MySQL */
define( 'DB_HOST', 'localhost' );

/** Кодировка базы данных для создания таблиц. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Схема сопоставления. Не меняйте, если не уверены. */
define( 'DB_COLLATE', '' );

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'li%5l[lxc(kg]_Qs^9N8hKg,u9^ecuzh| lLFexi!-U/hY1/dp9^WB9.wlPDXF^~' );
define( 'SECURE_AUTH_KEY',  '>,|~@#;yfZlMT5Y~Fo5x0rgbM^uI/lUvIB`~RmJmQGb!s8Y,LO5/]l}g;y&0i}:8' );
define( 'LOGGED_IN_KEY',    '[@H;66kVoEL9p^{@24e*V$YG*i`YV~Z$+wIN{Ysc,Wm;R$rwrj8!l.>Lj!!`bzE.' );
define( 'NONCE_KEY',        'X8x .S!4/Z8V%9]^G4>-Nwk{uh4~d*!n=2e,+)rSLdDbtms4!!Kt y4aNgmd%pki' );
define( 'AUTH_SALT',        'yK{[%k1J-`9},>,jmyYR_-OTKy#,37^PI{%F-v@p^%}2mz`kB{EV!HH<q}nR?FU^' );
define( 'SECURE_AUTH_SALT', '|2*jB}Q 97:-`byh6xm W9N]V/Chd3vm|6,cO{2Rnr20 *{/HyzId wl/.H|A*Oo' );
define( 'LOGGED_IN_SALT',   ';T2pEeuj-H5,`KgB,!jVMr*9PEIbdJZ=ez)P7O4wPGyx]l<ElM1DI`@J=BYsht-5' );
define( 'NONCE_SALT',       '+~=J]zEF>Pnt,orRs FaV%uD8p_rJnIN_G4,7qF,H_{ ^RL@:Bj<icw1S}M|U~) ' );

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix = 'wp_fz_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в документации.
 *
 * @link https://ru.wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once ABSPATH . 'wp-settings.php';
