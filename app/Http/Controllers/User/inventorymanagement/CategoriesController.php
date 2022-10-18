<?php

namespace App\Http\Controllers\User\inventorymanagement;
use App\Models\categories;
use App\Models\chidcategories;
use App\Models\ErpCategories;
use App\Models\Configuration;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Session;
use Exception;
use DB;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
        if(Auth::user()->can('manage-categories'))
        { 
            try{

                $parent_categories = ErpCategories::whereNull('parent_id')->whereNull('main_id')->select('id','category_name','module_name')->get();
                $main_categories = DB::table('erp_categories as a')->join('erp_categories as b','b.parent_id','a.id')->select('a.id as parent_id','b.id as main_id','a.category_name as parent_category','b.category_name as main_category','a.module_name')->get();
                $sub_categories =  DB::select(DB::raw(
                    'Select a.module_name as module_name,a.id as main_id,a.category_name as main_category,c.id as sub_id,c.category_name as sub_category,d.id as parent_id,d.category_name as parent_category from erp_categories as a,
                    erp_categories as c,erp_categories as d  where c.main_id=a.id and d.id=a.parent_id'
                )) ;

                

                return view('user.erpcategoriesmanagement.index',compact('main_categories','parent_categories','sub_categories'));
            
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
    public function create()
    {
        if(Auth::user()->can('manage-categories'))
        {   
           /// $configurations = Configuration::where('name','project_modules')->pluck('label','id')->toArray();  
            return view('user.erpcategoriesmanagement.create');
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
        //
        if(Auth::user()->can('manage-categories'))
        {   
            // if($request->status == 'on')
            // {
            //     $status = 1;
            // }
            // else{
            //     $status = 0;
            // }

            // if ($request->has(['module_id', 'category_name','parent_categories'])) {
                
            //     try {

            //         $module_id = $request->module_id;   
            //         $category_name = $request->category_name;
            //         $parent_categories = $request->parent_categories;

            //         $childCategories = chidcategories::firstOrCreate(['name'=>$category_name,'module_id'=>$module_id,'status'=>$status]);

            //         if($childCategories->wasRecentlyCreated)
            //         {
            //             $childCategories->parentCatgories()->sync($parent_categories);
            //             Session::flash('created', 'Child Category Added successfully!');
            //             return redirect()->route('categories.index');
            //         }
            //         else{

            //             Session::flash('error','Error Added Catgory');   
            //             return redirect()->back()->withInput();

            //         }

            //     }
            //     catch(Exception $e){
                    
            //         Session::flash('error','Error Added Catgory');   
            //         return redirect()->back()->withInput();

            //     }


            // }
            // else if ($request->has(['module_id','category_name'])) {
               
                //     try{

                //         $module_id = $request->module_id;
                //         $category_name = $request->category_name;
                //         $categories = categories::firstOrCreate(['name'=>$category_name,'module_id'=>$module_id,'status'=>$status]);
                //         if($categories->wasRecentlyCreated)
                //         {
                //             Session::flash('created', 'Category Added successfully!');
                //             return redirect()->route('categories.index');
                //         }
                //         else{

                //             Session::flash('error','Error Added Catgory');   
                //             return redirect()->back()->withInput();
                //         }
                //     }
                //     catch(Exception $e)
                //     {
                //         Session::flash('error','Error Added Catgory');   
                //         return redirect()->back()->withInput();

                //     }


                // }

           
                
            $module_name = $request->module_name;
            $category_type = $request->category_type;

            if($request->filled('parent_category') && ($category_type == "parent"))
            {
            
                $improvedCategories = new ErpCategories();
                $improvedCategories->category_name = $request->parent_category;
                $improvedCategories->module_name = $module_name;

                $improvedCategories->save();

                session::flash('success','Parent Category Added Successfully!');

                return redirect()->back();
            }

            else if($request->filled(['parent_categories','main_category']) && ($category_type == "main"))
            {
            

                $improvedCategories = new ErpCategories();
                
                $improvedCategories->category_name = $request->main_category;
                $improvedCategories->module_name = $module_name;
                $improvedCategories->parent_id = $request->parent_categories;
                $improvedCategories->save();

                session::flash('success','Main Category Added Successfully!');

                return redirect()->back();
            }

            else if($request->filled(['main_categories','sub_category']) && ($category_type == "sub"))
            {   
           
                
                $improvedCategories = new ErpCategories();
                $improvedCategories->category_name = $request->sub_category;
                $improvedCategories->module_name = $module_name;
                $improvedCategories->main_id = $request->main_categories;

                $improvedCategories->save();

                session::flash('success','Sub Category Added Successfully!');

                return redirect()->back();
            }
            // else if($request->filled(['sub_categories','sub_sub_category']) && ($category_type == "sub_sub"))
            // {
            //     $improvedCategories = new ImprovedCategories();
            //     $improvedCategories->category_name = $request->sub_sub_category;
            //     $improvedCategories->module_name = $module_name;
            //     $improvedCategories->sub_id = $request->sub_categories;

            //      $improvedCategories->save();

            //     session::flash('success','Sub Category Added Successfully!');

            //     return redirect()->back();

            // }

               
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
        if(Auth::user()->can('manage-categories'))
        { 
            $id = decrypt($id);
            $category = chidcategories::find($id);
            if($category == null){
                $category = categories::find($id);
            }
            return view('user.inventorymanagement.categories.view',compact('category'));

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
        if(Auth::user()->can('manage-categories'))
        {
            $id = decrypt($id);
            $category = categories::find($id);
            $configurations = Configuration::where('name','project_modules')->pluck('label','id')->toArray();  
            return view('user.inventorymanagement.categories.edit',compact('category','configurations'));
        }
        else{
            return redirect()->route('not_authorized');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Requ
     * est  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       
        if(Auth::user()->can('manage-categories'))
        {
           try {

                if($request->status == 'on')
                {
                    $status = 1;
                }
                else{
                    $status = 0;
                }

                $id = decrypt($id);
                $category = categories::find($id);
                $category->module_id = $request->module_id;
                $category->name = $request->category_name;
                $category->status = $status;
                $category->save();

                Session::flash('created', 'Category Edited successfully!');
                return redirect()->back();

           }
           catch(Exception $e)
           {
                Session::flash('error','Error Occured');   
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

    public function getCategories(Request $request){
        $module_id =  $request->module_id;
        $categories = categories::where('module_id',$module_id)->get()->toArray();
        return response()->json(['success' => true, 'categories' => $categories], 200);
    }


    public function changeStatus(Request $request){

        if(Auth::user()->can('manage-categories'))
        {
            $id = $request->id;
          
            $categories = chidcategories::find($id);

            if($categories == null){
                
                $categories = categories::find($id);
            }

            if($categories)
            {
              $categories->status ? $categories->status = 0 : $categories->status = 1;
              $categories->save();

                return response()->json(['success' => true, 'message' => 'Category status Updated Successfully','value'=>$categories->status,'class'=>$categories->id], 200);
            }
            else {
                return response()->json(['error' => true, 'message' => 'Category status updation failed'], 422);
            }
           
        }
        else{
            return redirect()->route('not_authorized');
        }
    }

    public function childCategoryEdit($id){

        if(Auth::user()->can('manage-categories'))
        {
            $id = decrypt($id); $selected_parent_categories = array();
            $category = chidcategories::find($id);
            $parent_categories =  categories::where('module_id',$category->module_id)->pluck('name','id')->toArray();

            $configurations = Configuration::where('name','project_modules')->pluck('label','id')->toArray();  
           
            foreach($category->parentCatgories as $cat){
                $selected_parent_categories[$cat->id] = $cat->id;
            }    
            
          
            return view('user.inventorymanagement.categories.edit_child',compact('category','configurations','parent_categories','selected_parent_categories'));
        }
        else{
            return redirect()->route('not_authorized');
        }

    }

    public function childCategoryUpdate(Request $request,$id){
        if(Auth::user()->can('manage-categories'))
        {
            $id = decrypt($id);

            if($request->status == 'on')
            {
                $status = 1;
            }
            else 
            {
                $status = 0;
            }

           try {
                $parent_categories = $request->parent_categories;
                
                $category = chidcategories::find($id);

                $category->parentCatgories()->detach();

                $category->name = $request->category_name;
        
                $category->module_id = $request->module_id;

                $category->status = $status;

                $category->parentCatgories()->sync($parent_categories);

                $category->save();

                Session::flash('created', 'Category Edited successfully!');
                
                return redirect()->route('categories.index');
           }
           catch(Exception $e){

                Session::flash('error','Category Edited failed');
                
                return redirect()->back()->withInput();


           }

        }
        else{
            return redirect()->route('not_authorized');
        }
    }


    public function ajaxgeterpcategorybymodule(Request $request){
        
    
        $module_name = $request->module_name;

        $category_select = $request->category_select;

        if($category_select == 'main')
        {   
            // getting parent categories
            $categories = ErpCategories::where('module_name',$module_name)->whereNull('parent_id')->whereNull('main_id')->select('id','category_name')->get();
        }

      
        else if($category_select == 'sub')
        {
            // getting main categories
            $categories = ErpCategories::where('module_name',$module_name)->whereNotNull('parent_id')->whereNull('main_id')->select('id','category_name')->get();
        }
        // else if($category_select == 'sub_sub')
        // {
        //     $categories = ImprovedCategories::where('module_name',$module_name)->whereNull('parent_id')->whereNotNull('main_id')->whereNull('sub_id')->select('id','category_name')->get();

        // }


        return response()->json(['success' => true, 'categories' => $categories], 200);

    }


    // New functions of category

    public function updateCategories(Request $request)
    {
        if($request->category_type == "parent")
        {
           $category = ErpCategories::where('module_name',$request->module_name)->where('id',$request->parent_category_id)->update(['category_name'=>$request->parent_category,'module_name'=>$request->module_name]);
            
        }
        elseif($request->category_type == "main")
        {
            $category = ErpCategories::where('module_name',$request->module_name)->where('id',$request->sub_category_id)->update(['category_name'=>$request->sub_category_name,'parent_id'=>$request->parent_Category_id,'module_name'=>$request->module_name]);
        }
        Session::flash('edited', 'Category Edited successfully!');
        return redirect()->back();

    }
   

}
