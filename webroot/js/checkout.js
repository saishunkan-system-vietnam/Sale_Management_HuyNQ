$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrfToken"]').attr('content')
    }
});

$(".delete_cart").click(function(){
	var product_id = $(this).attr("product_id");
    // alert(product_id);
	$.ajax({        
        url: '/deleteCart',
        method: 'POST',
        data: {
            id : product_id
        }
    }).done(function(rep){
        console.log(rep);
        toastr.success("Product deleted successfull !");
        location.reload();
    });
});

$('.add').click(function () {
    var product_id = $(this).attr("product_id");
        if ($(this).prev().val() < 5) {

            $.ajax({        
                url: '/add2cart',
                method: 'POST',
                data: {
                    id : product_id
                }
            }).done(function(rep){
                console.log(rep);
                location.reload();
            });
        }else{
            toastr.warning("You can buy max 5 product !");
        }
});

$('.sub').click(function () {
    var product_id = $(this).attr("product_id");
        if ($(this).next().val() > 1) {
        if ($(this).next().val() > 1){
            $(this).next().val(+$(this).next().val() - 1);
            $.ajax({        
                url: '/del2cart',
                method: 'POST',
                data: {
                    id : product_id
                }
            }).done(function(rep){
                console.log(rep);
                location.reload();
            });
        } 
    }
});