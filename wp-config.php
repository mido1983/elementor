<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе установки.
 * Необязательно использовать веб-интерфейс, можно скопировать файл в "wp-config.php"
 * и заполнить значения вручную.
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
define( 'DB_NAME', 'elementor' );

/** Имя пользователя MySQL */
define( 'DB_USER', 'root' );

/** Пароль к базе данных MySQL */
define( 'DB_PASSWORD', '' );

/** Имя сервера MySQL */
define( 'DB_HOST', 'localhost' );

/** Кодировка базы данных для создания таблиц. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Схема сопоставления. Не меняйте, если не уверены. */
define( 'DB_COLLATE', '' );

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу. Можно сгенерировать их с помощью
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}.
 *
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными.
 * Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'r4L7f-k4lerkNmDlRcAVa28lP/qHB5xN2Cuzcthr9;16( sN4cWXCAmNxH:J*UPU' );
define( 'SECURE_AUTH_KEY',  '[%SZSWSzJT2ojS$bX5UhUz@1beb~gwDN_o;crUp!pok!XQ%~GWd,F1.#|6Q@iOb(' );
define( 'LOGGED_IN_KEY',    'X8Ze.o,1J*QIcM3].j(maxT>_UEd $bagyR5rSF]L_$EsG?q11z.DEV-JX<sl/]Z' );
define( 'NONCE_KEY',        'n$1GWABSek|H24,QMSHnOEiO23{z#u&7anWRWA2~^[+B>wvm~N<tQJ=Et9bb?oEh' );
define( 'AUTH_SALT',        '1]^suzY5>1j7w<|BAkl/YK]j8X9EP|D(<MH}%Q-QJ<qpv,W{vm*4M~6[hsh~ID?(' );
define( 'SECURE_AUTH_SALT', '4*Fge+VwA{tMS.|x;S@f[g``QrekA|;eT!Jh4Q4S $w,zsSVo!omYh(pVay{}xc=' );
define( 'LOGGED_IN_SALT',   'Q!9}q)u?}NO]vL,K%U~cPWlc u)2uU#`?t@4f-JIRnZHFexH9)5l|b@`oYHL,>Sy' );
define( 'NONCE_SALT',       'cB.44%t8MCt`3Oo>@Vp3QcogfGkra]i7 F){B-&^-/_DYTD6;HX{GOh9{nI,nv!?' );

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix = 'wp_';

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

/* Произвольные значения добавляйте между этой строкой и надписью "дальше не редактируем". */



/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once ABSPATH . 'wp-settings.php';
