$("#categoryParent").change(function(){
	var idCategory = $(this).val();
    if(idCategory == 1){
    	$("#Mobile").css("display", "block");
    	$("#Mobile").prop('disabled', false);
    	$("#Laptop").css("display", "none");
    	$("#Laptop").prop('disabled', true);
    }else{
    	$("#Laptop").css("display", "block");
    	$("#Laptop").prop('disabled', false);
    	$("#Mobile").css("display", "none");
    	$("#Mobile").prop('disabled', true);
    }
});


// $("#category").click(function(){
// });