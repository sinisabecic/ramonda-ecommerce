//? Edit ship order
$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Access-Control-Allow-Origin': '*',
            'Access-Control-Allow-Methods': 'GET,POST,PUT,PATCH,DELETE,OPTIONS',
            'Access-Control-Max-Age': '3600',
            'Access-Control-Allow-Headers': 'x-requested-with, content-type',
            'Accept': 'application/json',
        }
    });

    $('#editOrderForm').submit(function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        const url = $('#editOrderForm').data('url');
        $.ajax({
            method: 'POST',
            url: url,
            data: formData,
            success: function () {
                Swal.fire({
                    title: 'Success!',
                    // text: '',
                    icon: 'success',
                    toast: true,
                    position: 'top-right',
                    showConfirmButton: false,
                    timer: 2500,
                });

                $('#shipped').toggleClass('border-success text-success font-weight-700');
                $('#shipped').toggleClass('border-warning text-warning font-weight-700');
            },
            error: function () {
                // alert('Greska! Pokusaj ponovo');
                Swal.fire({
                    title: 'Error! Something went wrong',
                    // text: '',
                    icon: 'error',
                    toast: true,
                    position: 'top-right',
                    showConfirmButton: false,
                    timer: 2500,
                });
                $('#shipped').toggleClass('border-warning text-warning font-weight-700');
                $('#shipped').toggleClass('border-success text-success font-weight-700');
            },
            contentType: false,
            processData: false,
        })
        ;
    });


    //? select all on click
    $('#master').on('click', function (e) {
        if ($(this).is(':checked', true)) {
            $(".sub_chk").prop('checked', true);
        } else {
            $(".sub_chk").prop('checked', false);
        }
    });
});

//? Ship order on orders page
function shipOrder(item) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    Swal.fire({
        title: 'Ship order?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3C4B64',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!',
        toast: true,
        position: 'top-right',

    }).then((result) => {
        if (result.isConfirmed) {
            const formData = {id: item};
            $.ajax({
                type: "PUT",
                url: "/admin/products/orders/" + formData.id + "/shipOrder",
                data: formData,
                success: function (response) {
                    if (response.error) {
                        console.log(response.error);
                        Swal.fire({
                            title: 'Error! Try again.',
                            // text: '',
                            icon: 'error',
                            toast: true,
                            position: 'top-right',
                            showConfirmButton: false,
                            timer: 2500,
                        })
                    } else {
                        Swal.fire({
                            title: 'Shipped!',
                            // text: '',
                            icon: 'success',
                            toast: true,
                            position: 'top-right',
                            showConfirmButton: false,
                            timer: 2500,
                        })
                        console.log("Shipped order ID: " + formData.id);
                        $(".row-order[data-id=" + formData.id + "] .shipOrderBtn").text("Shipped").attr("disabled", "disabled");
                        $(".row-order[data-id=" + formData.id + "] .noShippedBadge")
                            .text("Shipped")
                            .removeClass('badge-warning text-dark')
                            .addClass('badge-success');

                        $(".row-order[data-id=" + formData.id + "] .IdBadge")
                            .removeClass('badge-warning text-dark')
                            .addClass('badge-success');
                    }
                }
            })
        }
    });
}

