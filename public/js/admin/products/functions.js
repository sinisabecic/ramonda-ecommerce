//? Deleting product
function deleteProduct(item) {

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
        title: 'Delete product?',
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
                type: "DELETE",
                url: "/admin/products/" + formData.id,
                data: formData,
                success: function (response) {
                    if (response.error) {
                        console.log(response.error);
                        Swal.fire({
                            title: 'Error! Try again.',
                            // text: '',
                            icon: 'warning',
                            toast: true,
                            position: 'top-right',
                            showConfirmButton: false,
                            timer: 2500,
                        })
                    } else {
                        Swal.fire({
                            title: 'Product has been deleted!',
                            // text: '',
                            icon: 'success',
                            toast: true,
                            position: 'top-right',
                            showConfirmButton: false,
                            timer: 2500,

                        })
                        console.log("Deleted product ID: " + formData.id);
                        $(".row-product[data-id=" + formData.id + "] .deleteProductBtn").text("Deleted").attr("disabled", "disabled");
                        $(".row-product[data-id=" + formData.id + "] .editProductBtn").fadeOut('slow');
                    }
                }
            })
        }
    });
}

//? Restore product
function restoreProduct(item) {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    Swal.fire({
        title: 'Restore product?',
        // text: "You won't be able to revert this!",
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
                url: "/admin/products/" + formData.id + "/restore",
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
                            title: 'Product has been restored!',
                            // text: '',
                            icon: 'success',
                            toast: true,
                            position: 'top-right',
                            showConfirmButton: false,
                            timer: 2500,
                        })
                        console.log("Restored Product ID: " + formData.id);

                        $(".row-product[data-id=" + formData.id + "] .restoreBtn").text("Restored").attr("disabled", "disabled");
                    }
                }
            })
        }
    });
}

//? Permanently delete product
function forceDeleteProduct(item) {

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
        title: 'Delete permanently?',
        text: "You won't be able to restore product!",
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
                method: "DELETE",
                url: "/admin/products/" + formData.id + "/remove",
                data: formData,
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
                        })
                    } else {
                        Swal.fire({
                            title: 'Product permanently deleted!',
                            // text: '',
                            icon: 'success',
                            toast: true,
                            position: 'top-right',
                            showConfirmButton: false,
                            timer: 2500,

                        })
                        console.log("Permanently deleted Product ID: " + formData.id);

                        // window.location.reload(true);
                        $(".row-product[data-id=" + formData.id + "]")
                            .children('td, th')
                            .animate({
                                padding: 0
                            })
                            .wrapInner('<div />')
                            .children()
                            .slideUp(function () {
                                $(this).closest('tr').remove();
                            });
                        // .toggleClass("btn-danger")
                        // .toggleClass("btn-dark")
                    }
                }
            })
        }
    });
}

$(document).ready(function () {
    //? select all on click
    $('#master').on('click', function (e) {
        if ($(this).is(':checked', true)) {
            $(".sub_chk").prop('checked', true);
        } else {
            $(".sub_chk").prop('checked', false);
        }
    });
});

