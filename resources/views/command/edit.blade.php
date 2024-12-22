@extends('layouts.app')

@section('content')


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js" ></script>


    <div class="container">
        <div class="row">
            <div class="col-12 pt-2">
                <a href="../" class="btn btn-outline-primary btn-sm">Go back</a>
                <div class="border rounded mt-5 pl-4 pr-4 pt-4 pb-4">
                    <h1 class="display-4">Add a New Command</h1>
                    <p>Fill and submit this form to create a Command</p>

                    <hr>

                    <form action="" method="POST">
                        @csrf
                        <div class="row">
                            <div class="control-group col-12">
                                <label for="command">Command Name</label>

                                <input class="typeahead form-control" id="search" name="command" type="text" value="{!! $command->description !!} ">
                                
                                       
                            </div>
                            <div class="control-group col-12 mt-2" id="description2">
                                <label for="description" >Command Description</label>
                                <textarea id="cdescription" class="form-control" name="cdescription" 
                                          rows="" >{!! $command->description !!}</textarea>
                            </div>
                            <div class="control-group col-12" id="tags2">
                                <label for="tags">Tags</label>
                                <input type="text" id="tags" class="form-control" name="tags"
                                       value="{{ is_array($command->tags) ? implode(' ', $command->tags) : $command->tags }}" required>
                            </div>
                            <div class="control-group col-12" >
                                <label for="param">Param</label>
                                <input type="text" id="param" class="form-control" name="param"    value="{!! $command->param !!}"
                                       placeholder="Enter Param command" required>
                            </div>
                            <div class="control-group col-12 mt-2"  >
                                <label for="description">Commande Paramatre Description</label>
                                <textarea id="pdescription" class="form-control" name="pdescription" 
                                          rows="" required>{!! $command->pdescription !!}</textarea>
                            </div>

                        </div>
                        <div class="row mt-2">
                            <div class="control-group col-12 text-center">
                                <button id="btn-submit" class="btn btn-primary">
                                    ADD Command
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <script type="text/javascript">
        
var path = "{{ url('searchcommand') }}";
var x = document.getElementById("description2");

$('#search').typeahead({
    source: function(query, process) {
        
        return $.ajax({
            url: path,  // Spécifiez votre URL ici
            method: 'GET',  // Ou 'POST' selon votre API
            dataType: 'json',  // Indique au serveur que vous attendez des données JSON
            data: {query: query},
            success: function(data) {

                    process(data);
                    
                    //alert(data.length);
                    //if (data.count >0) 
                    if (data.length > 0)  {
                             x.style.display = "none";
                            } else {
                             x.style.display = "block";
                            }
            },
            
            error: function(err) {
                console.error('Erreur AJAX', err);
            }
        });
    }
   
});
$
          /*   $('#search').on('keyup',function()
          {
            $value=$(this).val();
            $.ajax({
                type: 'get',
                url: '{{URL::to('search')}}',
                data: {'search':$value},

                success:function(data)
                {
                    console.log(data);
                    $('#lulu').html(data);
                }

           });
           
           //alert($value);
           })*/
        </script>

@endsection
