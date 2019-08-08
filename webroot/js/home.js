$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrfToken"]').attr('content')
    }
});

$(".add2cart").click(function(){
	var product_id = $(this).attr("product_id");
    var quantity = $("input[name=quantity]").val();
    $.ajax({        
        url: '/add2cart',
        method: 'POST',
        data: {
            id : product_id,
            quantity: quantity
        }
    }).done(function(rep){
        console.log(rep);
        if(rep<=5){
            toastr.success("Product add successfull !");
        }else{
            toastr.warning("You can buy max 5 product !");
        }
    });
});

function setParam(name, value) {
    var l = window.location;
    /* build params */
    var params = {};        
    var x = /(?:\??)([^=&?]+)=?([^&?]*)/g;        
    var s = l.search;
    for(var r = x.exec(s); r; r = x.exec(s))
    {
        r[1] = decodeURIComponent(r[1]);
        if (!r[2]) r[2] = '%%';
        params[r[1]] = r[2];
    }

    /* set param */
    params[name] = encodeURIComponent(value);

    /* build search */
    var search = [];
    for(var i in params)
    {
        var p = encodeURIComponent(i);
        var v = params[i];
        if (v != '%%') p += '=' + v;
        search.push(p);
    }
    search = search.join('&');

    /* execute search */
    l.search = search;
}

$("#price").change(function(){
    var value = document.getElementById("price").value;
    var name = 'price';
    var l = window.location;
    /* build params */
    var params = {};        
    var x = /(?:\??)([^=&?]+)=?([^&?]*)/g;        
    var s = l.search;
    for(var r = x.exec(s); r; r = x.exec(s))
    {
        r[1] = decodeURIComponent(r[1]);
        if (!r[2]) r[2] = '%%';
        params[r[1]] = r[2];
    }

    /* set param */
    params[name] = encodeURIComponent(value);

    /* build search */
    var search = [];
    for(var i in params)
    {
        var p = encodeURIComponent(i);
        var v = params[i];
        if (v != '%%') p += '=' + v;
        search.push(p);
    }
    search = search.join('&');

    /* execute search */
    l.search = search;
    alert(search);
    $.ajax({        
        url: search,
        method: 'GET',
        data: {}
    }).done(function(rep){
        console.log(rep);
    });
});