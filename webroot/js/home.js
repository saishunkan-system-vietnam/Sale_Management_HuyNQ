$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrfToken"]').attr('content')
    }
});

$(".add2cart").click(function(){
	var product_id = $(this).attr("product_id");
    var quantity = $("input[name=quantity]").val();
    $.ajax({        
        url: '/add2cart',
        method: 'POST',
        data: {
            id : product_id,
            quantity: quantity
        }
    }).done(function(rep){
        console.log(rep);
        if(rep<=5){
            toastr.success("Product add successfull !");
        }else{
            toastr.warning("You can buy max 5 product !");
        }
    });
});