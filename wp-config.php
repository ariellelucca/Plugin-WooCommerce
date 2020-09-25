<?php
/**
 * As configurações básicas do WordPress
 *
 * O script de criação wp-config.php usa esse arquivo durante a instalação.
 * Você não precisa usar o site, você pode copiar este arquivo
 * para "wp-config.php" e preencher os valores.
 *
 * Este arquivo contém as seguintes configurações:
 *
 * * Configurações do MySQL
 * * Chaves secretas
 * * Prefixo do banco de dados
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar estas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define( 'DB_NAME', 'plugin_woocommerce' );

/** Usuário do banco de dados MySQL */
define( 'DB_USER', 'root' );

/** Senha do banco de dados MySQL */
define( 'DB_PASSWORD', '' );

/** Nome do host do MySQL */
define( 'DB_HOST', 'localhost' );

/** Charset do banco de dados a ser usado na criação das tabelas. */
define( 'DB_CHARSET', 'utf8mb4' );

/** O tipo de Collate do banco de dados. Não altere isso se tiver dúvidas. */
define( 'DB_COLLATE', '' );

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las
 * usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org
 * secret-key service}
 * Você pode alterá-las a qualquer momento para invalidar quaisquer
 * cookies existentes. Isto irá forçar todos os
 * usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'pZ|-bk4hjccS(Wl]@!$E;M(3tR0cPVADU%Y=iezc>{pJ=m6O!#%LO`VIiES~AM8.' );
define( 'SECURE_AUTH_KEY',  '`Aqth2gGN7,h6Dk07{:<qT??fX+lf`E}tQ<A)>CqIU(|1,dV fO*Fi}ob$EQu4iS' );
define( 'LOGGED_IN_KEY',    'U0w! {c~6g/S8W>%+B&K2?@VI2[za^Ay|N}M? 3Wn` {cYv nZ9xSwdE2Uh].WzA' );
define( 'NONCE_KEY',        '+#YeYx)u+1]8#]vOJgP0`x>>0?q54uicHTKafgjSHDnqFMvFwP}:l;Wr4[:UN#)k' );
define( 'AUTH_SALT',        'U^q{Bj;[@D:>9$EEDs8!3|w~p<GEUvVbhZjn U,5B%[<q^ux;tMT;j?}JtrM!#;V' );
define( 'SECURE_AUTH_SALT', '1cwh0B|v*T+U $$mwA2NPSx%A1cOYbOfxWYN;E|@rT:8%R`zv<CIm,,a7_KgGE7Q' );
define( 'LOGGED_IN_SALT',   'fC36Ka<hs_OsQ)N*zWi.%&B+b*KAB1Pnu|2t+E,r PViY~Z[H)G5Yba-Hh9vqLd=' );
define( 'NONCE_SALT',       '%3~AvbFzhFyuPalNtzyt<2KkV^ is2,fzE|m>KDb4C$R8wGnVrk=Zy}U`DAG|~Cz' );

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der
 * um prefixo único para cada um. Somente números, letras e sublinhados!
 */
$table_prefix = 'wp_';

/**
 * Para desenvolvedores: Modo de debug do WordPress.
 *
 * Altere isto para true para ativar a exibição de avisos
 * durante o desenvolvimento. É altamente recomendável que os
 * desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 *
 * Para informações sobre outras constantes que podem ser utilizadas
 * para depuração, visite o Codex.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Configura as variáveis e arquivos do WordPress. */
require_once ABSPATH . 'wp-settings.php';
