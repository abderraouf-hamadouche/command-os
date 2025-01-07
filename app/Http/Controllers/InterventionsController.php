<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Command;
use App\Models\Param;
use App\Models\Intervention;
use App\Models\ProcessStep;
use Illuminate\Support\Facades\Log;

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

         /*$procedure=intervention::where('id',$intervention->id)
                                  ->first();
         //$steps=ProcessStep::all();
         $steps=ProcessStep::where('process_id',$procedure->id)
                                  ->get();
*/
        $int = Intervention::with(['processSteps.command'])
        ->where('id', $intervention->id)
        ->first();
        //$param=Param::where('id-command',$command->id)->get();
        Log::info("Intervention :$int"); 
        //Log::info("steps$steps");
        return view('intervention.show', [
            //'intervention' => $intervention,'steps' => $steps,
            'intervention' => $int,

        ]);
       // return $command;
    

    }

    public function store(Request $request)
    {   
              
        $inputs = $request->input('inputs');
               $interv = Intervention::create([
                'intervention' => $inputs[0]['command'],
                'description' => $inputs[0]['desc'],
                'tags' => "lulu",
                'created_by' => "lulu",

                                              ]);

        for ($x = 1; $x <= $request->variableCount; $x++) {
          /*  $interv2 = Intervention::create([
                'id'  => $interv->id,
                'intervention_name' =>$interv->id,
                'description' => $inputs[$x]['desc'],
                'id_command' => $inputs[$x]['command'],
                'id_param' => $inputs[$x]['param'],
                'ordre_seq' => $inputs[$x]['order']     ]);*/

                // lulu its in the game


                $command = Command::where('command', $inputs[$x]['command'])
                  ->where('param', $inputs[$x]['param']) // Corrected to match 'param'
                  ->first(['id']); // Use `first` to get a single record

                if ($command) {
                    $command_id = $command->id;

                $in=ProcessStep::create([
                'process_id' =>$interv->id,
                'command_id' => $command_id,
                'step_order' => $inputs[$x]['order'],
                'comment' => $inputs[$x]['desc'],


                ]);
            } else {
                // Handle the case where no matching command is found
                throw new Exception("Command not found for given inputs");
            }





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

    public function search2()
    {
        //show form to create a blog post

    }


    public function search(Request $request)
    {
        //store a new post
        $output= '<tr><td>Command Name</td> <td>Command Description</td></tr>';
        $output2='';
        $commands=Intervention::where('intervention','LIKE','%'.$request->search.'%')
                        ->orwhere('description','LIKE','%'.$request->search.'%')
                        ->get();
        //$commands=Param::where('description','LIKE','%'.$request->search.'%')->get();
        //$commands=$commands->unique('command');
        foreach($commands as $commands)
        {$output.=
            '<tr>
            <td><a href="command/'.$commands->id.'"> '.$commands->command.' </td> <td> '.$commands->description.' </td>
             </tr>';
            $output2.=
             '<ul>
             <li><h5><a href="./intervention/ '.$commands->id.' ">'. $commands->intervention.'</a> <h6> '.$commands->description.'</h6> </li>
             
             </ul>';

             //<li><a href="./intervention/ '.$commands->id.' "> <h6> '.$commands->description.'</h6> </a></li>
        }
        
        return response($output2);
    }



}