//? Ship selected orders
function shipOrders() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Access-Control-Allow-Origin': '*',
            'Access-Control-Allow-Methods': 'GET,POST,PUT,PATCH,DELETE,OPTIONS',
            'Access-Control-Max-Age': '3600',
            'Access-Control-Allow-Headers': 'x-requested-with, content-type',
            'Accept': 'application/json',
        }
    });


    Swal.fire({
        title: 'Ship selected order(s)?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3C4B64',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!',
        toast: true,
        position: 'top-right',

    }).then((result) => {

        var allVals = [];
        $(".sub_chk:checked").each(function () {
            allVals.push($(this).attr('data-id'));
        });

        if (allVals.length <= 0) {
            Swal.fire({
                title: 'Please select order(s)!',
                icon: 'warning',
                toast: true,
                position: 'top-right',
            });
        } else {
            var join_selected_values = allVals.join(",");
            var url = $(".bulkShipOrdersBtn").data("url");

            if (result.isConfirmed) {
                $.ajax({
                    method: "POST",
                    url: url,
                    data: "ids=" + join_selected_values,
                    success: function (response) {
                        if (response.error) {
                            Swal.fire({
                                title: 'Error! Try again.',
                                // text: '',
                                icon: 'warning',
                                toast: true,
                                position: 'top-right',
                                showConfirmButton: false,
                                timer: 2500,
                            });
                        } else {
                            Swal.fire({
                                title: 'Order(s) shipped!',
                                // text: '',
                                icon: 'success',
                                toast: true,
                                position: 'top-right',
                                showConfirmButton: false,
                                timer: 2500,
                            });

                            $.each(allVals, function (index, value) {
                                console.log("Shipped order: " + value);
                                $(".row-order[data-id=" + value + "] .shipOrderBtn").text("Shipped").attr("disabled", "disabled");
                                $(".row-order[data-id=" + value + "] .noShippedBadge")
                                    .text("Shipped")
                                    .removeClass('badge-warning text-dark')
                                    .addClass('badge-success');

                            });
                        }
                    },
                    error: function (data) {
                        alert(data.responseText);
                    }
                });
            }
        }
    });
}

//? Delete selected orders
function deleteOrders() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Access-Control-Allow-Origin': '*',
            'Access-Control-Allow-Methods': 'GET,POST,PUT,PATCH,DELETE,OPTIONS',
            'Access-Control-Max-Age': '3600',
            'Access-Control-Allow-Headers': 'x-requested-with, content-type',
            'Accept': 'application/json',
        }
    });


    Swal.fire({
        title: 'Delete selected order(s)?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3C4B64',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!',
        toast: true,
        position: 'top-right',

    }).then((result) => {

        var allVals = [];
        $(".sub_chk:checked").each(function () {
            allVals.push($(this).attr('data-id'));
        });

        if (allVals.length <= 0) {
            Swal.fire({
                title: 'Please select order(s)!',
                icon: 'warning',
                toast: true,
                position: 'top-right',
            });
        } else {
            var join_selected_values = allVals.join(",");
            var url = $(".bulkDeleteOrdersBtn").data("url");

            if (result.isConfirmed) {
                $.ajax({
                    method: "POST",
                    url: url,
                    data: "ids=" + join_selected_values,
                    success: function (response) {
                        if (response.error) {
                            Swal.fire({
                                title: 'Error! Try again.',
                                // text: '',
                                icon: 'warning',
                                toast: true,
                                position: 'top-right',
                                showConfirmButton: false,
                                timer: 2500,
                            });
                        } else {
                            Swal.fire({
                                title: 'Order(s) deleted!',
                                // text: '',
                                icon: 'success',
                                toast: true,
                                position: 'top-right',
                                showConfirmButton: false,
                                timer: 2500,
                            });

                            $.each(allVals, function (index, value) {
                                console.log("Delete order(s): " + value);
                                $(".row-order[data-id=" + value + "]")
                                    .children('td, th')
                                    .animate({
                                        padding: 0
                                    })
                                    .wrapInner('<div />')
                                    .children()
                                    .slideUp(function () {
                                        $(this).closest('tr').remove();
                                    });

                            });
                        }
                    },
                    error: function (data) {
                        alert(data.responseText);
                    }
                });
            }
        }
    });
}

$('#billing_subtotal').mask("###0.00", {reverse: true});
$('#billing_total').mask("###0.00", {reverse: true});
$('#billing_discount').mask("###0.00", {reverse: true});
$('#billing_tax').mask("###0.00", {reverse: true});
$('#quantity').mask("#0", {reverse: true});
