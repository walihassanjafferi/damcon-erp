<?php

namespace App\Http\Controllers\User\taxationmanagement;

use App\Models\Taxation_bodies;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\TaxBodyLedger;
use Session;
use DataTables;

class TaxBodiesController extends Controller
{

    private $path    = 'user.taxationmanagement.tax_bodies_management';
    private $authR   = 'tax_bodies_modules';


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::user()->can($this->authR))
        {
            if ($request->ajax()) {

                $data = Taxation_bodies::orderby('id','desc')->get();

                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                        $actionBtn = '<a href="'.route('tax_bodies.show',encrypt($row->id)).'"><i data-feather="eye" data-toggle="tooltip" data-placement="top" data-original-title="View"></i></a>&nbsp; &nbsp;
                                      <a href="'.route('tax_bodies.edit',encrypt($row->id)).'"><i data-feather="edit" data-toggle="tooltip" data-placement="top" data-original-title="Edit"></i></a>&nbsp; &nbsp;
                                      <a  onclick="deleteOrder('.$row->id.')"><i data-feather="delete" data-toggle="tooltip" data-placement="top" data-original-title="Delete"></i></a>';
                        return $actionBtn;
                    })->addColumn('checkbox',function($row){
                        $checkBtn = '<input type="checkbox" class="order_check"  value="'.$row->id.'">';
                        return $checkBtn;
                    })
                    ->rawColumns(['action','checkbox'])
                    ->make(true);
            }else{

                return view($this->path.'.index');
            }

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
                return view($this->path.'.create');
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
    public function store(Request $r)
    {

        if(Auth::user()->can($this->authR))
        {
            try {
                $tax_body                                       = new Taxation_bodies();
                $tax_body->name                                 = $r->name;
                $tax_body->sales_tax_percentage_items           = $r->sale_tax_item;
                $tax_body->sales_tax_percentage_services        = $r->sale_tax_services;
                // $tax_body->sales_tax_withheld_source_percentage = $r->source_percentage;
                $tax_body->rule_creation_date                   = $r->modification_date;
                $tax_body->comments_about_law                   = $r->comments;
                $tax_body->description                          = $r->details_input ?? "";
                $tax_body->withholding_items                         = $r->withholding_items ?? 0;
                $tax_body->withholding_services                      = $r->withholding_services ?? 0;

                //Save Files
                if($tax_body->save())
                {
                    Session::flash('created', 'Tax Body Added Successfully');
                    return redirect()->route('tax_bodies.index');
                }
                else{
                    Session::flash('error', 'Error adding Tax Body');
                    return redirect()->back()->withInput();
                }

            }catch(Exception $e){
                Session::flash('error', 'Error adding Tax Body');
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
            $tax_body = Taxation_bodies::find(decrypt($id));
            $tax_ledgers = TaxBodyLedger::where('tax_body_id',$tax_body->id)->get();

            return view($this->path.'.view',compact('tax_body','tax_ledgers'));
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
            $tax_body = Taxation_bodies::find(decrypt($id));
            return view($this->path.'.edit',compact('tax_body'));
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
    public function update(Request $r, $id)
    {
       
        if(Auth::user()->can($this->authR))
        {
            try {
                $tax_body                                       = Taxation_bodies::find(decrypt($id));
                $tax_body->name                                 = $r->name;
                $tax_body->sales_tax_percentage_items           = $r->sale_tax_item;
               // $tax_body->sales_tax_percentage_services        = $r->sale_tax_services;
                $tax_body->sales_tax_withheld_source_percentage = $r->source_percentage;
                $tax_body->rule_creation_date                   = $r->modification_date;
                $tax_body->comments_about_law                   = $r->comments;
                $tax_body->description                          = $r->details_input ?? "";
                $tax_body->withholding_items                         = $r->withholding_items ?? 0;
                $tax_body->withholding_services                      = $r->withholding_services ?? 0;

                //Save Files
                if($tax_body->update())
                {
                    Session::flash('created', 'Tax Body Updated Successfully');
                    return redirect()->route('tax_bodies.index');
                }
                else{
                    Session::flash('error', 'Error updating Tax Body');
                    return redirect()->back()->withInput();
                }

            }catch(Exception $e){
                Session::flash('error', 'Error updating Tax Body');
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
    public function destroy($id, Request $request)
    {
        if(Auth::user()->can($this->authR))
        {
            try {
                $id = $request->id;
                $tax_body = Taxation_bodies::find($id);
                if($tax_body)
                {
                    $tax_body->delete();
                    return response()->json(['success' => true, 'message' => 'Tax Body deleted Successfully'], 200);
                }
                else{
                    return response()->json(['error' => true, 'message' => 'Tax Body deletion failed'], 422);
                }
            }
            catch(Exception $e){
                Session::flash('error', 'Tax Body not Deleted');
                return redirect()->back();
            }
        }
        else{
            return redirect()->route('not_authorized');
        }
    }


    // Delete Bulk Orders
    public function destroy_bulk(Request $r){
        if(Auth::user()->can($this->authR))
        {
            try {
                $orderList = $r->order_list;

                Taxation_bodies::find($orderList)->each(function ($tax_body) {
                    if($tax_body)
                    {
                        $tax_body->delete();
                    }
                    else{
                        return response()->json(['error' => true, 'message' => 'Tax Body deletion failed'], 422);
                    }
                });
                return response()->json(['success' => true, 'message' => 'Tax Body deleted Successfully'], 200);

            }catch(Exception $e){
                Session::flash('error', 'Tax Body not Deleted');
                return redirect()->back();
            }
        }
        else{
            return redirect()->route('not_authorized');
        }
    }
}
