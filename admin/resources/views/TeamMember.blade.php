@extends('Layout.app')

@section('title', 'Team Member')

@section('content')

    <div id="mainDiv" class="container d-none">
        <div class="row">
            <div class="col-md-12 p-5">
                <button id="addNewBtnId" class="btn btn-sm my-3 btn-danger">Add New Member</button>
                <table id="teamDataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th class="th-sm">Team Member Image</th>
                        <th class="th-sm">Team Member Name</th>
                        <th class="th-sm">Team Member Description</th>
                        <th class="th-sm">Edit</th>
                        <th class="th-sm">Delete</th>
                    </tr>
                    </thead>
                    <tbody id="team_table">



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
                    <h6 id="teamDeleteId" class="mt-4 d-none"> </h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Close</button>
                    <button id="teamDeleteConfirmBtn" type="button" class="btn btn-sm btn-danger">Delete</button>
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
                    <h5 class="modal-title">Update Team</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="close">
                        <span aria-hidden="true">&times</span>
                    </button>
                </div>
                <div class="modal-body p-4 text-center">
                    <h6 id="teamEditId" class="mt-4 d-none"> </h6>
                    <div id="teamEditForm" class="w-100 d-none">
                        <input type="text" id="teamMemberNameId" class="form-control mb-4" placeholder="Team Name">
                        <input type="text" id="teamMemberDesId" class="form-control mb-4" placeholder="Team Description">
                        <input type="text" id="teamMemberImgId" class="form-control mb-4" placeholder="Team Image Link">
                    </div>
                    <img id="teamEditLoader" class="loading-icon m-5" src="{{ asset('images/loader.svg') }}" alt="">
                    <h5 id="teamEditWrong" class="d-none">Something Went Wrong !!!</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Close</button>
                    <button id="teamEditConfirmBtn" type="button" class="btn btn-sm btn-success">Update</button>
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
                    <div id="teamAddForm" class="w-100">
                        <h6 class="mb-3">Add New Member</h6>
                        <input type="text" id="teamNameAddId" class="form-control mb-4" placeholder="Team Name">
                        <input type="text" id="teamDesAddId" class="form-control mb-4" placeholder="Team Description">
                        <input type="text" id="teamImgAddId" class="form-control mb-4" placeholder="Team Image Link">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Close</button>
                    <button id="teamAddConfirmBtn" type="button" class="btn btn-sm btn-success">Save</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

    <script type="text/javascript">
        getTeamData();
        // For Team Table
        function getTeamData() {
            axios.get('/getTeamData')
                .then(function(response) {

                    if (response.status == 200) {

                        $('#mainDiv').removeClass('d-none');
                        $('#loaderDiv').addClass('d-none');

                        $('#team_table').empty();

                        var jsonData = response.data;
                        $.each(jsonData, function(i, item) {
                            $('<tr>').html(
                                "<td> <img class='table-img' src=" + jsonData[i].team_member_img + "> </td>" +
                                "<td> " + jsonData[i].team_member_name + " </td>" +
                                "<td> " + jsonData[i].team_member_des + " </td>" +
                                "<td> <a class='teamEditBtn' data-id=" + jsonData[i].id + " ><i class='fas fa-edit'></i></a> </td>>" +
                                "<td> <a class='teamDeleteBtn' data-id=" + jsonData[i].id + " ><i class='fas fa-trash-alt'></i></a> </td>>"
                            ).appendTo('#team_table')
                        });

                        // Team Table Delete Icon Click
                        $('.teamDeleteBtn').click(function() {
                            var id = $(this).data('id');
                            // alert(id);
                            $('#teamDeleteId').html(id);
                            $('#deleteModal').modal('show');
                        })

                        // Team Table Edit Icon Click
                        $('.teamEditBtn').click(function() {
                            var id = $(this).data('id');
                            // alert(id);
                            $('#teamEditId').html(id);
                            updateTeamDetails(id)
                            $('#editModal').modal('show');
                        })

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

        // Team Delete Modal Yes Button
        $('#teamDeleteConfirmBtn').click(function() {
            var id = $('#teamDeleteId').html();
            teamDelete(id);
        })

        // Team Delete
        function teamDelete(deleteId) {
            // Animation
            $('#teamDeleteConfirmBtn').html("<div class='spinner-border spinner-border-sm' role='status'></div>");
            axios.post('/teamDelete', {
                id: deleteId
            })
                .then(function(response) {
                    $('#teamDeleteConfirmBtn').html("Delete");
                    if (response.status == 200) {
                        if (response.data == 1) {
                            $('#deleteModal').modal('hide');
                            toastr.success('Delete Success.');
                            getTeamData();
                        } else {
                            $('#deleteModal').modal('hide');
                            toastr.error('Delete Failed.');
                            getTeamData();
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

        // Each Team Update Details
        function updateTeamDetails(detailsId) {
            axios.post('/updateTeamDetails', {
                id: detailsId
            })
                .then(function(response) {
                    if (response.status === 200) {
                        $('#teamEditForm').removeClass('d-none');
                        $('#teamEditLoader').addClass('d-none');
                        var jsonData = response.data;
                        $('#teamMemberNameId').val(jsonData[0].team_member_name);
                        $('#teamMemberDesId').val(jsonData[0].team_member_des);
                        $('#teamMemberImgId').val(jsonData[0].team_member_img);
                    } else {
                        $('#teamEditLoader').addClass('d-none');
                        $('#teamEditWrong').removeClass('d-none');
                    }
                })
                .catch(function(error) {
                    $('#teamEditLoader').addClass('d-none');
                    $('#teamEditWrong').removeClass('d-none');
                });
        }

        // Team Edit Modal Save Button
        $('#teamEditConfirmBtn').click(function() {
            var id = $('#teamEditId').html();
            var name = $('#teamMemberNameId').val();
            var des = $('#teamMemberDesId').val();
            var img = $('#teamMemberImgId').val();
            teamUpdate(id, name, des, img);
        })

        // Team Update
        function teamUpdate(teamMemberId, teamMemberName, teamMemberDes, teamMemberImg) {
            if (teamMemberName.length == 0) {
                toastr.error('Team Member Name is Required !');
            } else if (teamMemberDes.length == 0) {
                toastr.error('Team Member Description is Required !');
            } else if (teamMemberImg.length == 0) {
                toastr.error('Team Member Image is Required !');
            } else {
                // Animation
                $('#teamEditConfirmBtn').html("<div class='spinner-border spinner-border-sm' role='status'></div>");
                axios.post('/teamUpdate', {
                    id: teamMemberId,
                    team_member_name: teamMemberName,
                    team_member_des: teamMemberDes,
                    team_member_img: teamMemberImg,
                })
                    .then(function(response) {
                        $('#teamEditConfirmBtn').html("Update");
                        if (response.status == 200) {
                            if (response.data == 1) {
                                $('#editModal').modal('hide');
                                toastr.success('Update Success.');
                                getTeamData();
                            } else {
                                $('#editModal').modal('hide');
                                toastr.error('Update Failed.');
                                getTeamData();
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

        // Team Add New Button Click
        $('#addNewBtnId').click(function () {
            $('#addModal').modal('show');
        });

        // Team Add Modal Save Button
        $('#teamAddConfirmBtn').click(function() {
            var name = $('#teamNameAddId').val();
            var des = $('#teamDesAddId').val();
            var img = $('#teamImgAddId').val();
            teamAdd(name, des, img);
        })

        // Team Add Method
        function teamAdd(teamMemberName, teamMemberDes, teamMemberImg) {
            if (teamMemberName.length == 0) {
                toastr.error('Team Member Name is Required !');
            } else if (teamMemberDes.length == 0) {
                toastr.error('Team Member Description is Required !');
            } else if (teamMemberImg.length == 0) {
                toastr.error('Team Member Image is Required !');
            } else {
                // Animation
                $('#teamAddConfirmBtn').html("<div class='spinner-border spinner-border-sm' role='status'></div>");
                axios.post('/teamAdd', {
                    team_member_name: teamMemberName,
                    team_member_des: teamMemberDes,
                    team_member_img: teamMemberImg,
                })
                    .then(function(response) {
                        $('#teamAddConfirmBtn').html("Save");
                        if (response.status == 200) {
                            if (response.data == 1) {
                                $('#addModal').modal('hide');
                                toastr.success('Add Team Success.');
                                getTeamData();
                            } else {
                                $('#addModal').modal('hide');
                                toastr.error('Add Team Failed.');
                                getTeamData();
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
