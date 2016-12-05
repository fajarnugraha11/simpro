<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class CustomEmail {

    protected $CI;

    function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->library('email');
    }

    // Default - using smtp mandrill
    public function send_email($from, $name_from, $email = array(), $cc = array(), $bcc = array(), $subject, $emailData, $template, $attachment_invoice = '',$attachment_eticket = '' ) {
        $config['protocol']     = 'smtp';
        $config['smtp_host']    = 'smtp.mandrillapp.com';
        $config['smtp_port']    =  587;
        $config['smtp_user']    = 'eka@isl.id';
        $config['smtp_pass']    = '3dFe1wBYhD0oMKMt2T2w3Q';
        $config['smtp_crypto']  = '';
        $config['charset']      = 'utf-8';
        $config['newline']      = "\r\n";
        $config['mailtype']     = 'html';

        $this->CI->email->initialize($config);
        $this->CI->email->from($from, $name_from);
        $this->CI->email->to($email);
        if(count($cc) > 0) $this->CI->email->cc($cc);
        if(count($bcc) > 0) $this->CI->email->bcc($bcc);
        $this->CI->email->subject($subject);
        $this->CI->email->message($this->CI->load->view($template, $emailData, TRUE));
        if($attachment_invoice !== ''){
            $this->CI->email->attach($attachment_invoice);
        }
        if($attachment_eticket !== ''){
            $this->CI->email->attach($attachment_eticket);
        }
        if($this->CI->email->send()) return true;
        else return false;
    }

    // Using Mailgun smptp
    public function send_email_($from, $name_from, $email = array(), $cc = array(), $bcc = array(), $subject, $emailData, $template, $attachment_invoice = '',$attachment_eticket = '' ) {

        $config['protocol']     = 'smtp';
        $config['smtp_host']    = 'smtp.mailgun.org';
        $config['smtp_port']    =  587;
        //$config['smtp_user']    = 'isl@sandbox01fe81f7d7894a50af60a47e787c1efd.mailgun.org';
        //$config['smtp_pass']    = 'isl123!';
        $config['smtp_user']    = 'isl.bersatu@gmail.com';
        $config['smtp_pass']    = 'ISLMailgun123!';
        //$config['crlf']         = '\n';
        $config['smtp_crypto']  = '';
        $config['charset']      = 'utf-8';
        $config['newline']      = "\r\n";
        $config['mailtype']     = 'html';

        $this->CI->email->initialize($config);
        $this->CI->email->from($from, $name_from);
        $this->CI->email->to($email);
        if(count($cc) > 0) $this->CI->email->cc($cc);
        if(count($bcc) > 0) $this->CI->email->bcc($bcc);
        $this->CI->email->subject($subject);
        $this->CI->email->message($this->CI->load->view($template, $emailData, TRUE));
        if($attachment_invoice !== ''){
            $this->CI->email->attach($attachment_invoice);
        }
        if($attachment_eticket !== ''){
            $this->CI->email->attach($attachment_eticket);
        }

        if($this->CI->email->send()) return true;
        else return false;
    }

//   public function send_mailgun_api(){
//    # Include the Autoloader (see "Libraries" for install instructions)
//           require 'vendor/autoload.php';
//       use Mailgun\Mailgun;
//    # Instantiate the client.
//           $mgClient = new Mailgun('YOUR_API_KEY');
//           $domain = "YOUR_DOMAIN_NAME";
//    # Make the call to the client.
//           $result = $mgClient->sendMessage($domain, array(
//               'from'    => 'Excited User <mailgun@YOUR_DOMAIN_NAME>',
//               'to'      => 'Baz <YOU@YOUR_DOMAIN_NAME>',
//               'subject' => 'Hello',
//               'text'    => 'Testing some Mailgun awesomness!'
//           ));
//
//   }


    // Using Google smptp
    public function send_email_noreply($from, $name_from, $email = array(), $cc = array(), $bcc = array(), $subject, $emailData, $template, $attach) {
        $config['protocol']     = 'smtp';
        $config['smtp_host']    = 'server42539x.maintenis.com';
        $config['smtp_port']    = '587';
        $config['smtp_timeout'] = '7';
        $config['smtp_user']    = 'noreply@mitrarenov.com';
        $config['smtp_pass']    = 'developer2016';
        $config['smtp_crypto']  = '';
        $config['charset']      = 'utf-8';
        $config['mailtype']     = 'html';
		$config['crlf'] = '\r\n';      //should be "\r\n"
		$config['newline'] = '\r\n';   //should be "\r\n"
        $this->CI->email->initialize($config);
        $this->CI->email->from($from, $name_from);
        $this->CI->email->to($email);
        if(count($cc) > 0) $this->CI->email->cc($cc);
        if(count($bcc) > 0) $this->CI->email->bcc($bcc);
        $this->CI->email->subject($subject);
        $this->CI->email->message($template);
		
		if($attach != ""){
			$this->CI->email->attach($attach);
        }
        $this->CI->email->attach("pantotukang/attachment/syarat.pdf");

        //if($this->CI->email->send()) echo  "true".$this->CI->email->print_debugger();
        //else  echo "false".$this->CI->email->print_debugger();
        if($this->CI->email->send()) return true;
        else return false;
    }
	
	public function send_email_info($from, $name_from, $email = array(), $cc = array(), $bcc = array(), $subject, $emailData, $template) {
        $config['protocol']     = 'smtp';
        $config['smtp_host']    = 'ssl://smtp.zoho.com';
        $config['smtp_port']    = '465';
        $config['smtp_timeout'] = '7';
        $config['smtp_user']    = 'noreply@tomonno.com';
        $config['smtp_pass']    = 'noreply%55';
        $config['smtp_crypto']  = '';
        $config['charset']      = 'utf-8';
        $config['newline']      = "\r\n";
        $config['mailtype']     = 'html';
        $this->CI->email->initialize($config);
        $this->CI->email->from($from, $name_from);
        $this->CI->email->to($email);
        if(count($cc) > 0) $this->CI->email->cc($cc);
        if(count($bcc) > 0) $this->CI->email->bcc($bcc);
        $this->CI->email->subject($subject);
        $this->CI->email->message($template);
		
        if($this->CI->email->send()) echo  "true".$this->CI->email->print_debugger();
        else  echo "false".$this->CI->email->print_debugger();
    }
}