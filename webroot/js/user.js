$(".input").click(function(){
    $(this).find(".error").css({"display": "none"});
});

$("#type").change(function(){
    var type = $(this).val();
    // alert(category_id);
    $.ajax({
        url: '/admin/users/searchType',
        method: 'POST',
        data: {type: type}
    }).done(function(rep){
        $("#user_table tbody tr").remove();
        $("#user_table tbody").html(rep);
    });
});

$("#btn_search").click(function(){
    var data = document.getElementById("input_search").value;
    if(data !== ""){
	    $.ajax({
		    url: '/admin/users/search',
		    method: 'POST',
		    data: {data: data}
		}).done(function(rep){
		    $("#user_table tbody tr").remove();
		    $("#user_table tbody").html(rep);
		});
    }
});