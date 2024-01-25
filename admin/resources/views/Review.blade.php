@extends('Layout.app')

@section('title', 'Review')

@section('content')

    <div id="mainDiv" class="container d-none">
        <div class="row">
            <div class="col-md-12 p-5">

                <button id="addNewBtnId" class="btn btn-md btn-danger my-3" type="button">Add New Review</button>

                <table id="reviewDataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th class="th-sm">Review Image</th>
                        <th class="th-sm">Review Name</th>
                        <th class="th-sm">Review Description</th>
                        <th class="th-sm">Edit</th>
                        <th class="th-sm">Delete</th>
                    </tr>
                    </thead>
                    <tbody id="review_table">

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
                    <h5 id="reviewDeleteId" class="mt-4 d-none"> </h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Close</button>
                    <button id="reviewDeleteConfirmBtn" type="button" class="btn btn-sm btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Review</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="close">
                        <span aria-hidden="true">&times</span>
                    </button>
                </div>
                <div class="modal-body p-4 text-center">
                    <h5 id="reviewEditId" class="mt-4 d-none"> </h5>
                    <div id="reviewEditForm" class="w-100 d-none">
                        <input id="reviewImgUpdateId" type="text" class="form-control mb-4" placeholder="Review Image Link" />
                        <input id="reviewNameUpdateId" type="text" class="form-control mb-4" placeholder="Review Name" />
                        <input id="reviewDesUpdateId" type="text" class="form-control mb-4" placeholder="Review Description" />
                    </div>

                    <img id="reviewEditLoader" class="loading-icon m-5" src={{ asset('images/loader.svg') }} alt="">

                    <h5 id="reviewEditWrong" class="d-none">Something Went Wrong !!!</h5>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Close</button>
                    <button id="reviewUpdateConfirmBtn" type="button" class="btn btn-sm btn-danger">Update</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body p-5 text-center">
                    <div id="reviewAddForm" class="w-100">
                        <h6 class="mb-4">Add New Review</h6>
                        <input id="reviewImgAddId" type="text" class="form-control mb-4" placeholder="Review Image Link" />
                        <input id="reviewNameAddId" type="text" class="form-control mb-4" placeholder="Review Name" />
                        <input id="reviewDesAddId" type="text" class="form-control mb-4" placeholder="Review Description" />
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Close</button>
                    <button id="reviewAddConfirmBtn" type="button" class="btn btn-sm btn-danger">Save</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

    <script type="text/javascript">

        getReviewData();

        // For Review Table
        function getReviewData() {
            axios.get('/getReviewData')
                .then(function(response) {
                    if (response.status == 200) {
                        $('#mainDiv').removeClass('d-none');
                        $('#loaderDiv').addClass('d-none');

                        $('#reviewDataTable').DataTable().destroy();
                        $('#review_table').empty();

                        var jsonData = response.data;
                        $.each(jsonData, function(i, item) {
                            $('<tr>').html(
                                "<td><img class='table-img' src=" + jsonData[i].review_img + "></td>" +
                                "<td>" + jsonData[i].review_name + "</td>" +
                                "<td>" + jsonData[i].review_des + "</td>" +
                                "<td><a class='reviewEditBtn' data-id=" + jsonData[i].id + " ><i class='fas fa-edit'></i></a></td>" +
                                "<td><a class='reviewDeleteBtn' data-id=" + jsonData[i].id + " ><i class='fas fa-trash-alt'></i></a></td>"
                            ).appendTo('#review_table');
                        });

                        // Review Table Delete Icon Click
                        $('.reviewDeleteBtn').click(function() {
                            var id = $(this).data('id');
                            $('#reviewDeleteId').html(id);
                            $('#deleteModal').modal('show');
                        })

                        // Review Table Edit Icon Click
                        $('.reviewEditBtn').click(function() {
                            var id = $(this).data('id');
                            $('#reviewEditId').html(id);
                            updateReviewDetails(id);
                            $('#editModal').modal('show');
                        })

                        // Data Table
                        $('#reviewDataTable').DataTable({
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

        // Each Review Update Details
        function updateReviewDetails(detailsId) {
            axios.post('/updateReviewDetails', {
                id: detailsId
            })
                .then(function(response) {
                    if (response.status == 200) {
                        $('#reviewEditForm').removeClass('d-none');
                        $('#reviewEditLoader').addClass('d-none');

                        var jsonData = response.data;
                        $('#reviewImgUpdateId').val(jsonData[0].review_img);
                        $('#reviewNameUpdateId').val(jsonData[0].review_name);
                        $('#reviewDesUpdateId').val(jsonData[0].review_des);
                    } else {
                        $('#reviewEditLoader').addClass('d-none');
                        $('#reviewEditWrong').removeClass('d-none');
                    }
                }).catch(function(error) {
                $('#reviewEditLoader').addClass('d-none');
                $('#reviewEditWrong').removeClass('d-none');
            });
        }

        // Review Edit Modal Save Button
        $('#reviewUpdateConfirmBtn').click(function() {
            var reviewId = $('#reviewEditId').html();
            var reviewImg = $('#reviewImgUpdateId').val();
            var reviewName = $('#reviewNameUpdateId').val();
            var reviewDes = $('#reviewDesUpdateId').val();
            reviewUpdate(reviewId, reviewImg, reviewName, reviewDes);
        })

        // Each Review Update
        function reviewUpdate(reviewId, reviewImg, reviewName, reviewDes) {
            if (reviewImg.length == 0) {
                toastr.error('Review Image is Empty!');
            } else if (reviewName.length == 0) {
                toastr.error('Review Name is Empty!');
            } else if (reviewDes.length == 0) {
                toastr.error('Review Description is Empty!');
            } else {
                $('#reviewUpdateConfirmBtn').html("<div class='spinner-border spinner-border-sm' role='status'></div>");
                axios.post('/reviewUpdate', {
                    id: reviewId,
                    review_img: reviewImg,
                    review_name: reviewName,
                    review_des: reviewDes,
                })
                    .then(function(response) {
                        $('#reviewUpdateConfirmBtn').html('Update');
                        if (response.status == 200) {
                            if (response.data == 1) {
                                $('#editModal').modal('hide');
                                toastr.success('Update Success');
                                getReviewData();
                            } else {
                                $('#editModal').modal('hide');
                                toastr.error('Update Failed');
                                getReviewData();
                            }
                        } else {
                            $('#editModal').modal('hide');
                            toastr.error('Something Went Wrong!');
                        }
                    }).catch(function(error) {
                    $('#editModal').modal('hide');
                    toastr.error('Something Went Wrong!');
                });
            }
        }

        // Review Add New Button Click
        $('#addNewBtnId').click(function() {
            $('#addModal').modal('show');
        });

        // Review Add Modal Save Button
        $('#reviewAddConfirmBtn').click(function() {
            var reviewImg = $('#reviewImgAddId').val();
            var reviewName = $('#reviewNameAddId').val();
            var reviewDes = $('#reviewDesAddId').val();
            reviewAdd(reviewImg, reviewName, reviewDes);
        });

        // Review Add Method
        function reviewAdd(reviewImg, reviewName, reviewDes) {
            if (reviewImg.length == 0) {
                toastr.error('Review Image is Empty!');
            } else if (reviewName.length == 0) {
                toastr.error('Review Name is Empty!');
            } else if (reviewDes.length == 0) {
                toastr.error('Review Description is Empty!');
            } else {
                $('#reviewAddConfirmBtn').html("<div class='spinner-border spinner-border-sm' role='status'></div>");
                axios.post('/reviewAdd', {
                    review_img: reviewImg,
                    review_name: reviewName,
                    review_des: reviewDes,
                })
                    .then(function(response) {
                        $('#reviewAddConfirmBtn').html('Save');
                        if (response.status == 200) {
                            if (response.data == 1) {
                                $('#addModal').modal('hide');
                                toastr.success('Add Review Success');
                                getReviewData();
                            } else {
                                $('#addModal').modal('hide');
                                toastr.error('Add Review Failed');
                                getReviewData();
                            }
                        } else {
                            $('#addModal').modal('hide');
                            toastr.error('Something Went Wrong!');
                        }
                    }).catch(function(error) {
                    $('#addModal').modal('hide');
                    toastr.error('Something Went Wrong!');
                });
            }
        }

        // Review Delete Modal Yes Button
        $('#reviewDeleteConfirmBtn').click(function() {
            var id = $('#reviewDeleteId').html();
            reviewDelete(id);
        })

        // Review Delete
        function reviewDelete(deleteId) {
            $('#reviewDeleteConfirmBtn').html("<div class='spinner-border spinner-border-sm' role='status'></div>");
            axios.post('/reviewDelete', {
                id: deleteId
            })
                .then(function(response) {
                    $('#reviewDeleteConfirmBtn').html('Yes');
                    if (response.status == 200) {
                        if (response.data == 1) {
                            $('#deleteModal').modal('hide');
                            toastr.success('Delete Success')
                            getReviewData();
                        } else {
                            $('#deleteModal').modal('hide');
                            toastr.error('Delete Failed');
                            getReviewData();
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
