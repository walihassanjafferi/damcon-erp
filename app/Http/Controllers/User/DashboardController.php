<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Project;
use App\Models\Employeemanagement;
use App\Models\Suppliers;
use App\Models\Damcon_asssets;
use App\Models\Investors;
use App\Models\directorwithdraws;
use App\Models\AdvanceHrPayment;
use App\Models\CustomerPosManagement;
use App\Models\customer_invoice_management;

use Carbon\Carbon;
use DB;

use Auth;
use Exception;

Use App\Models\User;

class DashboardController extends Controller
{
    public function index(){

       $user = User::find(Auth::id());
       $projects = Project::select('id','name')->get();
       return view('user.dashboard.index',compact('projects'));
    }

    // admin dashboard data
    public function getadminDashboardData(Request $request){

        //dd($request->all());
       $startDate = $request->startDate;
       $endDate = $request->endDate;

        
        $project_id = 1;
        if(isset($startDate) && isset($endDate))
        {   
            $startDate = Carbon::parse($request->startDate)->format('Y-m-d');
            $endDate = Carbon::parse($request->endDate)->format('Y-m-d');
            // >whereBetween('created_at', [$first_day_of_the_current_month, $last_day_of_the_current_month])->get()
            $project_count = Project::where('status',1)->whereBetween('created_at', [$startDate, $endDate])->count();
            $customer_count = Customer::where('status',1)->whereBetween('created_at', [$startDate, $endDate])->count();
            $suppliers_count = Suppliers::where('status',1)->whereBetween('created_at', [$startDate, $endDate])->count();
            $investor_count = Investors::where('status',1)->whereBetween('created_at', [$startDate, $endDate])->count();
            $employee_count = Employeemanagement::where('project_id',$project_id)->count();
            $asset_count = Damcon_asssets::whereBetween('created_at', [$startDate, $endDate])->count();
            $director_withdraw = directorwithdraws::whereBetween('created_at', [$startDate, $endDate])->sum('amount');
            $advance_hr_payment = AdvanceHrPayment::whereBetween('created_at', [$startDate, $endDate])->sum('amount');
            // Employeemanagement::join('advance_hr_payments','employeemanagements.project_id','=',$project_id)->where('advance_hr_payments.employeemanagement_id','employeemanagements.id')->count();
            $pie_chart_data = DB::table("projects")->select(DB::raw("COUNT(employeemanagements.id) as employee_count"),DB::raw("COUNT(projects.id) as project_count"),'projects.name')->join('employeemanagements','projects.id','=','employeemanagements.project_id')->whereBetween('projects.created_at', [$startDate, $endDate])->groupBy("projects.id")->get();

            $bar_chart_data = DB::table("customer_invoice_managements")->select(DB::raw("COUNT(customer_invoice_managements.id) as invoice_count"),DB::raw("SUM(customer_invoice_managements.total_after_deductions) as invoice_sum"),DB::raw("COUNT(customer_pos_management.id) as c_po_count"),'customer_pos_management.customer_po_number as Customer_po_number','customer_pos_management.id as PO_ID','customer_invoice_managements.invoice_number','customer_pos_management.customer_po_balance as PO_balance')
            ->join('customer_pos_management','customer_invoice_managements.customer_po_id','=','customer_pos_management.id')
            ->whereBetween('customer_pos_management.created_at', [$startDate, $endDate])
            ->groupBy("customer_pos_management.id")->get();


        }
        else {
            

            $project_count = Project::where('status',1)->count();
            $customer_count = Customer::where('status',1)->count();
            $suppliers_count = Suppliers::where('status',1)->count();
            $investor_count = Investors::where('status',1)->count();
            $employee_count = Employeemanagement::count();
            $asset_count = Damcon_asssets::count();
            $director_withdraw = directorwithdraws::sum('amount');
            $advance_hr_payment = AdvanceHrPayment::sum('amount');

            // $pie_chart_data = DB::select(DB::raw("COUNT(employeemanagements.*) as employee_count"),DB::raw("COUNT(projects.*) as project_count"))->join('c','projects.id','=','employeemanagements.project_id');

            $pie_chart_data = DB::table("projects")->select(DB::raw("COUNT(employeemanagements.id) as employee_count"),DB::raw("COUNT(projects.id) as project_count"),'projects.name')->join('employeemanagements','projects.id','=','employeemanagements.project_id')->groupBy("projects.id")->get();

            $bar_chart_data = DB::table("customer_invoice_managements")->select(DB::raw("COUNT(customer_invoice_managements.id) as invoice_count"),DB::raw("SUM(customer_invoice_managements.total_after_deductions) as invoice_sum"),DB::raw("COUNT(customer_pos_management.id) as c_po_count"),'customer_pos_management.customer_po_number as Customer_po_number','customer_pos_management.id as PO_ID','customer_invoice_managements.invoice_number','customer_pos_management.customer_po_balance as PO_balance')->join('customer_pos_management','customer_invoice_managements.customer_po_id','=','customer_pos_management.id')->groupBy("customer_pos_management.id")->get();

            

        }

        return response()->json([
            'startDate' => $startDate,
            'endDate' => $endDate,
            'project_count' => $project_count,
            'customer_count'=> $customer_count,
            'suppliers_count' => $suppliers_count,
            'investor_count'=> $investor_count,
            'employee_count'=> $employee_count,
            'asset_count'=> $asset_count,
            'director_withdraw' => number_format($director_withdraw),
            'advance_hr_payment'=> number_format($advance_hr_payment),
            'pie_chart_data' => $pie_chart_data,
            'bar_chart_data' => $bar_chart_data

        ],200);

    }

    public function NotAuthorized(){
       
        return view('notauthorized');
        
    }
}
