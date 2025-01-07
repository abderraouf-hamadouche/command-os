@extends('layouts.app')

@section('content')


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js" ></script>

       
  
     

    
    
    
     
<form id="procedureForm" action="" method="post">
@csrf
<div class="container"style="width: 70%" >
<a href="../../intervention" class="btn btn-outline-primary btn-sm">Go back</a>
<h3 class="text-muted">Procedure creation Form</h3>
          <div class="header clearfix"></div>
                 <div class="form-group" style="">
                 <label>Nom de la Procédure</label>

                 <input type="hidden" id="order0" name="inputs[0][order]" value="0">
                 <input  name="inputs[0][command]" id="NameProc"  type="text"  class="form-control">
          </div>
                 <div class="form-group" style="">
                   <label>Description de la Procédure:</label>
                   <textarea  name="inputs[0][desc]" id="DescProc"  class="form-control"></textarea>
                 </div>
             <div class="header clearfix"></div>


             </div>

           <div class="container" style="width: 70%">
             <div class="form-group" style="">
               <label for="rechercher" style=" display: block;">Nom de la Commande</label>
               <input type="text" id="rechercher" style="width: 85%; display: inline;" class="form-control"> 
               <button type="button" id="click" class="btn btn-primary" style="width: 14%">Rechercher</button>
             </div>
             <div class="form-group" style="">
               <label for="select" style=" display: block;">Choose an option</label>
               <select id="select" name="select" class="form-control" style="width: 85%; display: inline;">
                 <option value="" selected="" disabled="" hidden="">Merci de rechercher d'abord une Commande</option>
               </select>
               <button type="button"  id="ajouter" class="btn btn-primary" style="width: 14%">Ajouter</button>
             </div>

             <table class="table" style="">		
               <thead><tr><th>#</th><th>Nom de la Commande</th><th>Parametre de la Commande</th><th>Description de la tache</th></tr></thead>
               <tbody id="tintervention">			
               <tr id="first-tf">
                      <th><input type="text" name="inputs[0][order]"    readonly class="form-control-plaintext" style=" border:none;outline: 0;" value="0"required></th>
                      <th><input type="text" name="inputs[0][command]"  readonly class="form-control" style=" outline: 0;"required></th>
                      <th><input type="text" name="inputs[0][param]"     readonly class="form-control" style=" outline: 0;"required></th>
                      <th><input type="text" name="inputs[0][desc]"      readonly class="form-control" style=" outline: 0;"required></th>
               </tr>   

               </table>
               <input type="hidden" id="variableCount" name="variableCount" value="0" required>
               <button type="submit" class="btn btn-primary" id="adproc">Create Procedure</button>

</form>
  </div>



            </div>
        </div>
    </div>
</div>
    <script type="text/javascript">
        
var pathc = "{{ url('searchcommand') }}";
// searching autocomplete command
$('#rechercher').typeahead({
    source: function(query, process) {
        
        return $.ajax({
            url: pathc,  // Spécifiez votre URL ici
            method: 'GET',  // Ou 'POST' selon votre API
            dataType: 'json',  // Indique au serveur que vous attendez des données JSON
            data: {query: query},
            success: function(data) {

                    process(data);
                    //$('#searchp').html(data);
            },
            
            error: function(err) {
                console.error('Erreur AJAX', err);
            }
        });
    }
   
}); 

var pathp = "{{ url('searchparam') }}";
 
// listing   parametre of the searched command
$('#click').click(function(){
    //alert(document.getElementById("searchc").value);
    $value=document.getElementById("rechercher").value;
    var parts = $value.split('-');
    //alert(parts[1]);
    // Trim any leading or trailing whitespace from each part
    //var part1 = parts[0].trim();
    //var part2 = parts[1].trim();
    $.ajax({
                type: 'get',
                url: '{{URL::to('searchparam')}}',
                data: {'query':document.getElementById("rechercher").value},

                success:function(data)
                {
                    //console.log(data);
                    $('#select').html(data);
                }

           });

        });


// add To Table 
$('#ajouter').click(function(){
                            $variableCount = parseInt(document.getElementById("variableCount").value, 10);
                             if ($variableCount == 0)   {
                             var rowToRemove = document.getElementById("first-tf");
                             rowToRemove.remove(); }



                            $variableCount++;
                            document.getElementById("variableCount").value = $variableCount;
                            //alert(document.getElementById("rechercher").value);
                            $val1=document.getElementById("NameProc").value;
                            $val2=document.getElementById("rechercher").value;
                            //$val2 = document.getElementById("rechercher").value;
                            var selectElement=document.getElementById("select");
                            var selectedIndex = selectElement.selectedIndex;
                            $val3 = selectElement.options[selectedIndex].value;
                            $val33 = selectElement.options[selectedIndex].text;

                            $val4=$('#tintervention tr').length+1
                            
                            var container = document.getElementById("tintervention");
                            var newRow = document.createElement('tr');
                            var newCell1 = document.createElement('td');
                            var newCell2 = document.createElement('td');
                            var newCell3 = document.createElement('td');
                            var newCell4 = document.createElement('td');
                            newCell1.innerHTML = '<input type="text"   name=inputs['+$variableCount+'][order]  readonly class="form-control-plaintext" style="border: none; outline: 0;" value="'+$val4+'" required>';
                            newCell2.innerHTML = '<input type="hidden" name=inputs['+$variableCount+'][command] readonly class="form-control-plaintext" style="border: none; outline: 0;" value="'+$val2+'" required>'+$val2;
                            newCell3.innerHTML = '<input type="hidden" name=inputs['+$variableCount+'][param] readonly class="form-control-plaintext" style="border: none; outline: 0;" value="'+$val33+'"required>'+$val33+'';
                            newCell4.innerHTML = '<input type="text"   name=inputs['+$variableCount+'][desc]" class="form-control " class="form-control-plaintext" required style="border: none; outline: 0;"required>';

                            newRow.appendChild(newCell1);
                            newRow.appendChild(newCell2);
                            newRow.appendChild(newCell3);
                            newRow.appendChild(newCell4);

                            container.appendChild(newRow);




                            //$dat='   <tr scope="row'+$val4+'">     <th><input type="text" name=order'+$val4+'  readonly class="form-control-plaintext" style="border: none; outline: 0;" value="'+$val4+'"></th>     <th><input type="text" name=c'+$val4+' readonly class="form-control-plaintext" style="border: none; outline: 0;" value="'+$val2+'"></th>     <th><input type="hidden" name=p'+$val4+' readonly class="form-control-plaintext" style="border: none; outline: 0;" value="'+$val3+'">'+$val33+'</th>    <th><input type="text" name="d'+$val4+'" class="form-control " class="form-control-plaintext" style="border: none; outline: 0;"></th></tr> ';
                            //$('#tintervention').append($dat);
                            
                          });

 


                          document.getElementById('procedureForm').addEventListener('submit', function (event) {
  event.preventDefault();
  document.getElementById('procedureForm').submit();
  // Your form submission logic here
});








                          

        </script>

@endsection
