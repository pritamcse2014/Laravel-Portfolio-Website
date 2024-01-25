@extends('Layout.app')

@section('title', 'Courses')

@section('content')

    <div id="mainDiv" class="container d-none">
        <div class="row">
            <div class="col-md-12 p-5">
                <button id="addNewBtnId" class="btn btn-sm my-3 btn-danger">Add New Course</button>
                <table id="courseDataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th class="th-sm">Course Image</th>
                        <th class="th-sm">Course Name</th>
                        <th class="th-sm">Course Description</th>
                        <th class="th-sm">Course Fee</th>
                        <th class="th-sm">Course Total Enroll</th>
                        <th class="th-sm">Course Total Class</th>
                        <th class="th-sm">Course Link</th>
                        <th class="th-sm">Edit</th>
                        <th class="th-sm">Delete</th>
                    </tr>
                    </thead>
                    <tbody id="course_table">



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
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body p-3 text-center">
                    <h5 class="mt-4">Do you want to Delete?</h5>
                    <h6 id="courseDeleteId" class="mt-4 d-none"></h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Close</button>
                    <button id="courseDeleteConfirmBtn" type="button" class="btn btn-sm btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Course</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="close">
                        <span aria-hidden="true">&times</span>
                    </button>
                </div>
                <div class="modal-body p-4 text-center">
                    <h6 id="courseEditId" class="mt-4 d-none"></h6>
                    <div id="courseEditForm" class="w-100 d-none">
                        <input type="text" id="courseImgUpdateId" class="form-control mb-4" placeholder="Course Image Link" />
                        <input type="text" id="courseNameUpdateId" class="form-control mb-4" placeholder="Course Name" />
                        <input type="text" id="courseDesUpdateId" class="form-control mb-4" placeholder="Course Description" />
                        <input type="text" id="courseFeeUpdateId" class="form-control mb-4" placeholder="Course Fee" />
                        <input type="text" id="courseEnrollUpdateId" class="form-control mb-4" placeholder="Course Total Enroll" />
                        <input type="text" id="courseClassUpdateId" class="form-control mb-4" placeholder="Course Total Class" />
                        <input type="text" id="courseLinkUpdateId" class="form-control mb-4" placeholder="Course Link" />
                    </div>

                    <img id="courseEditLoader" class="loading-icon m-5" src={{ asset('images/loader.svg') }} alt="">
                    <h5 id="courseEditWrong" class="d-none">Something Went Wrong !!!</h5>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Close</button>
                    <button id="courseUpdateConfirmBtn" type="button" class="btn btn-sm btn-danger">Update</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body p-5 text-center">
                    <div id="courseAddForm" class="w-100">
                        <h6 class="mb-4">Add New Course</h6>
                        <input type="text" id="courseImgAddId" class="form-control mb-4" placeholder="Course Image Link" />
                        <input type="text" id="courseNameAddId" class="form-control mb-4" placeholder="Course Name" />
                        <input type="text" id="courseDesAddId" class="form-control mb-4" placeholder="Course Description" />
                        <input type="text" id="courseFeeAddId" class="form-control mb-4" placeholder="Course Fee" />
                        <input type="text" id="courseEnrollAddId" class="form-control mb-4" placeholder="Course Total Enroll" />
                        <input type="text" id="courseClassAddId" class="form-control mb-4" placeholder="Course Total Class" />
                        <input id="courseLinkAddId" class="form-control mb-4" placeholder="Course Link" />
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Close</button>
                    <button id="courseAddConfirmBtn" type="button" class="btn btn-sm btn-danger">Save</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

