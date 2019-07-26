$(".view").click(function(){
	var attribute_id = $(this).attr("attribute_id");

    $.ajax({
        url: '/admin/attributes/view/'+attribute_id,
        method: 'POST',
        data: {}
    }).done(function(rep){
        // console.log(rep);
        $("#attrChild tbody tr").remove();
        rep.forEach(function(r) {
            if(r['status'] == 1){
                $('#attrChild tbody').append('<tr><td>'+r['id']+'</td><td>'+r['name']+'</td><td><p style="background-color: green; color: white; text-align: center;">Active</p></td><td><a class="btn btn-warning" href="/admin/attributes/edit/'
                                        +r['id']+'">Edit</a></td></tr>');
            }else{
                $('#attrChild tbody').append('<tr><td>'+r['id']+'</td><td>'+r['name']+'</td><td><p style="background-color: red; color: white; text-align: center;">Deactive</p></td><td><a class="btn btn-warning" href="/admin/attributes/edit/'
                                        +r['id']+'">Edit</a></td></tr>');
            }
          
        });
    });
});

$(".input").click(function(){
    $(this).find(".error").css({"display": "none"});
});