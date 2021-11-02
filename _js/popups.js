function displayModal(modalTitle,modalText,type){
    $('#modalTitle').text(modalTitle);
    $('#modalBody').html(modalText);
    $('#informationModal-ok').text('Ok');
    switch(type){
        case 0 : //Information
            $('#informationModal-ok').removeClass('btn-danger');
            $('#informationModal-ok').addClass('btn-primary');
            break;
        case 1 : //Attention
            break;
        default :
            console.log("Display modal error")
    }
    $('#informationModal').modal('show');

}
$('#informationModal-ok').click(function(){
    $('#informationModal').modal('hide');
    //location.reload();
    //window.location.href = window.location;
    //window.opener.location.reload();

});


var modalConfirm = function(callback){
  
    $("#btn-confirm").on("click", function(){
      $("#mi-modal").modal('show');
    });
  
    $("#modal-btn-si").on("click", function(){
      callback(true);
      $("#mi-modal").modal('hide');
    });
    
    $("#modal-btn-no").on("click", function(){
      callback(false);
      $("#mi-modal").modal('hide');
    });
  };
  
  /* modalConfirm(function(confirm){
    if(confirm){
      //Acciones si el usuario confirma
      $("#result").html("CONFIRMADO");
    }else{
      //Acciones si el usuario no confirma
      $("#result").html("NO CONFIRMADO");
    }
  });*/