<script type="text/javascript">

    getCoursesData();
    // For Courses Table
    function getCoursesData() {
        axios.get('/getCoursesData')
            .then(function(response) {

                if (response.status == 200) {

                    $('#mainDiv').removeClass('d-none');
                    $('#loaderDiv').addClass('d-none');

                    $('#courseDataTable').DataTable().destroy();
                    $('#course_table').empty();

                    var jsonData = response.data;
                    $.each(jsonData, function(i, item) {
                        $('<tr>').html(
                            "<td> <img class='table-img' src=" + jsonData[i].course_img + "> </td>" +
                            "<td> " + jsonData[i].course_name + " </td>" +
                            "<td> " + jsonData[i].course_des + " </td>" +
                            "<td> " + jsonData[i].course_fee + " </td>" +
                            "<td> " + jsonData[i].course_totalenroll + " </td>" +
                            "<td> " + jsonData[i].course_totalclass + " </td>" +
                            "<td> " + jsonData[i].course_link + " </td>" +
                            "<td> <a class='courseEditBtn' data-id=" + jsonData[i].id + " ><i class='fas fa-edit'></i></a> </td>>" +
                            "<td> <a class='courseDeleteBtn' data-id=" + jsonData[i].id + " ><i class='fas fa-trash-alt'></i></a> </td>>"
                        ).appendTo('#course_table')
                    });

                    // Courses Table Delete Icon Click
                    $('.courseDeleteBtn').click(function() {
                        var id = $(this).data('id');
                        $('#courseDeleteId').html(id);
                        $('#deleteModal').modal('show');
                    })

                    // Courses Table Edit Icon Click
                    $('.courseEditBtn').click(function() {
                        var id = $(this).data('id');
                        $('#courseEditId').html(id);
                        updateCourseDetails(id);
                        $('#editModal').modal('show');
                    })

                    // Data Table
                    $('#courseDataTable').dataTable({
                        "order": false
                    });
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

    // Each Course Update Details
    function updateCourseDetails(detailsId) {
        axios.post('/updateCourseDetails', {
            id: detailsId
        })
            .then(function(response) {
                if (response.status == 200) {
                    $('#courseEditForm').removeClass('d-none');
                    $('#courseEditLoader').addClass('d-none');

                    var jsonData = response.data;
                    $('#courseImgUpdateId').val(jsonData[0].course_img);
                    $('#courseNameUpdateId').val(jsonData[0].course_name);
                    $('#courseDesUpdateId').val(jsonData[0].course_des);
                    $('#courseFeeUpdateId').val(jsonData[0].course_fee);
                    $('#courseEnrollUpdateId').val(jsonData[0].course_totalenroll);
                    $('#courseClassUpdateId').val(jsonData[0].course_totalclass);
                    $('#courseLinkUpdateId').val(jsonData[0].course_link);
                } else {
                    $('#courseEditLoader').addClass('d-none');
                    $('#courseEditWrong').removeClass('d-none');
                }
            }).catch(function(error) {
            $('#courseEditLoader').addClass('d-none');
            $('#courseEditWrong').removeClass('d-none');
        });
    }

    // Course Edit Modal Save Button
    $('#courseUpdateConfirmBtn').click(function() {
        var courseId = $('#courseEditId').html();
        var courseImg = $('#courseImgUpdateId').val();
        var courseName = $('#courseNameUpdateId').val();
        var courseDes = $('#courseDesUpdateId').val();
        var courseFee = $('#courseFeeUpdateId').val();
        var courseEnroll = $('#courseEnrollUpdateId').val();
        var courseClass = $('#courseClassUpdateId').val();
        var courseLink = $('#courseLinkUpdateId').val();
        courseUpdate(courseId, courseImg, courseName, courseDes, courseFee, courseEnroll, courseClass, courseLink);
    })

    // Each Course Update
    function courseUpdate(courseId, courseImg, courseName, courseDes, courseFee, courseEnroll, courseClass, courseLink) {
        if (courseImg.length == 0) {
            toastr.error('Course Image is Empty!');
        } else if (courseName.length == 0) {
            toastr.error('Course Name is Empty!');
        } else if (courseDes.length == 0) {
            toastr.error('Course Description is Empty!');
        } else if (courseFee.length == 0) {
            toastr.error('Course Fee is Empty!');
        } else if (courseEnroll.length == 0) {
            toastr.error('Course Enroll is Empty!');
        } else if (courseClass.length == 0) {
            toastr.error('Course Class is Empty!');
        } else if (courseLink.length == 0) {
            toastr.error('Course Link is Empty!');
        } else {
            $('#courseUpdateConfirmBtn').html("<div class='spinner-border spinner-border-sm' role='status'></div>");
            axios.post('/courseUpdate', {
                id: courseId,
                course_img: courseImg,
                course_name: courseName,
                course_des: courseDes,
                course_fee: courseFee,
                course_totalenroll: courseEnroll,
                course_totalclass: courseClass,
                course_link: courseLink,
            })
                .then(function(response) {
                    $('#courseUpdateConfirmBtn').html('Update');
                    if (response.status == 200) {
                        if (response.data == 1) {
                            $('#editModal').modal('hide');
                            toastr.success('Update Success');
                            getCoursesData();
                        } else {
                            $('#editModal').modal('hide');
                            toastr.error('Update Failed');
                            getCoursesData();
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

    // Course Add New Button Click
    $('#addNewBtnId').click(function() {
        $('#addModal').modal('show');
    })

    // Course Add Modal Save Button
    $('#courseAddConfirmBtn').click(function() {
        var courseImg = $('#courseImgAddId').val();
        var courseName = $('#courseNameAddId').val();
        var courseDes = $('#courseDesAddId').val();
        var courseFee = $('#courseFeeAddId').val();
        var courseEnroll = $('#courseEnrollAddId').val();
        var courseClass = $('#courseClassAddId').val();
        var courseLink = $('#courseLinkAddId').val();
        courseAdd(courseImg, courseName, courseDes, courseFee, courseEnroll, courseClass, courseLink);
    });

    // Course Add Method
    function courseAdd(courseImg, courseName, courseDes, courseFee, courseEnroll, courseClass, courseLink) {
        if (courseImg.length == 0) {
            toastr.error('Course Image is Empty!');
        } else if (courseName.length == 0) {
            toastr.error('Course Name is Empty!');
        } else if (courseDes.length == 0) {
            toastr.error('Course Description is Empty!');
        } else if (courseFee.length == 0) {
            toastr.error('Course Fee is Empty!');
        } else if (courseEnroll.length == 0) {
            toastr.error('Course Enroll is Empty!');
        } else if (courseClass.length == 0) {
            toastr.error('Course Class is Empty!');
        } else if (courseLink.length == 0) {
            toastr.error('Course Link is Empty!');
        } else {
            // Animation
            $('#courseAddConfirmBtn').html("<div class='spinner-border spinner-border-sm' role='status'></div>");
            axios.post('/courseAdd', {
                course_img: courseImg,
                course_name: courseName,
                course_des: courseDes,
                course_fee: courseFee,
                course_totalenroll: courseEnroll,
                course_totalclass: courseClass,
                course_link: courseLink,
            })
                .then(function(response) {
                    $('#courseAddConfirmBtn').html("Save");
                    if (response.status == 200) {
                        if (response.data == 1) {
                            $('#addModal').modal('hide');
                            toastr.success('Add Course Success.');
                            getCoursesData();
                        } else {
                            $('#addModal').modal('hide');
                            toastr.error('Add Course Failed.');
                            getCoursesData();
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

    // Course Delete Modal Yes Button
    $('#courseDeleteConfirmBtn').click(function() {
        var id = $('#courseDeleteId').html();
        courseDelete(id);
    })

    // Course Delete
    function courseDelete(deleteId) {
        $('#courseDeleteConfirmBtn').html("<div class='spinner-border spinner-border-sm' role='status'></div>");
        axios.post('/courseDelete', {
            id: deleteId
        })
            .then(function(response) {
                $('#courseDeleteConfirmBtn').html('Yes');
                if (response.status == 200) {
                    if (response.data == 1) {
                        $('#deleteModal').modal('hide');
                        toastr.success('Course Delete Success')
                        getCoursesData();
                    } else {
                        $('#deleteModal').modal('hide');
                        toastr.error('Course Delete Failed');
                        getCoursesData();
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
