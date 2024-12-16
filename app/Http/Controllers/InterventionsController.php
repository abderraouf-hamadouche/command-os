<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Command;
use App\Models\Param;
use App\Models\Intervention;

class InterventionsController extends Controller
{
    //

     public  function index()
    {
        // show all proc
        $interventions = Intervention::all();
        return view('intervention.index' , [
            'interventions' => $interventions, 
         ]);
    }

    public function create()
    {
        //show form to create a blog post
        return view('intervention.create');
    }
    public function show(Intervention $intervention)
    {
        //show form to create a blog post
        //$intervention=intervention::where('id',$interv->id)->get();

         $procedure=intervention::where('id',$intervention->id)->get();

        //$param=Param::where('id-command',$command->id)->get();
        return view('intervention.show', [
            'intervention' => $intervention,
        ]);
       // return $command;
    

    }

    public function store(Request $request)
    {   

        $inputs = $request->input('inputs');
               $interv = Intervention::create([
                'intervention_name' => $inputs[0]['command'],
                'description' => $inputs[0]['desc'],
                'id_command' => "0",
                'id_param' => "0",
                'ordre_seq' => $inputs[0]['order']
                                              ]);

        for ($x = 1; $x <= $request->variableCount; $x++) {
            $interv2 = Intervention::create([
                'id'  => $interv->id,
                'intervention_name' =>$interv->id,
                'description' => $inputs[$x]['desc'],
                'id_command' => $inputs[$x]['command'],
                'id_param' => $inputs[$x]['param'],
                'ordre_seq' => $inputs[$x]['order']     ]);




        }
           

        //show form to create a blog post
        

                                      //  }                                 


         return redirect('intervention/' . $interv->id);




    }

    public function delete()
    {
        //show form to create a blog post

    }

    public function edit()
    {
        //show form to create a blog post

    }

    public function search()
    {
        //show form to create a blog post

    }




}
