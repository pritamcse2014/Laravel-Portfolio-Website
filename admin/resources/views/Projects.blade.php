@extends('Layout.app')

@section('title', 'Projects')

@section('content')

    <div id="mainDiv" class="container d-none">
        <div class="row">
            <div class="col-md-12 p-5">

                <button id="addNewBtnId" class="btn btn-md btn-danger my-3" type="button">Add New Project</button>

                <table id="projectDataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th class="th-sm">Project Image</th>
                        <th class="th-sm">Project Name</th>
                        <th class="th-sm">Project Description</th>
                        <th class="th-sm">Project Link</th>
                        <th class="th-sm">Edit</th>
                        <th class="th-sm">Delete</th>
                    </tr>
                    </thead>
                    <tbody id="project_table">

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
                    <h5 id="projectDeleteId" class="mt-4 d-none"> </h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Close</button>
                    <button id="projectDeleteConfirmBtn" type="button" class="btn btn-sm btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Project</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="close">
                        <span aria-hidden="true">&times</span>
                    </button>
                </div>
                <div class="modal-body p-4 text-center">
                    <h5 id="projectEditId" class="mt-4 d-none"> </h5>
                    <div id="projectEditForm" class="w-100 d-none">
                        <input id="projectImgUpdateId" type="text" class="form-control mb-4" placeholder="Project Image Link" />
                        <input id="projectNameUpdateId" type="text" class="form-control mb-4" placeholder="Project Name" />
                        <input id="projectDesUpdateId" type="text" class="form-control mb-4" placeholder="Project Description" />
                        <input id="projectLinkUpdateId" type="text" class="form-control mb-4" placeholder="Project Link" />
                    </div>

                    <img id="projectEditLoader" class="loading-icon m-5" src={{ asset('images/loader.svg') }} alt="">
                    <h5 id="projectEditWrong" class="d-none">Something Went Wrong !!!</h5>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Close</button>
                    <button id="projectUpdateConfirmBtn" type="button" class="btn btn-sm btn-danger">Update</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body p-5 text-center">
                    <div id="projectAddForm" class="w-100">
                        <h6 class="mb-4">Add New Project</h6>
                        <input type="text" id="projectImgAddId" class="form-control mb-4" placeholder="Project Image Link" />
                        <input type="text" id="projectNameAddId" class="form-control mb-4" placeholder="Project Name" />
                        <input type="text" id="projectDesAddId" class="form-control mb-4" placeholder="Project Description" />
                        <input type="text" id="projectLinkAddId" class="form-control mb-4" placeholder="Project Link" />
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Close</button>
                    <button id="projectAddConfirmBtn" type="button" class="btn btn-sm btn-danger">Save</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

    <script type="text/javascript">

        getProjectsData();

        // For Project Table
        function getProjectsData() {
            axios.get('/getProjectsData')
                .then(function(response) {
                    if (response.status == 200) {
                        $('#mainDiv').removeClass('d-none');
                        $('#loaderDiv').addClass('d-none');

                        $('#projectDataTable').DataTable().destroy();
                        $('#project_table').empty();

                        var jsonData = response.data;
                        $.each(jsonData, function(i, item) {
                            $('<tr>').html(
                                "<td><img class='table-img' src=" + jsonData[i].project_img + "></td>" +
                                "<td>" + jsonData[i].project_name + "</td>" +
                                "<td>" + jsonData[i].project_des + "</td>" +
                                "<td>" + jsonData[i].project_link + "</td>" +
                                "<td><a class='projectEditBtn' data-id=" + jsonData[i].id + " ><i class='fas fa-edit'></i></a></td>" +
                                "<td><a class='projectDeleteBtn' data-id=" + jsonData[i].id + " ><i class='fas fa-trash-alt'></i></a></td>"
                            ).appendTo('#project_table');
                        });

                        // Project Table Delete Icon Click
                        $('.projectDeleteBtn').click(function() {
                            var id = $(this).data('id');
                            $('#projectDeleteId').html(id);
                            $('#deleteModal').modal('show');
                        })

                        // Projects Table Edit Icon Click
                        $('.projectEditBtn').click(function() {
                            var id = $(this).data('id');
                            $('#projectEditId').html(id);
                            updateProjectDetails(id);
                            $('#editModal').modal('show');
                        })

                        // Data Table
                        $('#projectDataTable').DataTable({
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

        // Each Project Update Details
        function updateProjectDetails(detailsId) {
            axios.post('/updateProjectDetails', {
                id: detailsId
            })
                .then(function(response) {
                    if (response.status == 200) {
                        $('#projectEditForm').removeClass('d-none');
                        $('#projectEditLoader').addClass('d-none');

                        var jsonData = response.data;
                        $('#projectImgUpdateId').val(jsonData[0].project_img);
                        $('#projectNameUpdateId').val(jsonData[0].project_name);
                        $('#projectDesUpdateId').val(jsonData[0].project_des);
                        $('#projectLinkUpdateId').val(jsonData[0].project_link);
                    } else {
                        $('#projectEditLoader').addClass('d-none');
                        $('#projectEditWrong').removeClass('d-none');
                    }
                }).catch(function(error) {
                $('#projectEditLoader').addClass('d-none');
                $('#projectEditWrong').removeClass('d-none');
            });
        }

        // Project Edit Modal Save Button
        $('#projectUpdateConfirmBtn').click(function() {
            var projectId = $('#projectEditId').html();
            var projectImg = $('#projectImgUpdateId').val();
            var projectName = $('#projectNameUpdateId').val();
            var projectDes = $('#projectDesUpdateId').val();
            var projectLink = $('#projectLinkUpdateId').val();
            projectUpdate(projectId, projectImg, projectName, projectDes, projectLink);
        })

        // Each Project Update
        function projectUpdate(projectId, projectImg, projectName, projectDes, projectLink) {
            if (projectImg.length == 0) {
                toastr.error('Project Image is Empty!');
            } else if (projectName.length == 0) {
                toastr.error('Project Name is Empty!');
            } else if (projectDes.length == 0) {
                toastr.error('Project Description is Empty!');
            } else if (projectLink.length == 0) {
                toastr.error('Project Link is Empty!');
            } else {
                $('#projectUpdateConfirmBtn').html("<div class='spinner-border spinner-border-sm' role='status'></div>");
                axios.post('/projectUpdate', {
                    id: projectId,
                    project_img: projectImg,
                    project_name: projectName,
                    project_des: projectDes,
                    project_link: projectLink,
                })
                    .then(function(response) {
                        $('#projectUpdateConfirmBtn').html('Update');
                        if (response.status == 200) {
                            if (response.data == 1) {
                                $('#editModal').modal('hide');
                                toastr.success('Project Update Success');
                                getProjectsData();
                            } else {
                                $('#editModal').modal('hide');
                                toastr.error('Project Update Failed');
                                getProjectsData();
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

        // Project Add New Button Click
        $('#addNewBtnId').click(function() {
            $('#addModal').modal('show');
        });

        // Project Add Modal Save Button
        $('#projectAddConfirmBtn').click(function() {
            var projectImg = $('#projectImgAddId').val();
            var projectName = $('#projectNameAddId').val();
            var projectDes = $('#projectDesAddId').val();
            var projectLink = $('#projectLinkAddId').val();
            projectAdd(projectImg, projectName, projectDes, projectLink);
        });

        // Project Add Method
        function projectAdd(projectImg, projectName, projectDes, projectLink) {
            if (projectImg.length == 0) {
                toastr.error('Project Image is Empty!');
            } else if (projectName.length == 0) {
                toastr.error('Project Name is Empty!');
            } else if (projectDes.length == 0) {
                toastr.error('Project Description is Empty!');
            } else if (projectLink.length == 0) {
                toastr.error('Project Link is Empty!');
            } else {
                $('#projectAddConfirmBtn').html("<div class='spinner-border spinner-border-sm' role='status'></div>");
                axios.post('/projectAdd', {
                    project_img: projectImg,
                    project_name: projectName,
                    project_des: projectDes,
                    project_link: projectLink,
                })
                    .then(function(response) {
                        $('#projectAddConfirmBtn').html('Save');
                        if (response.status == 200) {
                            if (response.data == 1) {
                                $('#addModal').modal('hide');
                                toastr.success('Add Course Success');
                                getProjectsData();
                            } else {
                                $('#addModal').modal('hide');
                                toastr.error('Add Course Failed');
                                getProjectsData();
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

        // Project Delete Modal Yes Button
        $('#projectDeleteConfirmBtn').click(function() {
            var id = $('#projectDeleteId').html();
            projectDelete(id);
        })

        // Project Delete
        function projectDelete(deleteId) {
            $('#projectDeleteConfirmBtn').html("<div class='spinner-border spinner-border-sm' role='status'></div>");
            axios.post('/projectDelete', {
                id: deleteId
            })
                .then(function(response) {
                    $('#projectDeleteConfirmBtn').html('Yes');
                    if (response.status == 200) {
                        if (response.data == 1) {
                            $('#deleteModal').modal('hide');
                            toastr.success('Project Delete Success')
                            getProjectsData();
                        } else {
                            $('#deleteModal').modal('hide');
                            toastr.error('Project Delete Failed');
                            getProjectsData();
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
