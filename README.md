# CI Proxy Email

The purpose of this library is to allow users to specify a proxy while sending emails via SMTP.


### Installation

 - Copy the code into ci/application/libraries
 - Reset the class name to your class prefix and make sure to change the file name too
 - Create a ci/application/config/email.php

 ```php
$config['email_config']['proxy'] = 'proxy.domain.com:1234';
$config['email_config']['protocol'] = 'smtp';
$config['email_config']['smtp_host'] = '';
$config['email_config']['smtp_port'] = 587;
$config['email_config']['smtp_user'] = '';
$config['email_config']['smtp_pass'] = '';
$config['email_config']['smtp_crypto'] = 'tls';
$config['email_config']['newline'] = "\r\n";
$config['email_config']['mailtype'] = "html";
 ```
 - Use it in code like this:
 ```php
    $this->load->library('email');
    $email_options = $this->config->item('email_config');
    $this->email->initialize($email_options);
    $this->email->from($from);
    $this->email->to($to);
    //...
    $this->email->subject($subject);
    $this->email->message($body);
    $result = $this->CI->email->send();
 ```