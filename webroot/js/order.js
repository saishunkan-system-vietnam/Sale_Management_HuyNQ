$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrfToken"]').attr('content')
    }
});

$("#btn_search").click(function(){
	var data = $("input[name=data]").val();
	var status = $("#status").val();
    $.ajax({        
        url: '/admin/orders/search',
        method: 'POST',
        data: {
            status : status,
            data: data
        }
    }).done(function(rep){
    	console.log(rep);
        $("#order_table tbody tr").remove();
        if(rep !== ""){
            $("#order_table tbody").html(rep);
        }else{
            $("#order_table tbody").html("Not data");
        } 
    });
});