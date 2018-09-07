
$(document).ready(function(){

    $("#current_pwd").keyup(function () {
       var current_pwd = $('#current_pwd').val();
       $.ajax({
           type:'get',
           url:'/admin/check-pwd',
           data:{current_pwd:current_pwd},
           success:function (resp) {
                if (resp == "false") {
                    $('#chkPwd').html("<font color='red'>Current Password is incorrect</font>");
                } else {
                    $('#chkPwd').html("<font color='green'>Current Password is correct</font>");
                }
           },
           error:function () {
                alert('Error');
           }
       });
    });

    $("#add_category").validate({
        rules:{
            name:{
                required:true
            },
            description:{
                required:true
            },
            url:{
                required:true
            }
        },
        errorClass: "help-inline",
        errorElement: "span",
        highlight:function(element, errorClass, validClass) {
            $(element).parents('.control-group').addClass('error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.control-group').removeClass('error');
            $(element).parents('.control-group').addClass('success');
        }
    });

    $("#edit_category").validate({
        rules:{
            name:{
                required:true
            },
            description:{
                required:true
            },
            url:{
                required:true
            }
        },
        errorClass: "help-inline",
        errorElement: "span",
        highlight:function(element, errorClass, validClass) {
            $(element).parents('.control-group').addClass('error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.control-group').removeClass('error');
            $(element).parents('.control-group').addClass('success');
        }
    });

    $(document).on('click', '.del-cat', function (e) {
        var id = $(this).attr('rel');
        var delete_func = $(this).attr('rel1');
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this category!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                window.location.href = "/admin/" + delete_func + "/" + id;
            } else {
                swal("This category is safe!");
            }
        });
    });

    $("#add_product").validate({
        rules:{
            category_id: {
                required:true
            },
            name:{
                required:true
            },
            code:{
                required:true
            },
            color:{
                required:true
            },
            price:{
                required:true,
                number:true
            }
        },
        errorClass: "help-inline",
        errorElement: "span",
        highlight:function(element, errorClass, validClass) {
            $(element).parents('.control-group').addClass('error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.control-group').removeClass('error');
            $(element).parents('.control-group').addClass('success');
        }
    });

    $("#edit_product").validate({
        rules:{
            category_id: {
                required:true
            },
            name:{
                required:true
            },
            code:{
                required:true
            },
            color:{
                required:true
            },
            price:{
                required:true,
                number:true
            }
        },
        errorClass: "help-inline",
        errorElement: "span",
        highlight:function(element, errorClass, validClass) {
            $(element).parents('.control-group').addClass('error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.control-group').removeClass('error');
            $(element).parents('.control-group').addClass('success');
        }
    });

    $(document).on('click', '.del-product', function (e) {
        var id = $(this).attr('rel');
        var delete_func = $(this).attr('rel1');
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this product!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                window.location.href = "/admin/" + delete_func + "/" + id;
            } else {
                swal("This product is safe!");
            }
        });
    });

    $(document).on('click', '.del-attribute', function (e) {
        var id = $(this).attr('rel');
        var delete_func = $(this).attr('rel1');
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this attribute!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                window.location.href = "/admin/" + delete_func + "/" + id;
            } else {
                swal("This attribute is safe!");
            }
        });
    });

    $(document).on('click', '.del-images', function (e) {
        var id = $(this).attr('rel');
        var delete_func = $(this).attr('rel1');
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this image!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                window.location.href = "/admin/" + delete_func + "/" + id;
            } else {
                swal("This image is safe!");
            }
        });
    });

    $(document).on('click', '.del-coupon', function (e) {
        var id = $(this).attr('rel');
        var delete_func = $(this).attr('rel1');
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this coupon!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                window.location.href = "/admin/" + delete_func + "/" + id;
            } else {
                swal("This coupon is safe!");
            }
        });
    });

	$('input[type=checkbox],input[type=radio],input[type=file]').uniform();
	
	$('select').select2();

    $(document).ready(function(){
        var maxField = 10; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        var fieldHTML = '<div><input type="text" name="sku[]" id="sku" placeholder="SKU" style="width: 120px;" required /><input type="text" name="size[]" id="size" placeholder="Size" style="width: 120px;" required /><input type="text" name="price[]" id="price" placeholder="Price" style="width: 120px;" required /><input type="text" name="stock[]" id="stock" placeholder="Stock" style="width: 120px;" required /><a href="javascript:void(0);" class="remove_button">Remove</a></div>'; //New input field html
        var x = 1; //Initial field counter is 1

        //Once add button is clicked
        $(addButton).click(function(){
            //Check maximum number of input fields
            if(x < maxField){
                x++; //Increment field counter
                $(wrapper).append(fieldHTML); //Add field html
            }
        });

        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e){
            e.preventDefault();
            $(this).parent('div').remove(); //Remove field html
            x--; //Decrement field counter
        });
    });
});
