@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.6.15/sweetalert2.css" integrity="sha512-JzSVRb7c802/njMbV97pjo1wuJAE/6v9CvthGTDxiaZij/TFpPQmQPTcdXyUVucsvLtJBT6YwRb5LhVxX3pQHQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <div class="container">
        <h1>
            Thêm Posts
        </h1>
        <form action="{{ route('blogs.store') }}" method="post" id='post-form'>
            @csrf
            <div class="mb-3">
                <label for="">Tên bài viết</label>
                <input type="text" class='form-control' name='title'>
                <span style='color:red' class="error title_error"></span>

            </div>
            <div class="mb-3">
                <label for="">Content</label>
                <input type="text" class='form-control' name='content'>
                <span style='color:red' class="error content_error"></span>
            </div>
            <button type="submit"
                        class='btn btn-danger'>Thêm</button>
            </form>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.js"
            integrity="sha512-CX7sDOp7UTAq+i1FYIlf9Uo27x4os+kGeoT7rgwvY+4dmjqV0IuE/Bl5hVsjnQPQiTOhAX1O2r2j5bjsFBvv/A=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.6.15/sweetalert2.min.js" integrity="sha512-Z4QYNSc2DFv8LrhMEyarEP3rBkODBZT90RwUC7dYQYF29V4dfkh+8oYZHt0R6T3/KNv32/u0W6icGWUUk9V0jA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>

            $(document).ready(function() {
                $('#post-form').on('submit', function(e) {
                    e.preventDefault();

                    let postName = $('input[name="title"]').val().trim();
                    let postContent = $('input[name="content"]').val().trim();
                    let actionUrl = $(this).attr('action');
                    let cscfToken = $(this).find('input[name="_token"]').val();
                    $('.error').text('');
                    // let cscfToken = '{{ csrf_token() }}';

                    // $.ajaxSetup({
                    //     headers: {
                    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    //     }
                    // });
                    $.ajax({
                        url: actionUrl,
                        type: 'POST',
                        dataType: "json",
                        // contentType: "application/json",
                        data: {
                            title: postName,
                            content: postContent,
                            _token: cscfToken
                        },
                        success: function(response) {
                            if(response.success == false){
                                for(let key in response.errors){
                                    $('.'+key+'_error').text(response.errors[key][0])
                                }
                            }else{
                                Swal.fire({
                                    title: 'Success',
                                    text: 'Add Record Success',
                                    icon: 'success',
                                    confirmBbuttonText: 'Cool'
                                })
                            }
                        }
                    })


                })
            })
        </script>
    @endsection
