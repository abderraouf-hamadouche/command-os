<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Command;
use App\Models\Param;


class CommandController extends Controller
{
    public function index()
    {
        // show all blog posts
        $commands = Command::all();
        return view('command.index',[
                'command' =>$commands,
        ]) ;
    }

    public function create()
    {
        //show form to create a blog post
        return view('command.create');
    }

   
    public function store(Request $request)
    {
        //store a new post
            // Check if a command with the same name and param already exists
                $commandExist = Command::where('command', $request->command)->first();

                if ($commandExist) {
                    // Case 3: Check if both command and param exist
                $paramExist = Command::where('command', $request->command)
                                    ->where('param', $request->param)
                                    ->first();

                if ($paramExist) {
                    // Redirect to the existing command if both command and param match
                    return redirect('command/' . $paramExist->id);
                } else {
                    // Case 2: Create a new entry with existing command/description and new param/pdescription
                    $newCommand = Command::create([
                        'command' => $commandExist->command, // Prefilled command
                        'description' => $commandExist->description, // Prefilled description
                        'param' => $request->param, // User-provided param
                        'pdescription' => $request->pdescription, // User-provided pdescription
                    ]);

                    return redirect('command/' . $newCommand->id);
                }
            } else {
                // Case 1: Create a new row with user-provided data
                $newCommand = Command::create([
                    'command' => $request->command,
                    'description' => $request->cdescription,
                    'param' => $request->param,
                    'pdescription' => $request->pdescription,
                ]);

                return redirect('command/' . $newCommand->id);
            }
            }

    public function show(Command $command)
    {
        //show a blog post
        $command_array=command::where('command',$command->command)->get();
        //$param=Param::where('id-command',$command->id)->get();
        return view('command.show', [
            'command' => $command,'params'=>$command_array,
        ]);
       // return $command;
    }

    
    public function edit(Command $command)
    {
        //show form to edit the post
    }

    
    public function update(Request $request, Command $command)
    {
        //save the edited post
    }

    
    public function destroy(Command $command)
    {
        //delete a post
    }
	
    public function search(Request $request)
    {
        //store a new post
        $output= '<tr><td>Command Name</td> <td>Command Description</td></tr>';
        $commands=command::where('command','LIKE','%'.$request->search.'%')
                        ->orwhere('description','LIKE','%'.$request->search.'%')
                        ->get();
        //$commands=Param::where('description','LIKE','%'.$request->search.'%')->get();
        $commands=$commands->unique('command');
        foreach($commands as $commands)
        {$output.=
            '<tr>
            <td><a href="command/'.$commands->id.'"> '.$commands->command.' </td> <td> '.$commands->description.' </td>
             </tr>';

        }
        
        return response($output);
    }
    public function searchcommand(Request $request)
    {
        //store a new post
        $output= '';
        $com=[];
        $commands=command::select("id","command")->where('command','LIKE','%'.$request->get('query').'%')->get();
        //$commands=Param::where('description','LIKE','%'.$request->search.'%')->get();
        $commands=$commands->unique('command');

         foreach($commands as $commands)
        {   
            array_push($com,$commands->command);
           
        }
        
        return response($com);
    }


    public function searchparam(Request $request)
    {
        //store a new post
        $output= '<option value="description" >Merci de choisir quel parametre         .</option>';
        $com=[];
        $commands=command::where('command','LIKE','%'.$request->get('query').'%')->get();
        //$lulu=$commands.id;
        //return response($commands[0]->id);
        $commands=$commands->unique('param');
        //$params=param::select("param","id")
        //->where('param','LIKE','%'.$request->get('query').'%')
        //->where('id-command', $commands[0]->id)
        //->get();
        //$commands=Param::where('description','LIKE','%'.$request->search.'%')->get();


        foreach($commands as $commands)
        {$output.=
            '  <option value="'.$commands->id.'">'.$commands->param.'</option>';

        }
         /*foreach($params as $params)
        {   
            array_push($com,$params->param);
           
        }*/
        return response($output);
       
    }
 
	
	
	
}
