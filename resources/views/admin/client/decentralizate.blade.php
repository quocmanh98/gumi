@extends('layouts.app')

@section('content')
    @can('edit articles')
        // check trong bảng role_has_permission
    @endcan
    {{-- @role('admin')
    I am a writer!
    // check trong bảng model has role
@else
    I am not a writer...
@endrole --}}
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    @if (session('status'))
                        <div class="alert alert-primary" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h5 class="card-header">Cấp quyền User: {{ $user->name }}</h5>
                    <div class="card-body">
                        <form action="{{ route('client.insert_permission', $user->id) }}" method="post">
                            @csrf
                            @if (isset($name_roles))
                                Vai trò hiện tại: {{ $name_roles }} <br>
                            @endif
                            <br>
                            <input type="checkbox" name="checkedAll" id="checkedAll" />
                            @foreach ($permission as $k => $v)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                        @foreach ($get_permission_via_role as $key => $value)
                                        @if ($value->id == $v->id)
                                        checked
                                        @endif @endforeach
                                        name='permission[]' value="{{ $v->name }}" id="{{ $v->id }}">
                                    <label class="form-check-label" for="{{ $v->id }}">
                                        {{ $v->name }}
                                    </label>
                                </div>
                            @endforeach
                            <input type="submit" name='insertRole' value="Cấp quyền cho User" class="btn btn-danger">
                    </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class='row'>
                        <div class='col-md-9 m-2'>
                            <form action="{{ route('client.insert_per_permission') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="">Tên quyền</label>
                                    <input type="text" value="{{ old('permission') }}" name='permission'
                                        class="form-control"> <br>
                                </div>
                                <input type="submit" name='insertpers' value="Thêm quyền" class="btn btn-danger">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.js"
    integrity="sha512-CX7sDOp7UTAq+i1FYIlf9Uo27x4os+kGeoT7rgwvY+4dmjqV0IuE/Bl5hVsjnQPQiTOhAX1O2r2j5bjsFBvv/A=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            $("#checkedAll").change(function() {
                if (this.checked) {
                    $(".form-check-input").each(function() {
                        this.checked = true;
                    });
                } else {
                    $(".form-check-input").each(function() {
                        this.checked = false;
                    });
                }
            });

            $(".form-check-input").click(function() {
                if ($(this).is(":checked")) {
                    let isAllChecked = 0;

                    $(".form-check-input").each(function() {
                        if (!this.checked)
                            isAllChecked = 1;
                    });

                    if (isAllChecked == 0) {
                        $("#checkedAll").prop("checked", true);
                    }
                } else {
                    $("#checkedAll").prop("checked", false);
                }
            });
        });
    </script>
@endsection
