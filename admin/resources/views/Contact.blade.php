@extends('Layout.app')

@section('title', 'Contact')

@section('content')

    <div id="mainDiv" class="container d-none">
        <div class="row">
            <div class="col-md-12 p-5">
                <table id="contactDataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th class="th-sm">Contact Name</th>
                        <th class="th-sm">Contact Mobile</th>
                        <th class="th-sm">Contact Email</th>
                        <th class="th-sm">Contact Message</th>
                        <th class="th-sm">Delete</th>
                    </tr>
                    </thead>
                    <tbody id="contact_table">

                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <div id="loaderDiv" class="container">
        <div class="row">
            <div class="col-md-12 text-center p-5">
                <img class="loading-icon m-5" src={{ asset('images/loader.svg') }} alt="">
            </div>
        </div>
    </div>

    <div id="wrongDiv" class="container d-none">
        <div class="row">
            <div class="col-md-12 text-center p-5">
                <h3>Something Went Wrong !!!</h3>
            </div>
        </div>
    </div>

    <!-- Modal Delete -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body p-3 text-center">
                    <h5 class="mt-4">Do you want to Delete?</h5>
                    <h5 id="contactDeleteId" class="mt-4 d-none"> </h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">No</button>
                    <button id="contactDeleteConfirmBtn" type="button" class="btn btn-sm btn-danger">Yes</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

    <script type="text/javascript">

        getContactData();
        // For Contact Table
        function getContactData() {
            axios.get('/getContactData')
                .then(function(response) {

                    if (response.status == 200) {
                        $('#mainDiv').removeClass('d-none');
                        $('#loaderDiv').addClass('d-none');

                        $('#contactDataTable').DataTable().destroy();
                        $('#contact_table').empty();

                        var jsonData = response.data;
                        $.each(jsonData, function(i, item) {
                            $('<tr>').html(
                                "<td>" + jsonData[i].contact_name + "</td>" +
                                "<td>" + jsonData[i].contact_mobile + "</td>" +
                                "<td>" + jsonData[i].contact_email + "</td>" +
                                "<td>" + jsonData[i].contact_message + "</td>" +
                                "<td><a class='contactDeleteBtn' data-id=" + jsonData[i].id + " ><i class='fas fa-trash-alt'></i></a></td>"
                            ).appendTo('#contact_table');
                        });

                        // Contact Table Delete Icon Click
                        $('.contactDeleteBtn').click(function() {
                            var id = $(this).data('id');

                            $('#contactDeleteId').html(id);
                            $('#deleteModal').modal('show');
                        })

                        // Data Table
                        $('#contactDataTable').DataTable({
                            "order": false
                        });
                        $('.dataTables_length').addClass('bs-select');


                    } else {
                        $('#loaderDiv').addClass('d-none');
                        $('#wrongDiv').removeClass('d-none');
                    }

                }).catch(function(error) {
                $('#loaderDiv').addClass('d-none');
                $('#wrongDiv').removeClass('d-none');
            });
        }

        // Contact Delete Modal Yes Button
        $('#contactDeleteConfirmBtn').click(function() {
            var id = $('#contactDeleteId').html();
            contactDelete(id);
        })

        // Contact Delete
        function contactDelete(deleteId) {
            $('#contactDeleteConfirmBtn').html("<div class='spinner-border spinner-border-sm' role='status'></div>");
            axios.post('/contactDelete', {
                id: deleteId
            })
                .then(function(response) {
                    $('#contactDeleteConfirmBtn').html('Yes');
                    if (response.status == 200) {
                        if (response.data == 1) {
                            $('#deleteModal').modal('hide');
                            toastr.success('Delete Contact Success')
                            getContactData();
                        } else {
                            $('#deleteModal').modal('hide');
                            toastr.error('Delete Contact Failed');
                            getContactData();
                        }
                    } else {
                        $('#deleteModal').modal('hide');
                        toastr.error('Something Went Wrong!');
                    }
                }).catch(function(error) {
                $('#deleteModal').modal('hide');
                toastr.error('Something Went Wrong!');
            });
        }

    </script>

@endsection
