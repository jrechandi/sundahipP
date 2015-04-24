  function CDialog(msg, title, callback ){
      if (!title) title = 'Confirm';
       msg = (typeof(msg) == 'undefined') ? 'Confirm This?': msg ;
       var alert=$('<div></div>')
                .css('display', 'none')
                .html(msg)
                .addClass('animated fadeInDown white-bg text-center')
                .appendTo('body');
       var diagOpt={
                autoOpen: true,
                modal:true,
                width: "330px",
                height: "160px",
                top: "auto", 
                title: title,
                resizable: false, 
                zIndex: 10000,
                my: "center",
                at: "center",
                of: window,
                buttons: {
                    Yes: function () {
                         callback();
                        $(this).dialog("close");
                    },
                    No: function () {
                        $(this).dialog("close");
                    }
                },
                close: function (event, ui) {
                    $(this).remove();
                }
            };
          alert.dialog(diagOpt);
          return alert;
    }
    
   function ADialog(msg,title){
       if (!title) title = 'Alert';
       msg = (typeof(msg) == 'undefined')? 'Alert!!': msg ;
        var alert=$('<div></div>')
                .css('display', 'none')
                .html(msg)
                .addClass('animated fadeInDown white-bg text-center')
                .appendTo('body');
        var diagOpt={
            autoOpen: true,
            modal:true,
            width: 330,
            height:160,
            top: 50,
            title: title,
            resizable: false,
            zIndex: 10000,
            buttons: { "Ok": function() { $(this).dialog("close"); } },
            close: function (event, ui) { $(this).remove(); }
            //height: auto
        };
        alert.dialog(diagOpt);
        return alert;
    }   
    
    function Dialog(msg,title){
        var alert=$('<div></div>')
                .css('display', 'none')
                .html(msg)
                .addClass('animated fadeInDown white-bg text-center')
                .appendTo('body');
        var diagOpt={
            autoOpen: true,
            modal:true,
            width: 330,
            height:180,
            top: 50,
            title: title,
            resizable: false,
            zIndex: 10000,
            //buttons: { "Ok": function() { $(this).dialog("close"); } },
            close: function (event, ui) { $(this).remove(); }
            //height: auto
        };
        alert.dialog(diagOpt);
        return alert;
    }   
    
    function ShowDatepick(datepick){
        $(datepick).datepicker({
           //inline: true,
           autoSize: true,
           dateFormat: 'dd-mm-yy',
           lang: 'es'
         //showOn: "button",
           //  buttonImage: "images/calendar.gif",
           //  buttonImageOnly: true
         });
    }
    
  function getSpiner(){
      //return '<div id="refresh" class="col-md-2 col-md-offset-5 text-center"><i class="fa fa-2x fa-refresh icon-refresh-animate"></i> </div>';
      return '<div id="refresh" class="col-md-2 col-md-offset-5 text-center"><i class="fa fa-2x fa-spinner icon-refresh-animate"></i> </div>';
  }  
  
  function getGifLoading(){
      return '<div id="refresh" class="col-md-2 col-md-offset-5 text-center"><img src="/bundles/newtemplate/images/loading.gif"  title="Cargando"/> </div>';
  }

  
  function MyModal(msg,title){
    var cont='';
    var mod =$('<div></div>');
    cont='<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">' +
    '<div class="modal-dialog">'+
        '<div class="modal-content">'+
            '<div class="modal-header">'+
                '<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>'+
                '<h4 class="modal-title" id="myModalLabel"></h4></div>'+
            '<div class="modal-body">'+
               ' <div class="row">'+
                    '<div class="col-md-12 alert text-left" id="myMessage">'+
                    '</div></div></div></div></div></div>';
       mod.html(cont);     
       mod.appendTo('body');
       $("#myModalLabel").html(title);
       $("#myMessage").html(msg);
       $("#myModal").modal("show");
  }