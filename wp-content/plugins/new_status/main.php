<?php
/**
 * Plugin Name: Plugin para WooCommerce
 * Description: Plugin que adiciona o status 'Enviado' na lista
 * Version: 1.0
 * Author: Arielle Verri Lucca
 * Author URI: https://github.com/ariellelucca
 */

// Função de internacionalização
function new_status_init(){
    $plugin_dir = basename(dirname(__FILE__)).'/languages';
    load_plugin_textdomain('new_status', false, $plugin_dir);
}
add_action('plugins_loaded', 'new_status_init');

// Função que adiciona o css do plugin
function new_status_stylesheet() {
    $plugin_dir = plugin_dir_url( __FILE__ );

    wp_enqueue_style( 'new_status_style',  $plugin_dir . "/css/style.css");
}
add_action( 'wp_enqueue_scripts', 'new_status_stylesheet' );

// Função para criar o status 'Enviado'
function register_status(){
    register_post_status('wc-sent', array(
        'label'                     => 'Enviado',
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'Enviado (%s)', 'Enviado (%s)')
    ) );
}

// Inicia a função register_status()
add_action('init', 'register_status');

// Função para criar o status personalizado
function add_sent_status($array_status) {
 
    // Array auxiliar para a chave do status
    $array_status_aux = array();
 
    // Adiciona os status de ordem
    foreach ($array_status as $key => $status) {
        $array_status_aux[$key] = $status;
        if ('wc-processing' === $key) {
            $array_status_aux['wc-sent'] = 'Sent';
        }
    }
   
    return $array_status_aux;
}
add_filter('wc_order_statuses', 'add_sent_status');

// Função que mostra o status no front end
function show_status($order_id){
    echo '<h2>'. esc_html__( 'Order Status', 'new_status' ). '</h2>';
    echo '<div class="center">';
    echo '<div class="order-status">';
    echo '<div class="order-status-timeline">';
    echo '<div class="order-status-timeline-completion"></div>';
    echo '</div>';
    $order_id = $order_id['ordem'];
    $my_order = wc_get_order( $order_id );
    
    // Array com os status
    $statuses = array(
        'pending',
        'processing',
        'on-hold',
        'sent',
        'completed'
    );

    $done = true;

    // Percorre o array de status até encontrar o atual
    $percent = 0;
    foreach ( $statuses as $status ) {
        if ( $done ) {
            $left = $percent;
            $aux = '';
            $status_name = wc_get_order_status_name( $status );
            echo '<div class="image-order-status image-order-status-new img-circle" style="left: '.$left.'%">';
            echo '<div class="icon"><i class="fas fa-check"></i></div>';
            echo '<span class="status">'.$status_name.'</span>';
            echo '</div>';
        }
    
        if ( $status === $my_order->get_status() ) {
            $done = false;            
        }

        if ($done === false){
            if ($status !== $my_order->get_status()){
                $left = $percent;
                $aux = '';
                $status_name = wc_get_order_status_name( $status );
                echo '<div class="image-order-nokstatus image-order-status-new img-circle" style="left: '.$left.'%">';
                echo '<div class="icon"></div>';
                echo '<span class="status">'.$status_name.'</span>';
                echo '</div>';
            }
        }
        // adiciona a distancia entre cada div de status
        $percent += 23;
    }
    echo '</div>';
    echo '</div>';
}
add_shortcode( 'shortcode_status', 'show_status' );

// Função de emails para novo status
function add_custom_mail_woocommerce( $email_classes ) {
    // Inclui a classe
    require( 'includes/custom-mail.php' );

    // Adiciona o email para as classes de email do WooCommerce
    $email_classes['WC_Expedited_Order_Email'] = new WC_Expedited_Order_Email();

    return $email_classes;

}
add_filter( 'woocommerce_email_classes', 'add_custom_mail_woocommerce' );


function email_subject_sent_order( $formated_subject, $order ){
    // Executa se a ordem tiver status 'enviada'
    if( $order->has_status('sent') ) 
        return  $formated_subject; 

    return sprintf( esc_html__( 'Your order had been expedited #%s', 'textdomain'), $order->get_id() );
    
}
add_filter( 'woocommerce_email_subject_sent_order', 'email_subject_sent_order', 10, 2 );