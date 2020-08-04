$(document).ready(function () {
  $(".trigger_change").on('change', function() {
    var valorInput =  this.value;
    if(this.type == 'checkbox'){
      if ($(this).is(":checked") == true){
        valorInput = 1;
      }else{
        valorInput = 0;
      }
    }
    var urlPost = '/api/examenes/guardar/' + ExamenId + '/' + this.id + '/' + valorInput + '?_token=' + tokenValList;
    $.post( urlPost, function( data ) {
      // console.log(data);
    });
  });
});
