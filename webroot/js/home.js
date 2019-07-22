$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrfToken"]').attr('content')
    }
});

$(".add2cart").click(function(){
	var product_id = $(this).attr("product_id");
    // alert(product_id);
    $.ajax({      
        // headers: {'X-CSRF-Token': $('meta[name="csrfToken"]').attr('content')},  
        url: '/add2cart',
        method: 'POST',
        data: {
            id : product_id
        }
    }).done(function(rep){
        console.log(rep);
        toastr.success("Product add successfull !");
    });
});