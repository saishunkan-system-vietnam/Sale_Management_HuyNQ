$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(".add2cart").click(function(){
	var product_id = $(this).attr("product_id");
    // alert(product_id);
    $.ajax({
        url: '/products/add2cart/'+product_id,
        method: 'POST',
        data: {}
    }).done(function(rep){
        toastr.success("Product add successfull !");
    });
});