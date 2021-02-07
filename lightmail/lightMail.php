<?php
   /**
   * PHP lightMail
   *
   * Send mail in a simple quick way with the PHP mail() function
   *
   * @package    lightMail
   * @author     Nildo Pontes <nildo.pontes@bol.com.br>
   * @version    1.0
   * @license    GNU General Public License v3.0
   *
   */
   class lightMail{
      public $sender;
      public $nameSender;
      public $receiver;
      public $subject;
      public $message;
      public $attachment = '';
      public $boundary = '_myBoundaryLightMail_';
      public $headers;
      public function __construct($sender, $receiver, $subject, $nameSender){
         $this->sender = $sender;
         $this->receiver = $receiver;
         $this->subject = $subject;
         $this->nameSender = $nameSender;
      }
      public function send(){
         if(strlen($this->headers) == 0){
            if(strlen($this->attachment) != 0){
               $this->headers = "From: ".$this->nameSender." <".$this->sender.">\r\nReply-To: <".$this->sender.">\r\nReturn-Path: ".$this->sender."\r\nMIME-Version: 1.0\r\nX-Priority: 3\r\nContent-type: multipart/mixed;\r\n boundary=\"".$this->boundary."\";\r\n charset=utf-8\r\nContent-Transfer-Encoding: 7bit\r\n\r\n\r\n";
            }else{
               $this->headers = "From: ".$this->nameSender." <".$this->sender.">\r\nReply-To: <".$this->sender.">\r\nReturn-Path: ".$this->sender."\r\nMIME-Version: 1.0\r\nX-Priority: 3\r\nContent-type: text/html;\r\n charset=utf-8\r\nContent-Transfer-Encoding: 7bit\r\n\r\n";
            }
         }
         if(strlen($this->attachment) > 0){
            $this->message = "--".$this->boundary."\r\nContent-Type: text/html;\r\n charset=UTF-8\r\nContent-Transfer-Encoding: 7bit\r\n\r\n".$this->message;
            $this->message .= $this->attachment."--".$this->boundary."--";
         }
         return mail($this->receiver, $this->subject, $this->message, $this->headers);
      }
      public function addAttachment($fileName){
         $mime = mime_content_type($fileName);
         $fp = fopen($fileName, 'rb');
         $data = fread($fp, filesize($fileName));
         $data = base64_encode($data);
         fclose($fp);
         $data = chunk_split($data);
         $cache = "--".$this->boundary."\r\nContent-Type: ".$mime.";\r\n charset=UTF-8\r\nContent-Transfer-Encoding: base64\r\nContent-Disposition: attachment;\r\n filename=\"".array_reverse(explode('/', $fileName))[0]."\"\r\nfilename: ".array_reverse(explode('/', $fileName))[0]."\r\n\r\n".$data."\r\n\r\n";
         $this->attachment .= $cache;
      }
      public function removeAllAttachment(){
         $this->attachment = '';
      }
      public function setMessage($msg){
         $this->message = $msg."\r\n";
      }
      public function modifyBoundary($newBundary){
         $this->boundary = $newBundary;
      }
      public function modifyHeaders($newHeaders){
         $this->headers = $newHeaders;
      }
   }
   /*
   *
   * Usage:
   *
   * include('lightMail.php');
   *
   * $sender = 'example@mail.com';
   * $nameSender = 'Name Sender';
   * $receiver = 'receiver@mail.com';
   * $subject = 'Subject example';
   *
   * $mail = new lightMail($sender, $receiver, $subject, $nameSender);
   * $mail->setMessage('<p>My HTML message.</p>');
   * $mail->addAttachment('file1.mp3');
   * $mail->addAttachment('file2.mp3');
   * $rtr = $mail->send();
   *
   * if($rtr){
   *    echo 'Sucess!\n';
   * }else{
   *    echo 'Error\n';
   * }
   *
   */
?>