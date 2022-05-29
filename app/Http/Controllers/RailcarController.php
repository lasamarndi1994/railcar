<?php

namespace App\Http\Controllers;

use App\Http\Requests\RailcarRequest;
use App\Http\Resources\RailcarResource;
use App\Models\Railcar;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RailcarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $railcars = Railcar::orderBy('created_at','asc')->paginate(10);

        return RailcarResource::collection($railcars);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RailcarRequest $request)
    {
        try{
            DB::beginTransaction();
            $railcar = Railcar::create([
                'name' => $request->name,
                'area' => $request->area,
                'arrival_date' => $request->arrival_date,
                'due_date' => $request->due_date,
                'status' => $request->status,
            ]);
            DB::commit();
            return response()->json([
                'status' => true,
                'data' =>new RailcarResource($railcar)
            ]);
        }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => false,
            ]);
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
    public function update(RailcarRequest $request, $id)
    {
         $railcar = Railcar::where('id',$id)->update([
                'name' => $request->name,
                'area' => $request->area,
                'arrival_date' => $request->arrival_date,
                'due_date' => $request->due_date,
                'status' => $request->status,
            ]);
            return response()->json([
                'status' => true,

            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Railcar::where('id',$id)->delete();

        return response()->json([
            'status'=> true,
        ]);
    }
}
