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

    //? Adding new user
    $('#addUserForm').submit(function (e) {
        e.preventDefault();

        var formData = new FormData(this);
        var url = $(this).data('url');

        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            success: function () {
                $('#addModal').modal('hide');
                clearFields('#addModal');

                Swal.fire({
                    title: 'User added!',
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

//? Deleting user
function deleteUser(item) {

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
        title: 'Delete user?',
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
                url: "/admin/users/" + formData.id,
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
                            title: 'User has been deleted!',
                            // text: '',
                            icon: 'success',
                            toast: true,
                            position: 'top-right',
                            showConfirmButton: false,
                            timer: 2500,

                        })
                        console.log("Deleted User ID: " + formData.id);
                        $(".row-user[data-id=" + formData.id + "] .deleteBtn").text("Deleted").attr("disabled", "disabled");
                        $(".row-user[data-id=" + formData.id + "] .editUserBtn").fadeOut('slow');
                    }
                }
            })
        }
    });
}

//? Restore user
function restoreUser(item) {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    Swal.fire({
        title: 'Restore user?',
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
                url: "/admin/users/" + formData.id + "/restore",
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
                            title: 'User has been restored!',
                            // text: '',
                            icon: 'success',
                            toast: true,
                            position: 'top-right',
                            showConfirmButton: false,
                            timer: 2500,
                        })
                        console.log("Restored User ID: " + formData.id);
                        $(".row-user[data-id=" + formData.id + "] .restoreBtn").text("Restored").attr("disabled", "disabled");
                    }
                }
            })
        }
    });
}

//? Permanently delete user
function forceDeleteUser(item) {
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
        text: "You won't be able to restore user!",
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
                url: "/admin/users/" + formData.id + "/remove",
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
                            title: 'User permanently deleted!',
                            icon: 'success',
                            toast: true,
                            position: 'top-right',
                            showConfirmButton: false,
                            timer: 2500,

                        })
                        console.log("Permanently deleted User ID: " + formData.id);
                        $(".row-user[data-id=" + formData.id + "]")
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

//? Delete(soft delete) selected users
function deleteUsers() {
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
        title: 'Delete selected user(s)?',
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
                icon: 'warning',
                toast: true,
                position: 'top-right',
            });
        } else {
            var join_selected_values = allVals.join(",");
            var url = $(".bulkDeleteBtn").data('url');

            if (result.isConfirmed) {
                $.ajax({
                    method: "DELETE",
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
                                title: 'User deleted!',
                                // text: '',
                                icon: 'success',
                                toast: true,
                                position: 'top-right',
                                showConfirmButton: false,
                                timer: 2500,
                            });

                            $.each(allVals, function (index, value) {
                                console.log("Deleted user: " + value);
                                $(".row-user[data-id=" + value + "] .deleteBtn").text("Deleted").attr("disabled", "disabled");
                                $(".row-user[data-id=" + value + "] .editUserBtn").fadeOut('slow');
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
function removeUsers() {
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
        title: 'Remove selected user(s)?',
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
                title: 'Please select user!',
                text: "You won't be able to restore user!",
                icon: 'warning',
                toast: true,
                position: 'top-right',
            });
        } else {
            var join_selected_values = allVals.join(",");
            var url = $(".bulkRemoveBtn").data('url');

            if (result.isConfirmed) {
                $.ajax({
                    method: "DELETE",
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
                                title: 'User permanently deleted!',
                                // text: '',
                                icon: 'success',
                                toast: true,
                                position: 'top-right',
                                showConfirmButton: false,
                                timer: 2500,
                            });

                            $.each(allVals, function (index, value) {
                                console.log("Uklonjen korisnik: " + value);
                                $(".row-user[data-id=" + value + "]")
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
function restoreUsers() {
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
        title: 'Restore selected user(s)?',
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
                    method: "PUT",
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
                                title: 'User(s) restored!',
                                // text: '',
                                icon: 'success',
                                toast: true,
                                position: 'top-right',
                                showConfirmButton: false,
                                timer: 2500,
                            });

                            $.each(allVals, function (index, value) {
                                console.log("Restored user: " + value);
                                $(".row-user[data-id=" + value + "] .restoreBtn").text("Restored").attr("disabled", "disabled");
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
