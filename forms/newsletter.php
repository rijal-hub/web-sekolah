<?php
  $receiving_email_address = 'contact@example.com';

  if( file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php' )) {
    include( $php_email_form );
  } else {
    die( 'Unable to load the "PHP Email Form" Library!');
  }

  $contact = new PHP_Email_Form;
  $contact->ajax = true;
  
  $contact->to = $receiving_email_address;
  $contact->from_name = "Pengguna";
  $contact->from_email = "noreply@example.com";
  $contact->subject = "Kritik & Saran Baru";

  $contact->add_message( $_POST['feedback'], 'Pesan');

  echo $contact->send();
?>
