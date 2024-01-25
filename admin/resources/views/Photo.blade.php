@extends('Layout.app')

@section('title', 'Photo')

@section('content')

    <div id="mainDivPhoto" class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <button data-toggle="modal" data-target="#photoModal" id="addNewPhotoBtnId" class="btn my-3 btn-sm btn-danger">Add New Photo</button>
            </div>
        </div>
        <div class="row photoRow">

        </div>
        <button class="btn my-3 btn-sm btn-danger" id="loadMoreBtn">Load More</button>
    </div>

    <!-- Add New Modal -->
    <div class="modal fade" id="photoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Photo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input class="form-control" id="imgInput" type="file">
                    <img class="imgPreview mt-3" id="imgPreview" src="{{asset('images/default-image.png')}}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
                    <button id="savePhoto" type="button" class="btn btn-sm btn-success">Upload</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

    <script type="text/javascript">

        $('#imgInput').change(function(){
            var reader = new FileReader();
            reader.readAsDataURL(this.files[0]);
            reader.onload=function(event){
                var imageSource = event.target.result;
                $('#imgPreview').attr('src', imageSource)
            }
        })

        $('#savePhoto').on('click', function(){
            $('#savePhoto').html("<div class='spinner-border spinner-border-sm' role='status'></div>");
            var photoFile = $('#imgInput').prop('files')[0];
            var formData = new FormData();
            formData.append('photo', photoFile);

            axios.post('/photoUpload', formData).then(function(response){
                if (response.status == 200 && response.data == 1) {
                    $('#photoModal').modal('hide');
                    $('#savePhoto').html('Upload');
                    toastr.success('Photo Upload Success');
                }
                else {
                    $('#PhotoModal').modal('hide');
                    toastr.error('Photo Upload Failed');
                }
            }).catch(function(error){
                $('#photoModal').modal('hide');
                toastr.error('Photo Upload Failed');
                $('#savePhoto').html('Upload');
            })
        })

        loadPhoto();
        function loadPhoto(){
            let URL = "/photoJSON"
            axios.get(URL).then(function(response){
                // console.log(response.data);
                $.each(response.data, function(i, item) {
                    $("<div class='col-md-3 p-1'>").html(
                        "<img data-id="+ item['id'] +" class='imgOnRow' src="+ item['location'] +">"+
                        "<button data-id="+ item['id'] +" data-photo="+ item['location'] +" class='btn btn-sm btn-danger btn-block deletePhoto'>Delete</button>"
                    ).appendTo('.photoRow');
                });

                $('.deletePhoto').on('click', function(event){
                    let id = $(this).data('id');
                    let photo = $(this).data('photo');
                    photoDelete(photo, id);
                    event.preventDefault();
                })

            }).catch(function(error){
                // console.log(error);
            })
        }

        var imgId = 0;
        function loadById(firstImgId, loadMoreBtn){
            // alert(FirstImgId);
            imgId = imgId+4;
            let photoId = imgId + firstImgId;
            let URL = "/photoJSONById/"+photoId;
            // alert(URL);
            loadMoreBtn.html("<div class='spinner-border spinner-border-sm' role='status'></div>");
            axios.get(URL).then(function(response){
                // console.log(response.data);
                loadMoreBtn.html("Load More");
                $.each(response.data, function(i, item) {
                    $("<div class='col-md-3 p-1'>").html(
                        "<img data-id="+ item['id'] +" class='imgOnRow' src="+ item['location'] +">"+
                        "<button data-id="+ item['id'] +" data-photo="+ item['location'] +" class='btn btn-sm btn-danger btn-block deletePhoto'>Delete</button>"
                    ).appendTo('.photoRow');
                })
            }).catch(function(error){
                // console.log(error);
            })
        }

        $('#loadMoreBtn').on('click', function(){
            let loadMoreBtn = $(this);
            let firstImgId = $(this).closest('div').find('img').data('id');
            // alert($firstImgId);
            loadById(firstImgId, loadMoreBtn);
        })

        function photoDelete(oldPhotoURL, id){
            let URL = '/photoDelete';
            let myFormData = new FormData();
            myFormData.append('oldPhotoURL', oldPhotoURL);
            myFormData.append('id', id);
            axios.post(URL, myFormData).then(function(response){
                if (response.status == 200 && response.data == 1){
                    toastr.success('Photo Delete Success');
                    window.location.href="/photo";
                }
                else {
                    toastr.error('Photo Delete Failed');
                }
            }).catch(function(){
                toastr.error('Photo Delete Failed');
            })
        }

    </script>

@endsection
