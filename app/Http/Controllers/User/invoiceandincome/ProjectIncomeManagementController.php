<?php

namespace App\Http\Controllers\User\invoiceandincome;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Traits\FileAttachmentsTrait as FileUploader;
use App\Models\Bankaccounts;
use App\Models\customer_invoice_management;
use App\Models\Customer_project_income_invoices;
use App\Models\ProjectIncome;
use App\Traits\BankTransactionTrait;
use DataTables;
use Auth;
use Session;
use Exception;
use DB;

class ProjectIncomeManagementController extends Controller
{
    private $path    = 'user.invoicingincomemanagement.projectincomemanagement';
    private $authR   = 'project_income_management';
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

            return view($this->path.'.create',compact('projects','banks'));
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

      //  dd($request->all());
        if(Auth::user()->can($this->authR))
        {
            try{

                DB::beginTransaction(); 

                $amount = (float)str_replace(',', '', $request->cheque_amount);


                $project_income = new ProjectIncome();
                $project_income->title = $request->title;
                $project_income->project_id = $request->project_id;
                $project_income->cheque_receving_date = $request->cheque_receving_date;
                $project_income->received_cheque_bank = $request->received_cheque_bank;
                $project_income->cheque_clearing_date = $request->cheque_clearing_date;
                $project_income->cheque_number = $request->cheque_number;
                $project_income->cheque_amount = $amount;
                $project_income->cash_deposit_bank_id = $request->cash_deposit_bank_id;
                $project_income->difference_comments = $request->difference_comments;
                $project_income->bad_debt_amount = $request->bad_debt_amount;


                // saving images

                $new_images = [];
                
                if($request->hasfile('document_file'))
                {
                    foreach($request->file('document_file') as $image)
                    {
                        $filename = FileUploader::uploadFile($image,'projectIncome','project_income');
                        array_push($new_images,$filename);
                    }
                }
            
                $project_income->document_file = json_encode($new_images);
                
                if($project_income->save())
                {

                    ### adding amount in bank
                    if($project_income->cheque_amount > 0)
                    {
                        $bank = Bankaccounts::find($request->cash_deposit_bank_id);
                        $bank->current_balance = $bank->current_balance + $project_income->cheque_amount;
                        $bank->avaliable_funds =  $bank->avaliable_funds + $project_income->cheque_amount;
                        if($bank->save())
                        {   
                            $bank->refresh();
                            $user_id = Auth()->user()->id;
                            $transaction_log = BankTransactionTrait::logTransaction(
                                $bank->id,
                                $user_id,
                                $project_income->cheque_amount,
                                'credited',
                                $bank->avaliable_funds,
                                "Project Payment In",
                                0,
                                $project_income->cheque_amount,
                                $project_income->difference_comments,
                                $project_income->title,
                                $project_income->cheque_receving_date

                            );
                        }


                    }
                    ### adding amount in bank

                    if($request->invoice_check && count($request->invoice_check) > 0)
                    {
                        $invoice_numbers = array(); $invoice_amount = array(); $pending_balance = array();
                     
                        $invoice_number = $request->invoice_id;
                        $invoice_amount = $request->invoice_amount;
                        $pending_balance = $request->pending_balance;
                        foreach($invoice_number as $index=>$val)
                        {
                          
                            if($pending_balance[$index] == 0)
                            {
                                $customer_invoice = customer_invoice_management::where('invoice_number',$invoice_number[$index])->first();
                                
                                $customer_invoice->invoice_status = 'cleared';
                                $customer_invoice->save();

                                // saving project income
                                $customer_project_income = new Customer_project_income_invoices();
                                $customer_project_income->project_id = $request->project_id;
                                $customer_project_income->invoice_id =  $customer_invoice->id;
                                $customer_project_income->invoice_amount = $invoice_amount[$index];
                                $customer_project_income->pending_balance = 0;
                                $customer_project_income->status = 'cleared';
                                $customer_project_income->project_income_id = $project_income->id;
                              
                                $customer_project_income->save();

                            }
                            else{
                                $customer_invoice = customer_invoice_management::where('invoice_number',$invoice_number[$index])->first();
                               
                                // saving project income
                                $customer_project_income = new Customer_project_income_invoices();
                                $customer_project_income->project_id = $request->project_id;
                                $customer_project_income->invoice_id =  $customer_invoice->id;
                                $customer_project_income->invoice_amount = $invoice_amount[$index];
                                $customer_project_income->pending_balance = $pending_balance[$index];
                                $customer_project_income->status = 'pending';
                                $customer_project_income->project_income_id = $project_income->id;

                                $customer_project_income->save();
                            }
                        }

                      //  $invoice_number =
                    }

                    DB::commit();

                    Session::flash('success','Project Income Creaated successfully!');
                    return redirect()->route('projectincome.index');
                }
                

            }
            catch(Exception $e)
            {
                DB::rollback();
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
        //
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
            $project_income = ProjectIncome::find($id);
            
            $invoices = DB::table('customer_invoice_managements')
            ->join('customer_project_income_invoices','customer_invoice_managements.id','=','customer_project_income_invoices.invoice_id')
            ->where('customer_project_income_invoices.project_income_id','=',$id)
            ->select('customer_invoice_managements.invoice_number','customer_invoice_managements.invoice_status','customer_invoice_managements.total_after_deductions')->get();

       
        

            return view($this->path.'.edit',compact('projects','banks','project_income','invoices'));

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
            try{
                $id = decrypt($id);
                $project_income = ProjectIncome::find($id);
                $project_income->title = $request->title;
                $project_income->cheque_receving_date = $request->cheque_receving_date;
                $project_income->received_cheque_bank = $request->received_cheque_bank;
                $project_income->cheque_clearing_date = $request->cheque_clearing_date;
                $project_income->cheque_number = $request->cheque_number;
                $project_income->cheque_amount = $request->cheque_amount;
                $project_income->difference_comments = $request->difference_comments;
            
                ##updating images
            
                $images  = json_decode($project_income->document_file);
    
                $remove_images = [];
                $new_images    = [];
    
    
                if(isset($request->remove_images)){
                    $remove_images = explode(',',$request->remove_images);
                    foreach($remove_images as $img)
                    {
                        FileUploader::RemoveFile($img,'projectIncome');
                    }
                }
    
                if($request->hasfile('document_file'))
                {
                    foreach($request->file('document_file') as $image)
                    {
                        $filename = FileUploader::uploadFile($image,'projectIncome','project_income');
                        array_push($new_images,$filename);
                    }
                }
    
                if($project_income->document_file !=null){
                    foreach($images as $img)
                    {
                        if (!in_array($img,$remove_images)) {
                            array_push($new_images,$img);
                        }
                    }
                }
    
               
                $project_income->document_file = $new_images;
               ##updating images

               if($project_income->save())
               {
                   Session::flash('success','Project Income updated successfully!');
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

    public function getProjectsInvoices(Request $request){

        $project_id = $request->id;
        $customer_invoice = DB::table('customer_invoice_managements as cin')
        ->leftjoin('customer_project_income_invoices as in','cin.id','in.invoice_id')->where('cin.project_id',$project_id)->where('cin.invoice_status','pending')->get();
        //where(['cin.project_id'=>$project_id,'cin.invoice_status'=>'pending','in.status'=>'pending'])->get();
        

        //$customer_invoice = customer_invoice_management::where('project_id',$project_id)->where('invoice_status','pending')->get();
        // customer_invoice_management::where('project_id',$project_id)->where('invoice_status','pending')->
        // join()
        //get();

        $ids = $customer_invoice->pluck('id');

       // return $ids;

        if($customer_invoice)
        {
            return response()->json(['success' => true,'message' => $customer_invoice], 200);
        }
        else{
            return response()->json(['error' => true, 'message' =>"Customer Invoice not found"], 404);

        }
    } 
    
    public function getAjaxIndexIncome(Request $request){
        if (Auth::user()->can($this->authR))
        {
            if ($request->ajax()) {

                $data = ProjectIncome::orderby('id','desc')->get();

                return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                
                    $actionBtn = 
                    // <a href="'.route('projectincome.show',encrypt($row->id)).'"><i data-feather="eye" data-toggle="tooltip" data-placement="top" data-original-title="View"></i></a>&nbsp; &nbsp;
                    '<a href="'.route('projectincome.edit',encrypt($row->id)).'"><i data-feather="edit" data-toggle="tooltip" data-placement="top" data-original-title="Edit"></i></a>&nbsp; &nbsp;';
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
                    $checkBtn = $row->project->name;
                    return $checkBtn;
                })

                ->addColumn('check_receiving_date',function($row){
                    $checkBtn = date('d-M-Y',strtotime($row->cheque_receving_date));
                    return $checkBtn;
                    
                })

                ->addColumn('cheque_amount',function($row){
                    $checkBtn = $row->cheque_amount;
                    return 'PKR ' . $checkBtn;
                })

             
        
    
                ->rawColumns(['action','checkbox','title','project_id','check_receiving_date','cheque_amount'])
                ->make(true);

            }
        } 
        else{
            return redirect()->route('not_authorized');
        }
    }
}
