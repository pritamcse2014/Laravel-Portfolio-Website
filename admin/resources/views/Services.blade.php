@extends('Layout.app')

@section('title', 'Services')

@section('content')

    <div id="mainDiv" class="container d-none">
        <div class="row">
            <div class="col-md-12 p-5">
                <button id="addNewBtnId" class="btn btn-sm my-3 btn-danger">Add New Service</button>
                <table id="serviceDataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th class="th-sm">Service Image</th>
                        <th class="th-sm">Service Name</th>
                        <th class="th-sm">Service Description</th>
                        <th class="th-sm">Edit</th>
                        <th class="th-sm">Delete</th>
                    </tr>
                    </thead>
                    <tbody id="service_table">



                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <div id="loaderDiv" class="container">
        <div class="row">
            <div class="col-md-12 text-center p-5">
                <img class="loading-icon m-5" src="{{ asset('images/loader.svg') }}" alt="">
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
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body p-3 text-center">
                    <h5 class="mt-4">Do You Want To Delete?</h5>
                    <h6 id="serviceDeleteId" class="mt-4 d-none"> </h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Close</button>
                    <button id="serviceDeleteConfirmBtn" type="button" class="btn btn-sm btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Service</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="close">
                        <span aria-hidden="true">&times</span>
                    </button>
                </div>
                <div class="modal-body p-4 text-center">
                    <h6 id="serviceEditId" class="mt-4 d-none"> </h6>
                    <div id="serviceEditForm" class="w-100 d-none">
                        <input type="text" id="serviceNameId" class="form-control mb-4" placeholder="Service Name">
                        <input type="text" id="serviceDesId" class="form-control mb-4" placeholder="Service Description">
                        <input type="text" id="serviceImgId" class="form-control mb-4" placeholder="Service Image Link">
                    </div>
                        <img id="serviceEditLoader" class="loading-icon m-5" src="{{ asset('images/loader.svg') }}" alt="">
                        <h5 id="serviceEditWrong" class="d-none">Something Went Wrong !!!</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Close</button>
                    <button id="serviceEditConfirmBtn" type="button" class="btn btn-sm btn-success">Update</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body p-5 text-center">
                    <div id="serviceAddForm" class="w-100">
                        <h6 class="mb-3">Add New Service</h6>
                        <input type="text" id="serviceNameAddId" class="form-control mb-4" placeholder="Service Name">
                        <input type="text" id="serviceDesAddId" class="form-control mb-4" placeholder="Service Description">
                        <input type="text" id="serviceImgAddId" class="form-control mb-4" placeholder="Service Image Link">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Close</button>
                    <button id="serviceAddConfirmBtn" type="button" class="btn btn-sm btn-success">Save</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

