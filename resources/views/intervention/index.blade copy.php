@extends('layouts.app')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <div class="container">
        <div class="row">
            <div class="col-12 pt-2">
                 <div class="row">
                    <div class="col-8">
                        <p>Enjoy reading our Procédures. Click on a Procédure to read IT!</p>
                    </div>
                    <div class="col-4">
                        <p>Create new Procédure</p>
                        <a href="{{ route('intervention.create') }}" class="btn btn-primary btn-sm">Ajout Procédure</a>
                    </div>
                    <div class="col-8">
                    @forelse($interventions as $intervention)
                    @php
                       // if ($intervention->order == 0) {
                    @endphp
                            <ul>
                                <li><h5><a href="./intervention/{{ $intervention->id }}">{{ ucfirst($intervention->intervention) }} </a></h5> <h6> {{ ucfirst($intervention->description) }}</h6></li>
                                
                            </ul>
                    @php
                       // }
                    @endphp
                @empty
                    <p class="text-warning">Nothing To see here.</p>
                @endforelse
                    </div>

                    <div class="col-4">
                        <p>Base de Connaissance</p>
                        <input type="seach" name="search" id="search" style="width: 60%;" placeholder="Search Hbibi Search" >
                        <table id="lulu"></table>
                    </div>

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
                url: '{{URL::to('searchint')}}',
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