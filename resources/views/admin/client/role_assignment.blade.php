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
                    <h5 class="card-header">Cấp quyền user: {{ $user->name }}</h5>
                    <div class="card-body">
                        <form action="{{ route('client.insert_roles', $user->id) }}" method="post">
                            @csrf
                            @if (isset($all_column_roles))
                                @foreach ($role as $k => $v)
                                    <div class="form-check form-check-inline">
                                        <input id="{{ $v->id }}" class="form-check-input" type="radio"
                                            name="role" value="{{ $v->name }}"
                                            {{ $v->id == $all_column_roles->id ? 'checked' : '' }}>
                                        <label for="{{ $v->id }}"
                                            class="form-check-label">{{ $v->name }}</label>
                                    </div>
                                @endforeach
                            @else
                                @foreach ($role as $k => $v)
                                    <div class="form-check form-check-inline">
                                        <input id="{{ $v->id }}" class="form-check-input" type="radio"
                                            name="role" value="{{ $v->name }}">
                                        <label for="{{ $v->id }}"
                                            class="form-check-label">{{ $v->name }}</label>
                                    </div>
                                @endforeach
                            @endif
                            <br>
                    </div>
                    <input type="submit" name='inserroles' value="Cấp vai trò cho User" class="btn btn-success">
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
