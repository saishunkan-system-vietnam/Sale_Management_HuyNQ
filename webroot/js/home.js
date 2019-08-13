$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrfToken"]').attr('content')
    }
});

$(".compare").click(function(){
    var product_id = $(this).attr("product_id");
    $.ajax({        
        url: '/compare',
        method: 'POST',
        data: {
            id : product_id
        }
    }).done(function(rep){
        console.log(rep);
        if (rep == 0) {
            toastr.success("Product added to compare !");
        }
        if (rep == 1) {
            toastr.error("2 product compare was added !");
        }
        if (rep == 2) {
            toastr.warning("Product added to compare !");
        }
    });
});

$(".btn_del").click(function(){
    var product_id = $(this).attr("product_id");
    $.ajax({        
        url: '/delcompare',
        method: 'POST',
        data: {
            id : product_id
        }
    }).done(function(rep){
        console.log(rep);
        location.reload();
    });
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
    if (window.location.href.indexOf(name+"="+value+"") > -1) {
        var l = window.location+'';
        var alteredURL = removeParam(name, l);  
        window.location = alteredURL;  
    } else {
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
        // alert(search);
    }
}

function removeParam(key, sourceURL) {
    var rtn = sourceURL.split("?")[0],
        param,
        params_arr = [],
        queryString = (sourceURL.indexOf("?") !== -1) ? sourceURL.split("?")[1] : "";
    if (queryString !== "") {
        params_arr = queryString.split("&");
        for (var i = params_arr.length - 1; i >= 0; i -= 1) {
            param = params_arr[i].split("=")[0];
            if (param === key) {
                params_arr.splice(i, 1);
            }
        }
        rtn = rtn + "?" + params_arr.join("&");
    }
    return rtn;
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
    // alert(search);
    $.ajax({        
        url: search,
        method: 'GET',
        data: {}
    }).done(function(rep){
        console.log(rep);
    });
});

$(".search-btn").click(function(){
    var data = document.getElementById("keyword").value;
    if (window.location.href.indexOf("keyword="+data+"") > -1) {
        var l = window.location+'';
        var alteredURL = removeParam("keyword", l);  
        window.location = alteredURL;
    } else {
        if (data == '') {
            return false;
        } else {
            setParam('keyword', data);
        }
    }
});

// window.onload = function () {
//     // Set the date we're counting down to
//     var countDownDate = new Date("Jan 5, 2020 15:37:25").getTime();

//     // Update the count down every 1 second
//     var x = setInterval(function() {

//       // Get today's date and time
//       var now = new Date().getTime();
        
//       // Find the distance between now and the count down date
//       var distance = countDownDate - now;
        
//       // Time calculations for days, hours, minutes and seconds
//       var days = Math.floor(distance / (1000 * 60 * 60 * 24));
//       var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
//       var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
//       var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
//       // Output the result in an element with id="demo"
//       document.getElementById("demo").innerHTML = days + "d " + hours + "h "
//       + minutes + "m " + seconds + "s ";
        
//       // If the count down is over, write some text 
//       if (distance < 0) {
//         clearInterval(x);
//         document.getElementById("demo").innerHTML = "EXPIRED";
//       }
//     }, 1000);
// }