
// CKEDITOR.replace('description');

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
        $("#product_table tbody").html(rep);
    });
});

$(".input").click(function(){
    $(this).find(".error").css({"display": "none"});
});



