@extends('layouts.app')
@section('content')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <div class="container">
        <div class="row">
            <div class="col-12 text-center pt-5">
                <h1 class="display-one mt-5">{{ config('app.name') }}</h1>
                <p id="none">By Admins For Admins</p>
                <br>
                <a href="command" class="btn btn-outline-primary">Show Commands</a>
                <br>
                <br>
                <a href="intervention" class="btn btn-outline-primary">Show Procédures</a>
            </div>

            <div class="container mt-3">
                <div class="row">
                    <div class="col-md-12 text-center mt-5">
                        <h2>IT Command Helper</h2>
                    </div>
                    <div class="col-md-12 text-center mt-1 " >
                        <input type="seach" name="search" id="search" style="width: 60%;" placeholder="Type to start search" >
                    </div>
                    <table id="lulu"></table>
                </div>
            </div>
        </div>
    </div>
   
    <script type="text/javascript">
          $('#search').on('keyup',function()
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
           })
        


    </script>


@endsection