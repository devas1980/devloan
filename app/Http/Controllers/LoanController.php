<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\loan_requested;
use App\Models\loan_emi;
use App\Models\User;
use Dompdf\Dompdf;
require_once 'dompdf/autoload.inc.php';

use App\Http\Controllers\MailController;

class LoanController extends Controller
{
   public function loan_apply(Request $request)
   {
      $obj= new loan_requested();
      $obj->user_id='1';
      $obj->loan_amount = $request->loan_amount;
      $obj->loanstatus=$request->loanstatus;
      $obj->loan_applied_date=date('Y-m-d H:i:s');
      $obj->loan_approval_date=date('Y-m-d H:i:s');
      $obj->loan_time_period = $request->loan_time_period;
      $obj->loan_rate_intrest="10";
       
        //dd($obj);
        
       $Appval = $obj->save();

       /* $data = array('id'=>'1',
                
                 'loan_amount'=> "5455",
                  'loan_applied_date'=> date('Y-m-d H:i:s'),
                 'loanstatus'=> '1',
                 'loan_approval_date'=>  date('Y-m-d H:i:s'),
                 
            );
            loan_requested::insert($data); // Eloquent approach*/
   }
   
   public function loan_approve(Request $request)
   {
     
       \DB::statement("update loan_requested SET loan_approval_date='".date("Y-m-d H:i:s")."',loanstatus='1' where id='".$request->loan_id."' ");
	   
	   $loan_requested = loan_requested::with('users')->where('id',$request->loan_id)
       ->get()->toArray();

		//dd($loan_requested);
		
		/********* create emi **********/
		$emidate = date("Y-m").-01;
	   $loan_id = $loan_requested[0]['id'];
       $amount = $loan_requested[0]['loan_amount'];
       $time_period = $loan_requested[0]['loan_time_period'];
       $interest_rate = $loan_requested[0]['loan_rate_intrest'];
       $amount_withinterest =  $amount + (($amount * $interest_rate)/100);
       $loan_months = (int)$time_period * 12; // monthly
       $permonth_emi = round(((int)$amount_withinterest/(int)$loan_months));

      //previous records delte
       loan_emi::where('loan_id',$loan_requested[0]['id'])->delete();
       for($p=1; $p<=$loan_months; $p++)
       {
			$newdate = strtotime("+$p month", strtotime($emidate));
            $emi_payment_duedate = date("Y-m-d", $newdate);

            $data[] = array('loan_id'=>$loan_id,
                 'emi_amount'=> $permonth_emi,
                 'emi_due_date'=> $emi_payment_duedate,
                 'emi_payment_status'=> '0',
                 'emi_payment_detils'=> '0',
            );
       }
	  // dd($data);
      loan_emi::insert($data); // EMI 
	  /******End emi*****/
	  
	  /********create pdf file**********/
	   $dompdf = new Dompdf(array('enable_remote' => true));
        $path = 'loanpdf/';
        $filename = date('Ymdi')."_".$loan_id;
        $path2 = $path.$filename.'.pdf';
 
        $content = '
        <strong>!!Loan Approved!!</strong>
        <p>Dear xxxx,<br>Loan applicaion has been approved, please find the details bellow.<br></p>

        <table width="100%" border="1">
        <tr>
        <th  width="20%" align="left">EMI Amount</th>
        <th  width="20%" align="left">EMI Duedate</th>
        <th  width="30%" align="left">Payment Status</th>
        </tr>';

       for($p=1; $p<=$loan_months; $p++)
        {
            $emi_status='';
            $emi_status='Pending';

			$newdate = strtotime("+$p month", strtotime($emidate));
            $emi_payment_duedate = date("Y-m-d", $newdate);
			
            $content.= '<tr>
            <td>'.$permonth_emi.'</td>
            <td>'.$emi_payment_duedate.'</td>
            <td>'.$emi_status.'</td>
            </tr>';
        } 

        $content.= '</table><br><br>Sincerely,<br>xxxxxxxxxxxxx</body></html>';
 
        //dd($content);    
        
        $dompdf->loadHTML($content);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $output = $dompdf->output();
        file_put_contents($path2, $output);
		/********End create pdf file**********/
		
		/*****Mail Send*******/
		
		$data = [
            'name'=>'xxxx',
			"fromname"=>"DevLoan",
			"fromemail"=>"devas1980@gmail.com",
			"emailsubject"=>"Your Loan Application Approval",
			"path"=>$path2,
			"name"=>$loan_requested[0]['users']['name'],
			"email"=>$loan_requested[0]['users']['email']
        ];
		MailController::send_email($data);
		
		/*****End Mail Send*******/
		
		
	
   }
   
   
   
   function adminlogin(Request $request)
    {
         
       $user = new User();
       
       $admin=$user->where([
       'email' => $request->email,
       'password' => md5($request->password),
       'role_id' => '1'
        ])->get();

         if(count($admin)>0)
        {
            $adname = ($admin[0]['name']);
            $adid = ($admin[0]['id']);
            $ademail = ($admin[0]['email']);
           /* Session::put('adminName', $adname);
            Session::put('adminEmail', $ademail);
            Session::put('adminId', $adid);*/
           
            $response=[
               'success'=>true,
               'message'=>' Admin User and Password Successfully'
               
   
              ];
              return response()->json($response,200); 
        }
        else
        {
         
             $response=[
            'success'=>false,
            'message'=>'Missmatch Admin User and Password'
            

           ];
           return response()->json($response,201); 
        }    
    }
   
   
}
