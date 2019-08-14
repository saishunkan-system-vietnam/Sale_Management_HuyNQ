
// CKEDITOR.replace('description');
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrfToken"]').attr('content')
    }
});

$("#category").change(function(){
    var category_id = $(this).val();
    // alert(category_id);
    $.ajax({
        url: '/admin/products/searchCate',
        method: 'POST',
        data: {category_id: category_id}
    }).done(function(rep){
        console.log(rep);
        $("#product_table tbody tr").remove();
        if(rep !== ""){
            $("#product_table tbody").html(rep);
        }else{
            $("#product_table tbody").html("Not data");
        } 
    });
});

$(".input").click(function(){
    $(this).find(".error").css({"display": "none"});
});

$("#btn_search").click(function(){
    var data = document.getElementById("input_search").value;
    if(data !== ""){
        $.ajax({
            url: '/admin/products/search',
            method: 'POST',
            data: {data: data}
        }).done(function(rep){
            console.log(rep);
            $("#product_table tbody tr").remove();
            if(rep !== ""){
                $("#product_table tbody").html(rep);
            }else{
                $("#product_table tbody").html("Not data");
            }       
        });
    }
});







