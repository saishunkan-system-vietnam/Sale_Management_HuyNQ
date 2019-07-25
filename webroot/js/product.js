
// CKEDITOR.replace('description');

$("#categoryParent").click(function(){
    $.ajax({
        url: '/admin/products/select',
        method: 'POST',
        data: {}
    }).done(function(rep){
        console.log(rep);
        // $('#categoryChild').find('option.opt').remove();
        // rep.forEach(function(r) {
        //   $('#categoryChild').append('<option class="opt" value='+r['id']+'>'+r['name']+'</option>');
        // });
    });
});




