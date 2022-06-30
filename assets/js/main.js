$('#emptyCart').click(function(){
    $.ajax({
        type: 'POST',
        url: 'ajax_calls.php',
        dataType: 'json',
        data: {action:'empty',empty_cart:true},
        success:function(data){
            if (data.msg == 'success') {
                window.location.href = 'cart.php';
            }
        }
    });
});