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
                    <h1 class="display-4">Add a New Argument</h1>
                    <p>Rensignez les champs nécéssaire</p>

                    <hr>

                    <form action="" method="POST">
                        @csrf
                        <div class="row">
                            <div class="control-group col-12">
                                <label for="command">Argument Name</label>

                                <input class="typeahead form-control" id="search" name="argument" type="text">
                                
                                       
                            </div>
                            <div class="control-group col-12 mt-2" id="description2">
                                <label for="description" >Argument Description</label>
                                <textarea id="cdescription" class="form-control" name="cdescription" placeholder="Enter Post Body"
                                          rows="" ></textarea>
                            </div>
                           

                        </div>
                        <div class="row mt-2">
                            <div class="control-group col-12 text-center">
                                <button id="btn-submit" class="btn btn-primary">
                                    ADD Argument
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
var y = document.getElementById("tags2");

$(document).ready(function() {
        $('#search').typeahead({
            source: function(query, process) {
                return $.ajax({
                    url: path, // Replace 'path' with your API URL
                    method: 'GET',
                    dataType: 'json',
                    data: { query: query },
                    success: function(data) {
                        process(data); // Populate the suggestions

                        // Check if there are matching results
                        if (data.length > 0) {
                            // Hide description and tags fields
                            $('#description2').hide();
                            $('#tags2').hide();
                        } else {
                            // Show description and tags fields
                            $('#description2').show();
                            $('#tags2').show();
                        }
                    },
                    error: function(err) {
                        console.error('AJAX Error:', err);
                    }
                });
            }
        });
    });$



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
