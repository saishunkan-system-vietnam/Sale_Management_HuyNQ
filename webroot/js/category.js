$(".view").click(function(){
	var category_id = $(this).attr("category_id");

    $.ajax({
        url: '/admin/categories/view/'+category_id,
        method: 'POST',
        data: {}
    }).done(function(rep){
        // console.log(rep);
        $("#cateChild tbody tr").remove();
        rep.forEach(function(r) {
            if(r['status'] == 1){
                $('#cateChild tbody').append('<tr><td>'+r['id']+'</td><td>'+r['name']+'</td><td><p style="background-color: green; color: white; text-align: center;">Active</p></td><td><a class="btn btn-warning" href="/admin/categories/edit/'
                                        +r['id']+'">Edit</a></td></tr>');
            }else{
                $('#cateChild tbody').append('<tr><td>'+r['id']+'</td><td>'+r['name']+'</td><td><p style="background-color: red; color: white; text-align: center;">Deactive</p></td><td><a class="btn btn-warning" href="/admin/categories/edit/'
                                        +r['id']+'">Edit</a></td></tr>');
            }
          
        });
    });
});