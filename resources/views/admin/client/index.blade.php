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
                    <h5 class="card-header">Liệt kê User</h5>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Vai trò (Role)</th>
                                    <th scope="col">Phân quyền (Permission)</th>
                                    <th scope="col">Quản lý</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $t = 1;
                                @endphp
                                @foreach ($users as $key => $user)
                                    <tr>
                                        <th scope="row">{{ $t++ }}</th>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @foreach ($user->roles as $k => $role)
                                                {{ $role->name }}
                                            @endforeach
                                        </td>
                                        <th scope="row">
                                            @foreach ($role->permissions as $k => $v)
                                                <span class="badge bg-secondary"> {{ $v->name }}</span> <br>
                                            @endforeach
                                        </th>
                                        <th>
                                            <a href="{{ route('client.role_assignment', $user->id) }}"
                                                class="btn btn-success">Phân vai trò</a> <br> <br>
                                            <a href="{{ route('client.decentralizate', $user->id) }}"
                                                class="btn btn-success">Phân quyền</a> <br> <br>
                                            <a href="{{ route('client.impersonate', $user->id) }}"
                                                class="btn btn-primary">Chuyển quyền nhanh</a>
                                        </th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
