<?php

// Se for acessado diretamente, não executa
if ( ! defined( 'ABSPATH' ) ) exit;

// Classe que extende WC_Email e dá acesso aos métodos da classe de email do WooCommerce
class WC_Expedited_Order_Email extends WC_Email {
    // Construtor
    public function __construct() {

        // Define o ID da configuração
        $this->id = 'wc_expedited_order';

        // Define o título da configuração
        $this->title = 'Expedited Order';

        // Define a descrição da configuração
        $this->description = 'Expedited Order Notification';

        // Define o cabeçalho e a mensagem
        $this->heading = 'Expedited Order';
        $this->subject = 'Expedited Order';

        // Define os layouts de envio de email
        $this->template_html  = 'emails/customer-expedited-order.php';
        $this->template_plain = 'emails/plain/admin-new-order.php';

        // Define o email do cliente como verdadeiro
        $this->customer_email = true;

        // Dispara o email quando o status for 'enviado'. 
        add_action( 'woocommerce_order_status_pending_to_sent', array( $this, 'trigger' ), 10, 2 );;
        add_action( 'woocommerce_order_status_processing_to_sent', array( $this, 'trigger' ), 10, 2 );
        add_action( 'woocommerce_order_status_failed_to_sent', array( $this, 'trigger' ), 10, 2 );
        add_action( 'woocommerce_order_status_on-hold_to_sent', array( $this, 'trigger' ), 10, 2 );
        add_action( 'woocommerce_order_status_cancelled_to_sent', array( $this, 'trigger' ), 10, 2 );
        add_action( 'woocommerce_order_status_completed_to_sent', array( $this, 'trigger' ), 10, 2 );

        // Chama o construtor
        parent::__construct();

        // Pega as informações do destinatário
        $this->recipient = $this->get_option( 'recipient' );

        // Se não há destinatário configurado, envia para o próprio admin
        if ( ! $this->recipient )
            $this->recipient = get_option( 'admin_email' );
      
    }


    public function get_default_subject() {
        return __( '[{site_title}]: Expedited order #{order_number}', 'woocommerce' );
    }

    public function get_default_heading() {
        return __( 'Expedited order: #{order_number}', 'woocommerce' );
    }

    public function get_default_additional_content() {
        return __( 'Your order has been expedited.', 'woocommerce' );
    }

    public function trigger( $order_id, $order = false ) {
        $this->setup_locale();

        if ( $order_id && ! is_a( $order, 'WC_Order' ) ) {
            $order = wc_get_order( $order_id );
        }

        if ( is_a( $order, 'WC_Order' ) ) {
            $this->object                         = $order;
            $this->placeholders['{order_date}']   = wc_format_datetime( $this->object->get_date_created() );
            $this->placeholders['{order_number}'] = $this->object->get_order_number();
        }

        if ( $this->is_enabled() && $this->get_recipient() ) {
            $this->send( $this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments() );
        }

        $this->restore_locale();
    }
    
    // Função que seleciona o template/conteúdo do email em html
    public function get_content_html() {
        ob_start();
        woocommerce_get_template( $this->template_html, array(
            'order'         => $this->object,
            'email_heading' => $this->get_heading()
        ) );
        return ob_get_clean();
    }

    // Função que seleciona o template/conteúdo do email em texto plano
    public function get_content_plain() {
        ob_start();
        woocommerce_get_template( $this->template_plain, array(
            'order'         => $this->object,
            'email_heading' => $this->get_heading()
        ) );
        return ob_get_clean();
    }

    // Função que inicializa os campos do formulário
    public function init_form_fields() {

        $this->form_fields = array(
            'enabled'    => array(
                'title'   => 'Enable/Disable',
                'type'    => 'checkbox',
                'label'   => 'Enable this email notification',
                'default' => 'yes'
            ),
            'recipient'  => array(
                'title'       => 'Recipient(s)',
                'type'        => 'text',
                'description' => sprintf( 'Enter recipients (comma separated) for this email. Defaults to <code>%s</code>.', esc_attr( get_option( 'admin_email' ) ) ),
                'placeholder' => '',
                'default'     => ''
            ),
            'subject'    => array(
                'title'       => 'Subject',
                'type'        => 'text',
                'description' => sprintf( 'This controls the email subject line. Leave blank to use the default subject: <code>%s</code>.', $this->subject ),
                'placeholder' => '',
                'default'     => ''
            ),
            'heading'    => array(
                'title'       => 'Email Heading',
                'type'        => 'text',
                'description' => sprintf( __( 'This controls the main heading contained within the email notification. Leave blank to use the default heading: <code>%s</code>.' ), $this->heading ),
                'placeholder' => '',
                'default'     => ''
            ),
            'email_type' => array(
                'title'       => 'Email type',
                'type'        => 'select',
                'description' => 'Choose which format of email to send.',
                'default'     => 'html',
                'class'       => 'email_type',
                'options'     => array(
                    'plain'     => 'Plain text',
                    'html'      => 'HTML', 'woocommerce',
                    'multipart' => 'Multipart', 'woocommerce',
                )
            )
        );
    }
}