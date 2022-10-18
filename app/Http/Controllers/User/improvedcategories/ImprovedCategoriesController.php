<?php

namespace App\Http\Controllers\User\improvedcategories;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Configuration;
use App\Models\ImprovedCategories;

use Auth;
use Session;
use Exception;
use DB;

class ImprovedCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index(Request $request)
    {
        if(Auth::user()->can('manage-categories'))
        {   
            $module_name = $request->get('module_name');

            try{

            

                $parent_categories = ImprovedCategories::where('module_name',$module_name)->whereNull('parent_id')->whereNull('main_id')->whereNull('sub_id')->select('id','category_name')->get();
                $main_categories =  DB::select(DB::raw(
                    'Select * from (Select a.module_name as module_name, a.id as parent_id, b.id as main_id, a.category_name as parent_category, b.category_name as main_category from improved_categories as a, improved_categories as b where b.parent_id=a.id ) as M where M.module_name="'.$module_name.'"'
                ));
                
               // DB::table('improved_categories as a')->join('improved_categories as b','b.parent_id','a.id')->select('a.id as parent_id','b.id as main_id','a.category_name as parent_category','b.category_name as main_category')->get();
                


                $sub_categories =  DB::select(DB::raw(
                    'Select * from (Select a.module_name as module_name,a.id as main_id,a.category_name as main_category,c.id as sub_id,c.category_name as sub_category,d.id as parent_id,d.category_name as parent_category from improved_categories as a,
                    improved_categories as c,improved_categories as d  where c.main_id=a.id and d.id=a.parent_id)
                     as M where M.module_name="'.$module_name.'"'
                )) ;
                
                
                // DB::table('improved_categories as a')

                // ->join('improved_categories as c','c.main_id','a.id')

                // ->join('improved_categories as d','d.id','a.parent_id')

                // ->where('module_name','project_item')
                // ->get();

               // $sub_categories = "ab";


                //->select('a.id as main_id','a.category_name as main_category','c.id as sub_id','c.category_name as sub_category','d.id as parent_id','d.category_name as parent_category')->get();
                
                $sub_sub_categories = DB::select(DB::raw(
                    'select * from( select a.module_name as module_name, a.id as main_id,a.category_name as main_category,
                    c.id as sub_id,c.category_name as sub_category,d.id as parent_id,
                    d.category_name as parent_category,e.id as sub_sub_id,e.category_name as sub_sub_name from
                    improved_categories as a, improved_categories as d, improved_categories as c, improved_categories as e 
                    where d.id = a.parent_id and c.main_id = a.id and e.sub_id = c.id) as M where M.module_name="'.$module_name.'"'

                ));
                
               // dd($sub_sub_categories);
                
                // DB::table('improved_categories as a')

                
                // ->join('improved_categories as d','d.id','a.parent_id')

                // ->join('improved_categories as c','c.main_id','a.id')

                // ->join('improved_categories as e','e.sub_id','c.id')

                // ->select('a.id as main_id','a.category_name as main_category',
                // 'c.id as sub_id','c.category_name as sub_category','d.id as parent_id',
                // 'd.category_name as parent_category','e.id as sub_sub_id','e.category_name as sub_sub_name')->get();


                if($module_name == 'project_item')
                {
                    $view = 'user.inventorymanagement.improvedcategories.index';
                }
                else if($module_name == 'maintenance_item')
                {
                    $view = 'user.inventorymanagement.maintenanceitemcategories.index';
                }
                else{
                    return redirect()->back();
                }


                return view($view,compact('parent_categories','main_categories','sub_categories','sub_sub_categories'));
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $r)
    {

        if(Auth::user()->can('manage-categories'))
        {   
            //$configurations = Configuration::where('name','project_modules')->pluck('label','id')->toArray();  
            //,compact('configurations')
            if($r->has('module_name'))
            {
                $type = $r->module_name;
            }

            if($type == 'project_item')
            {
                return view('user.inventorymanagement.improvedcategories.create');
            }
            else if($type == 'maintenance_item')
            {
                return view('user.inventorymanagement.maintenanceitemcategories.create');
            }
            else{
                return redirect()->back();
            }

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

        if(Auth::user()->can('manage-categories'))
        {   
            // if($request->status == 'on')
            // {
            //     $status = 1;
            // }
            // else{
            //     $status = 0;
            // }

            $module_name = $request->module_name;
            $category_type = $request->category_type;

            if($request->filled('parent_category') && ($category_type == "parent"))
            {
            
                $improvedCategories = new ImprovedCategories();
                $improvedCategories->category_name = $request->parent_category;
                $improvedCategories->module_name = $module_name;

                $improvedCategories->save();

                session::flash('success','Parent Category Added Successfully!');

                return redirect()->back();
            }

            else if($request->filled(['parent_categories','main_category']) && ($category_type == "main"))
            {
            

                $improvedCategories = new ImprovedCategories();
                
                $improvedCategories->category_name = $request->main_category;
                $improvedCategories->module_name = $module_name;
                $improvedCategories->parent_id = $request->parent_categories;
                $improvedCategories->save();

                session::flash('success','Main Category Added Successfully!');

                return redirect()->back();
            }

            else if($request->filled(['main_categories','sub_category']) && ($category_type == "sub"))
            {   
              
                
                $improvedCategories = new ImprovedCategories();
                $improvedCategories->category_name = $request->sub_category;
                $improvedCategories->module_name = $module_name;
                $improvedCategories->main_id = $request->main_categories;

                $improvedCategories->save();

                session::flash('success','Sub Category Added Successfully!');

                return redirect()->back();
            }
            else if($request->filled(['sub_categories','sub_sub_category']) && ($category_type == "sub_sub"))
            {
                $improvedCategories = new ImprovedCategories();
                $improvedCategories->category_name = $request->sub_sub_category;
                $improvedCategories->module_name = $module_name;
                $improvedCategories->sub_id = $request->sub_categories;

                 $improvedCategories->save();

                session::flash('success','Sub Category Added Successfully!');

                return redirect()->back();

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
        //
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
        //
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

    public function ajaxgetcategorybymodule(Request $request){
        
        $module_name = $request->module_name;

        $category_select = $request->category_select;

        if($category_select == 'main')
        {   
            // getting parent categories
            $categories = ImprovedCategories::where('module_name',$module_name)->whereNull('parent_id')->whereNull('main_id')->select('id','category_name')->get();
        }
        else if($category_select == 'sub')
        {
            // getting main categories
            $categories = ImprovedCategories::where('module_name',$module_name)->whereNotNull('parent_id')->whereNull('main_id')->select('id','category_name')->get();

        }
        else if($category_select == 'sub_sub')
        {
            $categories = ImprovedCategories::where('module_name',$module_name)->whereNull('parent_id')->whereNotNull('main_id')->whereNull('sub_id')->select('id','category_name')->get();

        }


        return response()->json(['success' => true, 'categories' => $categories], 200);

    }

   
   
}
