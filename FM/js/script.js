$(document).ready(function () {                            

          // disabling dates
          var nowTemp = new Date();
          var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

          var checkin = $('#dpd1').datepicker({
          onRender: function(date) {
              return date.valueOf() < now.valueOf() ? 'disabled' : '';
          }
          }).on('changeDate', function(ev) {
          if (ev.date.valueOf() > checkout.date.valueOf()) {
              var newDate = new Date(ev.date)
              newDate.setDate(newDate.getDate() + 1);
              checkout.setValue(newDate);
          }
          checkin.hide();
    
          $('#dpd2')[0].focus();
          }).data('datepicker');
          var checkout = $('#dpd2').datepicker({
          onRender: function(date) {
              return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
          }
          }).on('changeDate', function(ev) {
          checkout.hide();
          }).data('datepicker');    


          //Categorias

          $("#categoriaPadre").change(function(){
            $.ajax({
              url:"../subCategorias.php",
              type: "POST",
              data:"idCategoriaPadre="+$("#categoriaPadre").val(),
              success: function(opciones){
                $("#subCategoria").html(opciones);
              }
            })
          });


          //Al seleccionar una subcategoria
          $("#subCategoria").change(function(){
            //$('#miModelo').modal('toggle');
            $.ajax({
              url: "../productoByCategoria.php",
              type: "POST",
              data: "idSubCategoria="+$("#subCategoria").val(),
              success: function(datos){
                $("#modelBody").html(datos);                
              }
            })
            $('#miModelo').modal('show');
            //$('#miModelo').modal('hide');
            //alert($("#subCategoria").val());
          });

          $( "p" ).click(function() {            
            $("#producto").val($(this).text());
            $("#valProducto").val($(this).text());
            $('#miModelo').modal('hide');
            //alert($(this).text());
          });

      });