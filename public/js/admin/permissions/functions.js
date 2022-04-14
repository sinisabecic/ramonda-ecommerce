$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#addPermissionForm').submit(function (e) {
        e.preventDefault();

        var formData = new FormData(this);
        var permissionId = $('#permissionId').text() + 1;
        var permissionName = $('#permission').val();
        var currentdate = new Date();
        var datetime = currentdate.getDate() + ""
            + (currentdate.getMonth() + 1) + ""
            + currentdate.getFullYear() + "_"
            + currentdate.getHours() + ""
            + currentdate.getMinutes() + ""
            + currentdate.getSeconds();

        $.ajax({
            method: 'POST',
            url: "/admin/permissions",
            data: formData,
            success: function () {
                $('#addPermissionModal').modal('hide');
                clearFields('#addPermissionModal');
                $('#dataTablePermissions > tbody').before('' +
                    '<tr class="row-permission">' +
                    '<td><ul class="list-group list-group-flush"><li class="list-group-item m-0 p-0 py-1 bg-transparent"><span class="badge badge-pill badge-primary rounded-0">' + permissionName + '</span></li></ul></td>' +
                    '<td><span class="badge badge-pill badge-secondary small">' + datetime + '</span></td>' +
                    '<td><span class="small">' + formData.id + '</span></td>' +
                    '</tr>');

                Swal.fire({
                    title: 'Permission added!',
                    // text: '',
                    icon: 'success',
                    toast: true,
                    position: 'top-right',
                    showConfirmButton: false,
                    timer: 2500,
                });
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
                })
            },
            contentType: false,
            processData: false,
        });
    });


    $('#editPermissionForm').submit(function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        const id = $('.row-permission').data('id');
        $.ajax({
            url: "/admin/permissions/" + id,
            method: 'POST',
            data: formData,
            success: function () {
                Swal.fire({
                    title: 'Permission edited!',
                    // text: '',
                    icon: 'success',
                    toast: true,
                    position: 'top-right',
                    showConfirmButton: false,
                    timer: 2500,
                });
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
                })
            },
            contentType: false,
            processData: false,
        })
        ;
    });

});


function deletePermission(item) {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    Swal.fire({
        title: 'Delete permission?',
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
                type: "DELETE",
                url: "/admin/permissions/" + formData.id,
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
                            title: 'Permission has been deleted!',
                            // text: '',
                            icon: 'success',
                            toast: true,
                            position: 'top-right',
                            showConfirmButton: false,
                            timer: 2500,

                        })
                        console.log("Izbrisana dozvola ID: " + formData.id);

                        // window.location.reload(true);
                        $(".row-permission[data-id=" + formData.id + "]")
                            .children('td, th')
                            .animate({
                                padding: 0
                            })
                            .wrapInner('<div />')
                            .children()
                            .slideUp(function () {
                                $(this).closest('tr').remove();
                            });

                        var currentdate = new Date();
                        var timestamp = currentdate.getDate() + "."
                            + (currentdate.getMonth() + 1) + "."
                            + currentdate.getFullYear() + ". "
                            + currentdate.getHours() + ":"
                            + currentdate.getMinutes() + ":"
                            + currentdate.getSeconds();

                        $(".row-permission[data-id=" + formData.id + "] .deletedAt").text(timestamp);


                    }
                }
            })
        }
    });
}


function restorePermission(item) {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    Swal.fire({
        title: 'Restore permission?',
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
                url: "/admin/permissions/" + formData.id + "/restore",
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
                            title: 'Permission has been restored!',
                            // text: '',
                            icon: 'success',
                            toast: true,
                            position: 'top-right',
                            showConfirmButton: false,
                            timer: 2500,
                        })
                        console.log("Ozivljena dozvola ID: " + formData.id);

                        $(".row-permission[data-id=" + formData.id + "] .restorePermissionBtn").text("Restored").attr("disabled", "disabled");
                        $(".row-permission[data-id=" + formData.id + "] .deletedAt").text("NULL");
                    }
                }
            })
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