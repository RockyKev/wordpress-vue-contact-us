<?php
// https://wordpress.stackexchange.com/questions/344009/how-to-use-phpmailer-in-a-function-in-wordpress

// CREATE AN ACCOUNT IN SENDGRID
//

function send_smtp_email( $phpmailer ) {
    $phpmailer->isSMTP();
    $phpmailer->Host       = 'smtp.sendgrid.net';
    $phpmailer->Port       = '587';
    $phpmailer->SMTPSecure = 'tls';
    $phpmailer->SMTPAuth   = true;
    $phpmailer->Username   = 'apikey';
    $phpmailer->Password   = '11111111';
    $phpmailer->From       = 'from@example.com';
    $phpmailer->FromName   = 'From Name';
    $phpmailer->addReplyTo('info@example.com', 'Information');
}

function set_my_mail_content_type() {
    return "text/html";
}

function send_email_function() {

    $to = 'kev.rocky@gmail.com';
    $subject = 'Here is the subject';
    $message = 'This is the HTML message body <b>in bold!</b>';

    add_filter( 'wp_mail_content_type','set_my_mail_content_type' );
    add_action( 'phpmailer_init', 'send_smtp_email' );

    wp_mail( $to, $subject, $message );

    remove_filter( 'wp_mail_content_type','set_my_mail_content_type' );
    remove_action( 'phpmailer_init', 'send_smtp_email' );
}

add_shortcode('send-email', 'send_email_function');


function insertSecretKey() {

    global $wpdb;
    $tableName = $wpdb->usermeta;
    $tableData = [
        'user_id' => 1,
        'meta_key' => "chonky_cat",
        'meta_value' => "OH LAWD, he coming!"
];

    $wpdb->insert($tableName, $tableData);
    // $record_id = $wpdb->insert_id;

    echo "SHould be done7";
}
add_shortcode('insert-secret-key', 'insertSecretKey');
