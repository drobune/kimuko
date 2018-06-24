<?php
/**
 * WordPress の基本設定
 *
 * このファイルは、MySQL、テーブル接頭辞、秘密鍵、ABSPATH の設定を含みます。
 * より詳しい情報は {@link http://wpdocs.sourceforge.jp/wp-config.php_%E3%81%AE%E7%B7%A8%E9%9B%86 
 * wp-config.php の編集} を参照してください。MySQL の設定情報はホスティング先より入手できます。
 *
 * このファイルはインストール時に wp-config.php 作成ウィザードが利用します。
 * ウィザードを介さず、このファイルを "wp-config.php" という名前でコピーして直接編集し値を
 * 入力してもかまいません。
 *
 * @package WordPress
 */

// 注意: 
// Windows の "メモ帳" でこのファイルを編集しないでください !
// 問題なく使えるテキストエディタ
// (http://wpdocs.sourceforge.jp/Codex:%E8%AB%87%E8%A9%B1%E5%AE%A4 参照)
// を使用し、必ず UTF-8 の BOM なし (UTF-8N) で保存してください。

// ** MySQL 設定 - この情報はホスティング先から入手してください。 ** //
/** WordPress のためのデータベース名 */
define('DB_NAME', 'wpress');

/** MySQL データベースのユーザー名 */
define('DB_USER', 'kimefCDLM');

/** MySQL データベースのパスワード */
define('DB_PASSWORD', 'wxCD67YZ67');

/** MySQL のホスト名 */
define('DB_HOST', 'fsv15816101.mysql.db.fsv.jp');

/** データベースのテーブルを作成する際のデータベースの文字セット */
define('DB_CHARSET', 'utf8');

/** データベースの照合順序 (ほとんどの場合変更する必要はありません) */
define('DB_COLLATE', '');

/**#@+
 * 認証用ユニークキー
 *
 * それぞれを異なるユニーク (一意) な文字列に変更してください。
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org の秘密鍵サービス} で自動生成することもできます。
 * 後でいつでも変更して、既存のすべての cookie を無効にできます。これにより、すべてのユーザーを強制的に再ログインさせることになります。
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '.l@`Y?q<%}{-AO^;rC:1ceN4YCsHkfJHR0LawRCN^{P_^c6YkG1T&,ei@cUCiV3Y');
define('SECURE_AUTH_KEY',  'QK@]qU J|M+aQqBHo`C.B=yg=_eX~~XN-lhJx3m nKIKA3;0fq|:N,:-.5wTYru|');
define('LOGGED_IN_KEY',    'Qw3NJ3Hh+[P;1*>C l=Hg .6nP%zU>X*5LzQnXq0-(K|c;xw{Kl)Rc|=DKT|;??(');
define('NONCE_KEY',        'C]-M{!sr|rhE-_k=C)4D}_|Q8,O_0:a%Ef+:-30k5`WY82RW)|bvK^k h,$<Nu_q');
define('AUTH_SALT',        '0+kL1b]|Zp6l9EliM@ FTvh[)M4q+6I:FG(E)Eo]i}rPT5qb5,r{G*5hA5Z8-g03');
define('SECURE_AUTH_SALT', 'O@y=+]KFn 2UUe+hX8}si)a;Ut8s>* (pVFAmC8zdK_0NuCSL3(9|{Sj0AkrtK)P');
define('LOGGED_IN_SALT',   '>H]G3~`b/DumI^tKB59N/BHP97erP-wm8Me=Y.IFB`]3~6CP4xQ+3Qc@OtZ;jK=W');
define('NONCE_SALT',       '+/SurD{vu?wq~jLEPh(He|=l2@5f>@`M}|-4ozk$>@AcBLF@EA*dtt[Fy+#*n&+F');

/**#@-*/

/**
 * WordPress データベーステーブルの接頭辞
 *
 * それぞれにユニーク (一意) な接頭辞を与えることで一つのデータベースに複数の WordPress を
 * インストールすることができます。半角英数字と下線のみを使用してください。
 */
$table_prefix  = 'wp_';

/**
 * 開発者へ: WordPress デバッグモード
 *
 * この値を true にすると、開発中に注意 (notice) を表示します。
 * テーマおよびプラグインの開発者には、その開発環境においてこの WP_DEBUG を使用することを強く推奨します。
 */
define('WP_DEBUG', false);
define('WP_ALLOW_MULTISITE', true);

define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', false);
define('DOMAIN_CURRENT_SITE', 'kimuko.net');
define('PATH_CURRENT_SITE', '/wpress/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);


/* 編集が必要なのはここまでです ! WordPress でブログをお楽しみください。 */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
