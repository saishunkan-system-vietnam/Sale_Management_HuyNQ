
$("#categoryParent").change(function(){
	var idCategory = $(this).val();
    // var test = $(this).find('option:selected').text();
    $.ajax({
        url: '/admin/products/getcateChild/'+idCategory,
        method: 'POST',
        data: {}
    }).done(function(rep){
        // console.log(rep);
        $('#categoryChild').find('option').remove();
        rep.forEach(function(r) {
          $('#categoryChild').append(new Option(r['name'], r['id']));
        });
    });
});

// CKEDITOR.replace('description');





