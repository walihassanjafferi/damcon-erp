<?php

namespace App\Http\Controllers\User\regions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Regions;
use DataTables;
use Auth;
use Session;
use Exception;
use DB;

class RegionsController extends Controller
{

    private $path    = 'user.region';
    private $authR   = 'damcon-regions';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        if(Auth::user()->can($this->authR))
        {
            try {

                DB::beginTransaction();

                $regions = new Regions();

                $regions->name = $request->name;
                $regions->status = $request->status;
                
                if($regions->save())
                {
                    DB::commit();
                    Session::flash('success','Regions created successfully!');
                    return redirect()->route('regions.index');
                }
                else{
                    Session::flash('success','Error Occured!');
                    return redirect()->back()->withInput();
                }
                        
            } 
            catch (Exception $e) {
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
            $regions = Region::find($id);
            return view($this->path.'.edit',compact('region'));
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
}
