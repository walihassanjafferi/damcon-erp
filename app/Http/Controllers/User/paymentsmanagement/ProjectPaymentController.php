<?php

namespace App\Http\Controllers\User\paymentsmanagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ProjectPayments;
use App\Models\Bankaccounts;
use App\Models\ErpCategories;
use App\Traits\FileAttachmentsTrait as FileUploader;
use App\Traits\BankTransactionTrait;
use DB;
use Session;
use Auth;

class ProjectPaymentController extends Controller
{
    
    private $path    = 'user.paymentmanagement.projectpayment';
    private $authR   = 'project_payments';
    private $folderN = 'projectPayment';
    private $fileN   = 'P_P';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can($this->authR))
        {
            $projectPayments = ProjectPayments::with('category','subCategory','main_category','bankAccount')->orderBy('id','DESC')->get();;
            return view($this->path.'.index', compact('projectPayments'));
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
            $categories = ErpCategories::where('module_name','project_cash_payment')->whereNull('parent_id')->whereNull('main_id')->select('id','category_name')->get();
            $accounts = Bankaccounts::all();
            $projects = Project::all();

            return view($this->path.'.add',compact('categories','accounts','projects'));
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
            DB::beginTransaction();

            try{
                $data    = $request->all();
                $account = Bankaccounts::find($data['account']);

                $amount =  (int)str_replace(',', '', $data['amount']);
                if($account->avaliable_funds >=  ($amount))
                {
                    $account->avaliable_funds = $account->avaliable_funds - $amount;
                    $account->current_balance = $account->current_balance - $amount;
                }
                else
                {
                    DB::rollback();
                    Session::flash('error', 'No sufficient balance for this transaction.');
                    return redirect()->back()->withInput($data);
                }

                $projectPayments = new ProjectPayments();
                $projectPayments->title          = $data['title'];
                $projectPayments->project_id     = $data['project_id'];
                $projectPayments->category_id    = $data['category_id'];
                $projectPayments->main_category_id = isset($data['main_category_id']) ? $data['main_category_id'] : null;
                $projectPayments->sub_category_id= isset($data['sub_category_id']) ? $data['sub_category_id'] : null;
                $projectPayments->paid_person = $data['paid_person'];
                $projectPayments->bank_id     = $data['account'];
                $projectPayments->amount	     = $amount;
                $projectPayments->transaction_date   = $data['payment_date'];
                $projectPayments->comment       = $data['comments'];


                $image_names=[];

                //Upload Files
                if($request->hasfile('document_file'))
                {
                    foreach($request->file('document_file') as $image)
                    {
                        $filename = FileUploader::uploadFile($image,$this->folderN,$this->fileN);
                        array_push($image_names,$filename);
                    }
                    $projectPayments->document_file  = json_encode($image_names);
                }

            if($projectPayments->save())
            {
             
            

                if($account->save())
                {   
                    $account->refresh();
                    $user_id = Auth()->user()->id;
                
                    
                    $transaction_log = BankTransactionTrait::logTransaction(
                        $account->id,
                        $user_id,
                        $projectPayments->amount,
                        'debited',
                        $account->avaliable_funds,
                        'Project payment',
                        $projectPayments->amount, //withdraw amount
                        0, //deposit amount
                        $projectPayments->comment, //comments
                        $projectPayments->title, //title
                        $projectPayments->transaction_date
                    );
                
                }
                ##adding bank transaction

            
                DB::commit();
                Session::flash('created', 'Project Payment Added Successfully');

                return redirect()->back();

            }
            
            }
            catch (\Exception $e){
                DB::rollback();
                Session::flash('error', $e->getMessage());
                return redirect()->back()->withErrors($e->getMessage())->withInput($data);
            }//end of catch
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
            $id =  decrypt($id);
            $projectPayments = ProjectPayments::find($id);

            return view($this->path.'.show',compact('projectPayments'));

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
            $id =  decrypt($id);
            $projectPayments = ProjectPayments::find($id);
            $accounts = Bankaccounts::all();
            $projects = Project::all();

            return view($this->path.'.edit',compact('projectPayments','accounts','projects'));
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
            DB::beginTransaction();
            try{
                $id = decrypt($id);
                $data = $request->all();
                $projectPayments = ProjectPayments::find($id);
                $projectPayments->title          = $data['title'];
                $projectPayments->paid_person = $data['paid_person'];
                $projectPayments->transaction_date   = $data['payment_date'];
                $projectPayments->comment       = $data['comments'];


                $images = json_decode($projectPayments->document_file);

                $remove_images = [];
                $new_images    = [];

                if(isset($request->remove_images)){
                    $remove_images = explode(',',$request->remove_images);
                    foreach($remove_images as $img)
                    {
                        FileUploader::RemoveFile($img,$this->folderN);
                    }
                }

                if($request->hasfile('document_file'))
                {
                    foreach($request->file('document_file') as $image)
                    {
                        $filename = FileUploader::uploadFile($image,$this->folderN,$this->fileN);
                        array_push($new_images,$filename);
                    }
                }

                if($projectPayments->document_file !=null){
                    foreach($images as $img)
                    {
                        if (!in_array($img,$remove_images)) {
                            array_push($new_images,$img);
                        }
                    }
                }
                $projectPayments->document_file = $new_images;

                //Save Files
                if($projectPayments->update())
                {
                    DB::commit();

                    // saving items
                    Session::flash('created', 'Project Payment Updated Successfully');
                    return redirect()->route('project_payment.index');
                }
                else{
                    Session::flash('error', 'Error updating Project Payments');
                    return redirect()->back()->withInput();
                }

                

            }
            catch(Exception $e)
            {
                DB::rollback();
                Session::flash('error',$e->getMessage());
                return redirect()->back();
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


    public function ajaxgeterpcategorybymodule(Request $request){
        
    
        $module_name = 'project_cash_payment';

        $category_select = $request->category_select;
        $category_id = $request->category_id;

        if($category_select == 'main')
        {   
            // getting parent categories
            $categories = ErpCategories::where('module_name',$module_name)->where('parent_id',$category_id)->whereNull('main_id')->select('id','category_name')->get();
        }

      
        else if($category_select == 'sub')
        {
            // getting main categories
            $categories = ErpCategories::where('module_name',$module_name)->where('main_id',$category_id)->select('id','category_name')->get();
        }
        // else if($category_select == 'sub_sub')
        // {
        //     $categories = ImprovedCategories::where('module_name',$module_name)->whereNull('parent_id')->whereNotNull('main_id')->whereNull('sub_id')->select('id','category_name')->get();

        // }


        return response()->json(['success' => true, 'categories' => $categories], 200);

    }
}
