<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

/**
 * Extends the Email library provided by codeigniter by supporting proxies for SMTP connections
 * */
class My_Email extends CI_Email {

  /**
   * SMTP Connect
   *
   * @access  protected
   * @return  string
   */
  protected function _smtp_connect() {
    $ssl = NULL;
    if ($this->smtp_crypto == 'ssl')
      $ssl = 'ssl://';
    $CI =& get_instance();

    if(!empty($this->proxy)) {
      $context = stream_context_create(['http' => ['proxy' => 'tcp://' . $this->proxy]]);
      $this->_smtp_connect = stream_socket_client($ssl.$this->smtp_host . ':' . $this->smtp_port,
                    $errno,
                    $errstr,
                    $this->smtp_timeout,
                    STREAM_CLIENT_CONNECT,
                    $context);
    }
    else {
      $this->_smtp_connect = fsockopen($ssl.$this->smtp_host,
                    $this->smtp_port,
                    $errno,
                    $errstr,
                    $this->smtp_timeout);
    }

    if ( ! is_resource($this->_smtp_connect))
    {
      $this->_set_error_message('lang:email_smtp_error', $errno." ".$errstr);
      return FALSE;
    }

    $this->_set_error_message($this->_get_smtp_data());

    if ($this->smtp_crypto == 'tls')
    {
      $this->_send_command('hello');
      $this->_send_command('starttls');
      stream_socket_enable_crypto($this->_smtp_connect, TRUE, STREAM_CRYPTO_METHOD_TLS_CLIENT);
    }

    return $this->_send_command('hello');
  }

}