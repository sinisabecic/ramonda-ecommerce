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

    //? Adding new category
    $('#addCategoryForm').submit(function (e) {
        e.preventDefault();

        var formData = new FormData(this);
        var url = $(this).data('url');

        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            success: function () {
                $('#addCategoryModal').modal('hide');
                clearFields('#addCategoryModal');

                Swal.fire({
                    title: 'Category added!',
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

    //? For editing category
    $('#editCategoryForm').submit(function (e) {
        e.preventDefault();

        var formData = new FormData(this);
        var url = $(this).data('url');

        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            success: function () {
                Swal.fire({
                    title: 'Category edited!',
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

//? Deleting category
function deleteCategory(item) {

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
        title: 'Delete category?',
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
                url: "/admin/products/categories/" + formData.id,
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
                            title: 'Category has been deleted!',
                            // text: '',
                            icon: 'success',
                            toast: true,
                            position: 'top-right',
                            showConfirmButton: false,
                            timer: 2500,

                        })
                        console.log("Deleted category ID: " + formData.id);
                        $(".row-category[data-id=" + formData.id + "] .deleteBtn").text("Deleted").attr("disabled", "disabled");
                        $(".row-category[data-id=" + formData.id + "] .editBtn").fadeOut('slow');
                    }
                }
            })
        }
    });
}

//? Restore category
function restoreCategory(item) {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    Swal.fire({
        title: 'Restore category?',
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
                url: "/admin/products/categories/" + formData.id + "/restore",
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
                            title: 'Category has been restored!',
                            // text: '',
                            icon: 'success',
                            toast: true,
                            position: 'top-right',
                            showConfirmButton: false,
                            timer: 2500,
                        })
                        console.log("Restored category ID: " + formData.id);
                        $(".row-category[data-id=" + formData.id + "] .restoreBtn").text("Restored").attr("disabled", "disabled");
                    }
                }
            })
        }
    });
}

//? Permanently delete user
function forceDeleteCategory(item) {
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
        text: "You won't be able to restore category!",
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
                url: "/admin/products/categories/" + formData.id + "/remove",
                data: formData,
                success: function (response) {
                    if (response.error) {
                        console.log(response.error);
                        Swal.fire({
                            title: 'Error! Try again.',
                            icon: 'warning',
                            toast: true,
                            position: 'top-right',
                            showConfirmButton: false,
                            timer: 2500,
                        })
                    } else {
                        Swal.fire({
                            title: 'Category permanently deleted!',
                            icon: 'success',
                            toast: true,
                            position: 'top-right',
                            showConfirmButton: false,
                            timer: 2500,

                        })
                        console.log("Permanently deleted category ID: " + formData.id);
                        $(".row-category[data-id=" + formData.id + "]")
                            .children('td, th')
                            .animate({
                                padding: 0
                            })
                            .wrapInner('<div />')
                            .children()
                            .slideUp(function () {
                                $(this).closest('tr').remove();
                            });
                    }
                }
            })
        }
    });
}

//? Select all click
$(document).ready(function () {
    //? Select all click
    $('#master').on('click', function () {
        if ($(this).is(':checked', true)) {
            $(".sub_chk").prop('checked', true);
        } else {
            $(".sub_chk").prop('checked', false);
        }
    });
});

//? Delete(soft delete) selected categories
function deleteCategories() {
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
                                $(".row-category[data-id=" + value + "] .deleteBtn").text("Deleted").attr("disabled", "disabled");
                                $(".row-category[data-id=" + value + "] .editBtn").fadeOut('slow');
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

//? Remove selected users
function removeCategories() {
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
        title: 'Remove selected item(s)?',
        // text: "You won't be able to restore user!",
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
                title: 'Please select item!',
                text: "You won't be able to restore this item(s)!",
                icon: 'warning',
                toast: true,
                position: 'top-right',
            });
        } else {
            var join_selected_values = allVals.join(",");
            var url = $(".bulkRemoveBtn").data('url');

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
                                title: 'Item permanently deleted!',
                                // text: '',
                                icon: 'success',
                                toast: true,
                                position: 'top-right',
                                showConfirmButton: false,
                                timer: 2500,
                            });

                            $.each(allVals, function (index, value) {
                                console.log("Removed category: " + value);
                                $(".row-category[data-id=" + value + "]")
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

//? Restore selected users
function restoreCategories() {
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
        title: 'Restore selected item(s)?',
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
                title: 'Please select user!',
                icon: 'warning',
                toast: true,
                position: 'top-right',
            });
        } else {
            var join_selected_values = allVals.join(",");
            var url = $(".bulkRestoreBtn").data('url');

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
                                title: 'Item(s) restored!',
                                // text: '',
                                icon: 'success',
                                toast: true,
                                position: 'top-right',
                                showConfirmButton: false,
                                timer: 2500,
                            });

                            $.each(allVals, function (index, value) {
                                console.log("Restored category: " + value);
                                $(".row-category[data-id=" + value + "] .restoreBtn").text("Restored").attr("disabled", "disabled");
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

//? Clear fields function
function clearFields(form) {
    $(':input', form)
        .not(':button, :submit, :reset, :hidden')
        .val('')
        .prop('checked', false)
        .prop('selected', false);
}

function generateSlug() {
    $('#name').on('keyup', function (e) {
        // e.preventDefault();
        var Text = $('#name').val();
        var slut = Text.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
        $("#slug").val(slut);

        // Async changing link in breadcrumb
        $("#breadcrumb-link").attr('href', $("#breadcrumb-link").data('app-url') + '/shop?category=' + slut);
        $("#breadcrumb-link").text(Text);
        $(".showCategoryBtn").attr('href', $("#breadcrumb-link").data('app-url') + '/shop?category=' + slut);
    });
}