<?php
/**
 * Plugin Name: Plugin para WooCommerce
 * Description: Plugin que adiciona o status 'Enviado' na lista
 * Version: 1.0
 * Author: Arielle Verri Lucca
 * Author URI: https://github.com/ariellelucca
 */

// Função para criar o status 'Enviado'
function register_status_enviado(){
    register_post_status('wc-status-enviado', array(
        'label'                     => 'Enviado',
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'Enviado (%s)', 'Enviado (%s)')
    ) );
}

// Inicia a função register_status_enviado()
add_action('init', 'register_status_enviado');



// Função para criar o status personalizado
function add_status_enviado($array_status) {
 
    // Array auxiliar para a chave do status
    $array_status_aux = array();
 
    // Adiciona os status de ordem
    foreach ($array_status as $key => $status) {
        $array_status_aux[$key] = $status;
        if ('wc-processing' === $key) {
            $array_status_aux['wc-status-enviado'] = 'Enviado';
        }
    }

    
    return $array_status_aux;
}
add_filter('wc_order_statuses', 'add_status_enviado');

