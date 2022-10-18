<?php

namespace App\Http\Controllers\User\taxationmanagement;

use App\Models\EmployeesTaxManagement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Session;
use DataTables;

class EmployeesTaxManagementController extends Controller
{
    private $path    = 'user.taxationmanagement.employees_tax_management';
    private $authR   = 'employees_tax_management';

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

                $data = EmployeesTaxManagement::orderby('id','desc')->get();

                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                        $actionBtn = '<a href="'.route('employees_tax_management.show',encrypt($row->id)).'"><i data-feather="eye" data-toggle="tooltip" data-placement="top" data-original-title="View"></i></a>&nbsp; &nbsp;
                                      <a href="'.route('employees_tax_management.edit',encrypt($row->id)).'"><i data-feather="edit" data-toggle="tooltip" data-placement="top" data-original-title="Edit"></i></a>&nbsp; &nbsp;
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
                $employee_tex                                   = new EmployeesTaxManagement();
                $employee_tex->user_id                          = Auth::id();
                $employee_tex->title                            = $r->title;
                $employee_tex->law_of_tax                       = $r->law_of_tax;
                $employee_tex->law_of_tax_update_date           = $r->law_of_tax_update_date;
                $employee_tex->income_tax_percentage_on_salary  = $r->income_tax_percentage_on_salary;
                $employee_tex->EOBI_tax_percentage              = $r->EOBI_tax_percentage;
                $employee_tex->description_input                = $r->description_input;
                $employee_tex->details_input                    = $r->details_input;

                //Save Files
                if($employee_tex->save())
                {
                    Session::flash('created', 'Employee Tax Added Successfully');
                    return redirect()->route('employees_tax_management.index');
                }
                else{
                    Session::flash('error', 'Error adding Employee Tax');
                    return redirect()->back()->withInput();
                }

            }catch(Exception $e){
                Session::flash('error', 'Error adding Employee Tax');
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
     * @param  \App\Models\EmployeesTaxManagement  $employeesTaxManagement
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::user()->can($this->authR))
        {
            $employee_tax  = EmployeesTaxManagement::find(decrypt($id));
            return view($this->path.'.view',compact('employee_tax'));
        }
        else{


            return redirect()->route('not_authorized');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EmployeesTaxManagement  $employeesTaxManagement
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->can($this->authR))
        {
            $employee_tax  = EmployeesTaxManagement::find(decrypt($id));
            return view($this->path.'.edit',compact('employee_tax'));
        }
        else{


            return redirect()->route('not_authorized');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EmployeesTaxManagement  $employeesTaxManagement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r, $id)
    {
        if(Auth::user()->can($this->authR))
        {
            try {
                $employee_tex                                   = EmployeesTaxManagement::find(decrypt($id));
                $employee_tex->title                            = $r->title;
                $employee_tex->law_of_tax                       = $r->law_of_tax;
                $employee_tex->law_of_tax_update_date           = $r->law_of_tax_update_date;
                $employee_tex->income_tax_percentage_on_salary  = $r->income_tax_percentage_on_salary;
                $employee_tex->EOBI_tax_percentage              = $r->EOBI_tax_percentage;
                $employee_tex->description_input                = $r->description_input;
                $employee_tex->details_input                    = $r->details_input;

                //Save Files
                if($employee_tex->update())
                {
                    Session::flash('created', 'Employee Tax Updated Successfully');
                    return redirect()->route('employees_tax_management.index');
                }
                else{
                    Session::flash('error', 'Error updating Employee Tax');
                    return redirect()->back()->withInput();
                }

            }catch(Exception $e){
                Session::flash('error', 'Error updating Employee Tax');
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
     * @param  \App\Models\EmployeesTaxManagement  $employeesTaxManagement
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        if(Auth::user()->can($this->authR))
        {
            try {
                $id = $request->id;
                $tax_body = EmployeesTaxManagement::find($id);
                if($tax_body)
                {
                    $tax_body->delete();
                    return response()->json(['success' => true, 'message' => 'Employee Tax deleted Successfully'], 200);
                }
                else{
                    return response()->json(['error' => true, 'message' => 'Employee Tax deletion failed'], 422);
                }
            }
            catch(Exception $e){
                Session::flash('error', 'Employee Tax not Deleted');
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

                EmployeesTaxManagement::find($orderList)->each(function ($tax_body) {
                    if($tax_body)
                    {
                        $tax_body->delete();
                    }
                    else{
                        return response()->json(['error' => true, 'message' => 'Employee Tax deletion failed'], 422);
                    }
                });
                return response()->json(['success' => true, 'message' => 'Employee Tax deleted Successfully'], 200);

            }catch(Exception $e){
                Session::flash('error', 'Employee Tax not Deleted');
                return redirect()->back();
            }
        }
        else{
            return redirect()->route('not_authorized');
        }
    }
}
