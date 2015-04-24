function getRoute(elem,path,id){
   $(elem).html("Cargando Datos.. Espere...");
    var route=Routing.generate(path,{id:id});
       //Juegos Explotados
    $.get(route)
     .success(function(data) {
        $(elem).html(data);
     }).error(function(data, status, headers, config) {
            if (status === '500') {
                message = "No hay conexión con el servidor";
                $(elem).html(message);
            }
       });
}

    function GenerarSolicitud(){
        if(!ValidaForm()) {
            //Dialog('<div class="col-md-12 alert"> Aun Faltan Campos Por Rellenar en la Solicitud </div>','ERROR');
            return false;
        }
        //Dialog('<div class="col-md-12 alert"> Espere un momento mientras se envian los Datos </div>','Info');
        $("#myMessage").html("Esto puede Tardar un poco <br/> Por Favor Espere un momento mientras se cargan los Documentos y se envian los Datos");
        $("#myModal").modal("show");
        $('form').submit();
        return true;
    }

  function ActiveCalendar(){
      $("#error").html("");
      var request = $.ajax({
                 type:"POST",
                 url: Routing.generate('solicitudes_datepicker'),
                 dataType: 'html'
               }); 
            request.done(function (data) {
                  var array = $.parseJSON(data);
                     datepicker(array);
              });
            request.fail(function (jqXHR, textStatus, errorThrown){
                var Btn='<button alt="Reload" class="btn btn-success" onclick="ActiveCalendar();">Reintentar <i class="fa fa-refresh"></i></button>';
                $("#error").html("Falla al Cargar el Calendario<br/>"+Btn);
            });
  }  
   
 
 function datepicker(array) {
        //console.log('On DAtePicker: '+ array);
        var dates=array;
         $( "#datepick" ).datepicker({
           //inline: true,
           autoSize: true,
           altFormat: '@',        // Gives a timestamp dateformat
           minDate: "+1D",
           maxDate: "+3w",
           dateFormat: 'dd/mm/yy',
           constrainInput: true,
           beforeShowDay: function(date){
                  var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
                  if (date.getDay() === 0 || date.getDay() === 6 || $.inArray(string, dates)!==-1) { return [false];}
                   else {return [true];};
                },
           onSelect: function(dateText, inst) { 
               //var dat =new Date(inst.selectedYear+'-'+inst.selectedMonth+'-'+inst.selectedDay);
               //var strdate =jQuery.datepicker.formatDate('yy-mm-dd', dat);
               var datets = Date.parse(inst.selectedYear+'-'+inst.selectedMonth+'-'+inst.selectedDay);
               //GenerarSolicitud(datets);
               $("#date").val(dateText);
               datesl=datets;                    
           } 
         });
 
  }   
  
