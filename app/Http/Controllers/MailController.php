<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Mail;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MailController extends Controller {
		
   public function send_email($data) {
      $data = array('name'=>"Loan Application");
      Mail::send('mail', $data, function($message) {
         $message->to('devas1980@gmail.com', 'Your Loan Has been Appoved')->subject
            ('Loan Application Mail with Attachment');
         $message->attach($data['path']);
         $message->from('devas1980@gmail.com','Dev Loan Application');
      });
      echo "Mail Sent Sucessfully with this Attachment.";
   }
}