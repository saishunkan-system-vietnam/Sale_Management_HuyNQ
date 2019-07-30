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

$('#register').click(function() {
    if(this.checked) {
        document.getElementById("new_address").disabled = false;
    } else {
        document.getElementById("new_address").disabled = true;
    }
});

$( "#btn_submit" ).click(function() {
    var new_address = document.getElementById("new_address").value;
    if (new_address == "") {
    document.getElementById("errnew_address").innerHTML = "New Address must be filled out or you can close this.";
    return false;
  }else{
    return true;
  }
});

$("#new_address").click(function(){
    $("#errnew_address").css({"display": "none"});
});

$( "#btn_submit1" ).click(function() {
    var name = $("input[name=name]").val();
    var address = $("input[name=address]").val();
    var phone = $("input[name=phone]").val();
    var email = $("input[name=email]").val();
    var check = 1;
    if (name == "") {
        document.getElementById("errname").innerHTML = "Name must be filled out.";
        check = 0;
        return false;
    }
    if (email == "") {
        document.getElementById("erremail").innerHTML = "Email must be filled out.";
        check = 0;
        return false;
    }
    if (address == "") {
        document.getElementById("erraddress").innerHTML = "Address must be filled out.";
        check = 0;
        return false;
    }
    if (phone == "") {
        document.getElementById("errphone").innerHTML = "Phone must be filled out.";
        check = 0;
        return false;
    }
    if(check == 1){
        return true
    }
});

$(".form-group").click(function(){
    document.getElementById("errname").innerHTML = "";
    document.getElementById("erremail").innerHTML = "";
    document.getElementById("erraddress").innerHTML = "";
    document.getElementById("errphone").innerHTML = "";
});