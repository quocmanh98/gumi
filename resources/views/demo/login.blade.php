@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.6.15/sweetalert2.css"
        integrity="sha512-JzSVRb7c802/njMbV97pjo1wuJAE/6v9CvthGTDxiaZij/TFpPQmQPTcdXyUVucsvLtJBT6YwRb5LhVxX3pQHQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <div class="container">
        <h1>
            Login
        </h1>
        <form action="{{ route('demo.login') }}" method="post" id='btn-login'>
            @csrf
            <div class="mb-3">
                <label for="">Email</label>
                <input type="email" class='form-control' name='email'>
                <span style='color:red' class="error email_error"></span>

            </div>
            <div class="mb-3">
                <label for="">Password</label>
                <input type="password" class='form-control' name='password'>
                <span style='color:red' class="error password_error"></span>
            </div>
            <button type="submit" class='btn btn-danger' >Login</button>
        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.js"
        integrity="sha512-CX7sDOp7UTAq+i1FYIlf9Uo27x4os+kGeoT7rgwvY+4dmjqV0IuE/Bl5hVsjnQPQiTOhAX1O2r2j5bjsFBvv/A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.6.15/sweetalert2.min.js"
        integrity="sha512-Z4QYNSc2DFv8LrhMEyarEP3rBkODBZT90RwUC7dYQYF29V4dfkh+8oYZHt0R6T3/KNv32/u0W6icGWUUk9V0jA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            $('#btn-login').on('submit', function(e) {
                e.preventDefault();

                let email = $('input[name="email"]').val().trim();
                let password = $('input[name="password"]').val().trim();
                let actionUrl = $(this).attr('action');
                let cscfToken = $(this).find('input[name="_token"]').val();
                $('.error').text('');

                $.ajax({
                    url: actionUrl,
                    type: 'POST',
                    dataType: "json",
                    data: {
                        email: email,
                        password: password,
                        _token: cscfToken
                    },
                    success: function(response) {
                        if (response.success == false) {
                            for (let key in response.error) {
                                $('.' + key + '_error').text(response.error[key][0])
                            }
                            Swal.fire({
                                title: 'Error',
                                text: response.error,
                                icon: 'Error',
                                confirmBbuttonText: 'Cool'
                            })
                        } else {

                            localStorage.setItem('token', response.token)
                            Swal.fire({
                                title: 'Success',
                                text: 'Login Success',
                                icon: 'Success',
                                confirmBbuttonText: 'Cool'
                            })

                        }
                    }
                })
            })
        })
    </script>
@endsection