function deleteProducts() {
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
        title: 'Delete selected product(s)?',
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
                title: 'Please select product!',
                icon: 'warning',
                toast: true,
                position: 'top-right',
            });
        } else {
            var join_selected_values = allVals.join(",");
            var url = $(".bulkDeleteBtn").data("url");

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
                                title: 'Product(s) deleted!',
                                // text: '',
                                icon: 'success',
                                toast: true,
                                position: 'top-right',
                                showConfirmButton: false,
                                timer: 2500,
                            });

                            $.each(allVals, function (index, value) {
                                console.log("Deleted user: " + value);
                                $(".row-product[data-id=" + value + "] .deleteProductBtn").text("Deleted").attr("disabled", "disabled");
                                $(".row-product[data-id=" + value + "] .editProductBtn").fadeOut('slow');
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

function removeProducts() {
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
        title: 'Remove selected post(s)?',
        // text: "You won't be able to restore post!",
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
                title: 'Please select product!',
                text: "You won't be able to restore product!",
                icon: 'warning',
                toast: true,
                position: 'top-right',
            });
        } else {
            var join_selected_values = allVals.join(",");
            var url = $(".bulkRemoveBtn").data('url');

            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: url,
                    data: 'ids=' + join_selected_values,
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
                                title: 'Product permanently deleted!',
                                // text: '',
                                icon: 'success',
                                toast: true,
                                position: 'top-right',
                                showConfirmButton: false,
                                timer: 2500,
                            });

                            $.each(allVals, function (index, value) {
                                console.log("removed product: " + value);
                                $(".row-product[data-id=" + value + "]")
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

function restoreProducts() {
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
        title: 'Restore selected product(s)?',
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
                title: 'Please select post!',
                // text: "You won't be able to restore post!",
                icon: 'warning',
                toast: true,
                position: 'top-right',
            });
        } else {
            var join_selected_values = allVals.join(",");
            var url = $(".bulkRestoreBtn").data('url');

            if (result.isConfirmed) {
                $.ajax({
                    method: "POST",
                    url: url,
                    data: 'ids=' + join_selected_values,
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
                                title: 'Product(s) restored!',
                                // text: '',
                                icon: 'success',
                                toast: true,
                                position: 'top-right',
                                showConfirmButton: false,
                                timer: 2500,
                            });

                            $.each(allVals, function (index, value) {
                                console.log("Restored product: " + value);
                                $(".row-product[data-id=" + value + "] .restoreProductBtn").text("Restored").attr("disabled", "disabled");
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

function clearFields(form) {
    $(':input', form)
        .not(':button, :submit, :reset, :hidden')
        .val('')
        .prop('checked', false)
        .prop('selected', false);
}


//? New product function
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

    //? For adding product
    $('#addProductForm').submit(function (e) {
        e.preventDefault();

        var formData = new FormData(this);
        var url = $(this).data('url');

        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            success: function () {
                clearFields('#addProductForm');

                Swal.fire({
                    title: 'Product created!',
                    // text: '',
                    icon: 'success',
                    toast: true,
                    position: 'top-right',
                    showConfirmButton: false,
                    timer: 2500,
                });
            },
            error: function () {
                Swal.fire({
                    title: 'Error! Something went wrong',
                    // text: '',
                    icon: 'error',
                    toast: true,
                    position: 'top-right',
                    showConfirmButton: false,
                    timer: 2500,
                })
            },
            contentType: false,
            processData: false,
        });
    });

    //? For editing product
    $('#editProductForm').submit(function (e) {
        e.preventDefault();

        var formData = new FormData(this);
        var url = $(this).data('url');

        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            success: function () {
                Swal.fire({
                    title: 'Product edited!',
                    // text: '',
                    icon: 'success',
                    toast: true,
                    position: 'top-right',
                    showConfirmButton: false,
                    timer: 2500,
                });
            },
            error: function () {
                Swal.fire({
                    title: 'Error! Something went wrong',
                    // text: '',
                    icon: 'error',
                    toast: true,
                    position: 'top-right',
                    showConfirmButton: false,
                    timer: 2500,
                })
            },
            contentType: false,
            processData: false,
        });
    });
});

function generateSlug() {
    $('#name').on('keyup', function (e) {
        // e.preventDefault();
        var Text = $('#name').val();
        var slut = Text.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
        $("#slug").val(slut);

        // Async changing link in breadcrumb
        $("#breadcrumb-link").attr('href', $("#breadcrumb-link").data('app-url') + '/shop/' + slut);
        $("#breadcrumb-link").text(Text);
        $(".showProductBtn").attr('href', $("#breadcrumb-link").data('app-url') + '/shop/' + slut);
    });
}

$('#price').mask("###0.00", {reverse: true});
$('#quantity').mask("#0", {reverse: true});