<script type="text/javascript">
    getServicesData();
    // For Services Table
    function getServicesData() {
        axios.get('/getServicesData')
            .then(function(response) {

                if (response.status == 200) {

                    $('#mainDiv').removeClass('d-none');
                    $('#loaderDiv').addClass('d-none');

                    $('#serviceDataTable').DataTable().destroy();
                    $('#service_table').empty();

                    var jsonData = response.data;
                    $.each(jsonData, function(i, item) {
                        $('<tr>').html(
                            "<td> <img class='table-img' src=" + jsonData[i].service_img + "> </td>" +
                            "<td> " + jsonData[i].service_name + " </td>" +
                            "<td> " + jsonData[i].service_des + " </td>" +
                            "<td> <a class='serviceEditBtn' data-id=" + jsonData[i].id + " ><i class='fas fa-edit'></i></a> </td>>" +
                            "<td> <a class='serviceDeleteBtn' data-id=" + jsonData[i].id + " ><i class='fas fa-trash-alt'></i></a> </td>>"
                        ).appendTo('#service_table')
                    });

                    // Service Table Delete Icon Click
                    $('.serviceDeleteBtn').click(function() {
                        var id = $(this).data('id');
                        // alert(id);
                        $('#serviceDeleteId').html(id);
                        $('#deleteModal').modal('show');
                    })

                    // Service Table Edit Icon Click
                    $('.serviceEditBtn').click(function() {
                        var id = $(this).data('id');
                        // alert(id);
                        $('#serviceEditId').html(id);
                        updateServiceDetails(id)
                        $('#editModal').modal('show');
                    })

                    // Data Table
                    $('#serviceDataTable').dataTable({"order": false});
                    $('.dataTables_length').addClass('bs-select');

                } else {
                    $('#loaderDiv').addClass('d-none');
                    $('#wrongDiv').removeClass('d-none');
                }
            })
            .catch(function(error) {
                $('#loaderDiv').addClass('d-none');
                $('#wrongDiv').removeClass('d-none');
            });
    }

    // Service Delete Modal Yes Button
    $('#serviceDeleteConfirmBtn').click(function() {
        var id = $('#serviceDeleteId').html();
        serviceDelete(id);
    })

    // Service Delete
    function serviceDelete(deleteId) {
        // Animation
        $('#serviceDeleteConfirmBtn').html("<div class='spinner-border spinner-border-sm' role='status'></div>");
        axios.post('/serviceDelete', {
            id: deleteId
        })
            .then(function(response) {
                $('#serviceDeleteConfirmBtn').html("Delete");
                if (response.status == 200) {
                    if (response.data == 1) {
                        $('#deleteModal').modal('hide');
                        toastr.success('Delete Success.');
                        getServicesData();
                    } else {
                        $('#deleteModal').modal('hide');
                        toastr.error('Delete Failed.');
                        getServicesData();
                    }
                } else {
                    $('#deleteModal').modal('hide');
                    toastr.error('Something Went Wrong !');
                }
            })
            .catch(function(error) {
                $('#deleteModal').modal('hide');
                toastr.error('Something Went Wrong !');
            });
    }

    // Each Service Update Details
    function updateServiceDetails(detailsId) {
        axios.post('/updateServiceDetails', {
            id: detailsId
        })
            .then(function(response) {
                if (response.status === 200) {
                    $('#serviceEditForm').removeClass('d-none');
                    $('#serviceEditLoader').addClass('d-none');
                    var jsonData = response.data;
                    $('#serviceNameId').val(jsonData[0].service_name);
                    $('#serviceDesId').val(jsonData[0].service_des);
                    $('#serviceImgId').val(jsonData[0].service_img);
                } else {
                    $('#serviceEditLoader').addClass('d-none');
                    $('#serviceEditWrong').removeClass('d-none');
                }
            })
            .catch(function(error) {
                $('#serviceEditLoader').addClass('d-none');
                $('#serviceEditWrong').removeClass('d-none');
            });
    }

    // Service Edit Modal Save Button
    $('#serviceEditConfirmBtn').click(function() {
        var id = $('#serviceEditId').html();
        var name = $('#serviceNameId').val();
        var des = $('#serviceDesId').val();
        var img = $('#serviceImgId').val();
        serviceUpdate(id, name, des, img);
    })

    // Service Update
    function serviceUpdate(serviceId, serviceName, serviceDes, serviceImg) {
        if (serviceName.length == 0) {
            toastr.error('Service Name is Required !');
        } else if (serviceDes.length == 0) {
            toastr.error('Service Description is Required !');
        } else if (serviceImg.length == 0) {
            toastr.error('Service Image is Required !');
        } else {
            // Animation
            $('#serviceEditConfirmBtn').html("<div class='spinner-border spinner-border-sm' role='status'></div>");
            axios.post('/serviceUpdate', {
                id: serviceId,
                service_name: serviceName,
                service_des: serviceDes,
                service_img: serviceImg,
            })
                .then(function(response) {
                    $('#serviceEditConfirmBtn').html("Update");
                    if (response.status == 200) {
                        if (response.data == 1) {
                            $('#editModal').modal('hide');
                            toastr.success('Update Success.');
                            getServicesData();
                        } else {
                            $('#editModal').modal('hide');
                            toastr.error('Update Failed.');
                            getServicesData();
                        }
                    } else {
                        $('#editModal').modal('hide');
                        toastr.error('Something Went Wrong !');
                    }
                })
                .catch(function(error) {
                    $('#editModal').modal('hide');
                    toastr.error('Something Went Wrong !');
                });
        }
    }

    // Service Add New Button Click
    $('#addNewBtnId').click(function () {
        $('#addModal').modal('show');
    });

    // Service Add Modal Save Button
    $('#serviceAddConfirmBtn').click(function() {
        var name = $('#serviceNameAddId').val();
        var des = $('#serviceDesAddId').val();
        var img = $('#serviceImgAddId').val();
        serviceAdd(name, des, img);
    })

    // Service Add Method
    function serviceAdd(serviceName, serviceDes, serviceImg) {
        if (serviceName.length == 0) {
            toastr.error('Service Name is Required !');
        } else if (serviceDes.length == 0) {
            toastr.error('Service Description is Required !');
        } else if (serviceImg.length == 0) {
            toastr.error('Service Image is Required !');
        } else {
            // Animation
            $('#serviceAddConfirmBtn').html("<div class='spinner-border spinner-border-sm' role='status'></div>");
            axios.post('/serviceAdd', {
                service_name: serviceName,
                service_des: serviceDes,
                service_img: serviceImg,
            })
                .then(function(response) {
                    $('#serviceAddConfirmBtn').html("Save");
                    if (response.status == 200) {
                        if (response.data == 1) {
                            $('#addModal').modal('hide');
                            toastr.success('Add Service Success.');
                            getServicesData();
                        } else {
                            $('#addModal').modal('hide');
                            toastr.error('Add Service Failed.');
                            getServicesData();
                        }
                    } else {
                        $('#addModal').modal('hide');
                        toastr.error('Something Went Wrong !');
                    }
                })
                .catch(function(error) {
                    $('#addModal').modal('hide');
                    toastr.error('Something Went Wrong !');
                });
        }
    }
</script>

@endsection
