<?php

namespace App\Http\Controllers\User\invoiceandincome;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\FileAttachmentsTrait as FileUploader;
use App\Models\Project;
use App\Models\Bankaccounts;
use App\Models\AdvanceHrPayment;
use App\Models\Misc_income;
use App\Traits\BankTransactionTrait;
use App\Models\ErpCategories;
use DataTables;
use Auth;
use Session;
use Exception;
use DB;

class MiscIncomeController extends Controller
{
    private $path = 'user.invoicingincomemanagement.miscincomemanagement';
    private $authR   = 'misc-income-management';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can($this->authR))
        {
            return view($this->path.'.index');
        }
        else{
            return redirect()->route('not_authorized');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->can($this->authR))
        {
            $projects = Project::where('status',1)->pluck('name','id')->toArray();
            $banks = Bankaccounts::all();
            $advance_hr = AdvanceHrPayment::all();
            $categories = DB::table('erp_categories as a')->where('a.module_name','mic_income')->get();


            return view($this->path.'.create',compact('projects','banks','advance_hr','categories'));
        }
        else{
            return redirect()->route('not_authorized');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->can($this->authR))
        {
            try{

                $amount = (float)str_replace(',', '', $request->cheque_amount);

            
                $misc_income = new Misc_income();
                $misc_income->title = $request->title;
                $misc_income->misc_date = $request->misc_date;
                $misc_income->income_type = $request->income_type;
                if($request->has('advance_hr_payment_id'))
                {
                    $misc_income->advance_hr_payment_id = $request->advance_hr_payment_id;
                }
                $misc_income->project_id = $request->project_id;
                $misc_income->mode_of_payment = $request->mode_of_payment;
                if($request->mode_of_payment == 'cheque')
                {
                    $misc_income->cheque_receving_date = $request->cheque_receving_date;
                    $misc_income->received_cheque_bank = $request->received_cheque_bank;
                    $misc_income->cheque_clearing_date = $request->cheque_clearing_date;
                    $misc_income->cheque_number = $request->cheque_number;
                }
                $misc_income->cheque_amount =  $amount;
                $misc_income->cash_deposit_bank_id = $request->cash_deposit_bank_id;
                $misc_income->outward_payment_id = $request->outward_payment_id;
                $misc_income->misc_income_detail = $request->misc_income_detail;
                $misc_income->outward_payment_comments = $request->outward_payment_comments;

                // saving images
    
                $new_images = [];
                    
                if($request->hasfile('document_file'))
                {
                    foreach($request->file('document_file') as $image)
                    {
                        $filename = FileUploader::uploadFile($image,'MiscIncome','misc_income');
                        array_push($new_images,$filename);
                    }
                }
              
                $misc_income->document_file = json_encode($new_images);

                if($misc_income->save())
                {

                      ##depositing cheque in bank
                      $bank = Bankaccounts::find($misc_income->cash_deposit_bank_id);
                      $bank->current_balance = $bank->current_balance + $misc_income->cheque_amount;
                      $bank->avaliable_funds =  $bank->avaliable_funds + $misc_income->cheque_amount;
                      if($bank->save())
                      {   
                          $bank->refresh();
                          $user_id = Auth()->user()->id;
                          $transaction_log = BankTransactionTrait::logTransaction(
                              $bank->id,
                              $user_id,
                              $misc_income->cheque_amount,
                              'credited',
                              $bank->avaliable_funds,
                              $request->title,
                              0,
                              $misc_income->cheque_amount,
                              $misc_income->outward_payment_comments,
                              $misc_income->title,
                              $misc_income->misc_date
                            );
                      }
                       ##depositing cheque in bank


                    Session::flash('success','Misc Income Created successfully!');
                    return redirect()->route('miscincome.index');
                }
                else{
                    Session::flash('success','Error Occured!');
                    return redirect()->back()->withInput();
                }
            }
            catch(Exception $e)
            {
                Session::flash('error',$e->getMessage());
                return redirect()->back()->withInput();
            }
        }
        else{
            return redirect()->route('not_authorized');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::user()->can($this->authR))
        {
            try{
                $id = decrypt($id);
                $misc_income = Misc_income::find($id);
                return view($this->path.'.view',compact('misc_income'));

            }
            catch(Exception $e){
                Session::flash('error',$e->getMessage());
                return redirect()->back();
            }
        }
        else{
            return redirect()->route('not_authorized');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->can($this->authR))
        {   
            $id = decrypt($id);
            $projects = Project::where('status',1)->pluck('name','id')->toArray();
            $banks = Bankaccounts::all();
            $advance_hr = AdvanceHrPayment::all();
            $misc_income = Misc_income::find($id);
            $categories = DB::table('erp_categories as a')->where('a.module_name','mic_income')->get();


           
            return view($this->path.'.edit',compact('projects','banks','advance_hr','misc_income','categories'));
        }
        else{
            return redirect()->route('not_authorized');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(Auth::user()->can($this->authR))
        {
            try
            {
                $id = decrypt($id);
                $misc_income = Misc_income::find($id);
                $misc_income->misc_date = $request->misc_date;
                $misc_income->income_type = $request->income_type;
                if($request->has('advance_hr_payment_id'))
                {
                    $misc_income->advance_hr_payment_id = $request->advance_hr_payment_id;
                }
                $misc_income->project_id = $request->project_id;
                //$misc_income->mode_of_payment = $request->mode_of_payment;
                if($misc_income->mode_of_payment == 'cheque')
                {
                    $misc_income->cheque_receving_date = $request->cheque_receving_date;
                    $misc_income->received_cheque_bank = $request->received_cheque_bank;
                    $misc_income->cheque_clearing_date = $request->cheque_clearing_date;
                    $misc_income->cheque_number = $request->cheque_number;
                }
               // $misc_income->cheque_amount = $request->cheque_amount;
                //$misc_income->cash_deposit_bank_id = $request->cash_deposit_bank_id;
                $misc_income->outward_payment_id = $request->outward_payment_id;
                $misc_income->misc_income_detail = $request->misc_income_detail;
                $misc_income->outward_payment_comments = $request->outward_payment_comments;

                ##updating images
            
                 $images = json_decode($misc_income->document_file);
    
                 $remove_images = [];
                 $new_images    = [];
     
     
                 if(isset($request->remove_images)){
                     $remove_images = explode(',',$request->remove_images);
                     foreach($remove_images as $img)
                     {
                         FileUploader::RemoveFile($img,'MiscIncome');
                     }
                 }
     
                 if($request->hasfile('document_file'))
                 {
                     foreach($request->file('document_file') as $image)
                     {
                         $filename = FileUploader::uploadFile($image,'MiscIncome','misc_income');
                         array_push($new_images,$filename);
                     }
                 }
     
                 if($misc_income->document_file !=null){
                     foreach($images as $img)
                     {
                         if (!in_array($img,$remove_images)) {
                             array_push($new_images,$img);
                         }
                     }
                 }
     
                
                 $misc_income->document_file = $new_images;
                
                ##updating images

                if($misc_income->save())
                {
                    Session::flash('success','Misc Income updated successfully!');
                    return redirect()->back();

                }
                else{
                    Session::flash('error','Error Updating Misc Income');
                    return redirect()->back();
                }

            }
            catch(Exception $e)
            {
                Session::flash('error',$e->getMessage());
                return redirect()->back()->withInput();
            }
        
        }
        else{
            return redirect()->route('not_authorized');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getAjaxMiscIncome(Request $request){
        if (Auth::user()->can($this->authR))
        {
            if ($request->ajax()) {

                $data = Misc_income::orderby('id','desc')->get();

                return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                
                    $actionBtn = '<a href="'.route('miscincome.show',encrypt($row->id)).'"><i data-feather="eye" data-toggle="tooltip" data-placement="top" data-original-title="View"></i></a>&nbsp; &nbsp;
                    <a href="'.route('miscincome.edit',encrypt($row->id)).'"><i data-feather="edit" data-toggle="tooltip" data-placement="top" data-original-title="Edit"></i></a>&nbsp; &nbsp;';
                    // <a  onclick="deleteItem('.$row->id.')"><i data-feather="delete" data-toggle="tooltip" data-placement="top" data-original-title="Delete"></i></a>';
                    return $actionBtn;
                })->addColumn('checkbox',function($row){
                    $checkBtn = '<input type="checkbox" class="item_check"  value="'.$row->id.'">';
                    return $checkBtn;
                })
                ->addColumn('title',function($row){
                    $checkBtn = $row->title;
                    return $checkBtn;
                })
                ->addColumn('project_id',function($row){
                    $checkBtn = $row->project->name ?? 'Not found!';
                    return $checkBtn;
                })

                ->addColumn('check_receiving_date',function($row){
                    if($row->mode_of_payment == 'cheque')
                    {   
                        $checkBtn = date('d-M-Y',strtotime($row->cheque_receving_date));
                    }
                    else {
                        $checkBtn = 'Not Found!';
                    }
                    return $checkBtn;
                    
                })

                ->addColumn('cheque_amount',function($row){
                    $checkBtn =  number_format($row->cheque_amount);
                    return  $checkBtn;
                })

                ->addColumn('income_type',function($row){
                    $checkBtn = ErpCategories::find($row->income_type)->category_name ?? 'N/A';
                    // '<span style="text-transform:capitalize;">'.$row->income_type.'</span>';
                    return $checkBtn;
                })

                ->addColumn('mode_of_payment',function($row){
                    $checkBtn = $row->mode_of_payment;
                    return $checkBtn;
                })

            
                ->rawColumns(['action','checkbox','title','project_id','check_receiving_date','cheque_amount','income_type','mode_of_payment'])
                ->make(true);

            }
        } 
        else{
            return redirect()->route('not_authorized');
        }
    }
}
