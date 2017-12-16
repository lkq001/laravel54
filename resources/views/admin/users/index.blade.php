@extends('admin.layouts.index')
@section('page-title', '用户管理')
@section('style')
    <link href="{{ asset('style/admin') }}/css/sweet-alert.min.css" rel="stylesheet"/>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"></h3>
                </div>
                <div class="panel-body">
                    <button id="users-add" class="btn btn-info m-b-5" style="float: right">添加用户</button>
                </div>
                <div class="panel-body">

                    <!-- 添加 -->
                    @include('admin.users.add')
                    <!-- 修改 -->
                    @include('admin.users.edit')

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <table id="datatable" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>用户名</th>
                                    <th>操作</th>
                                </tr>
                                </thead>

                                <tbody>
                                @if(count($users) > 0)

                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>
                                                <button id="users-edit" class="btn-xs btn-info btn-rounded m-b-5" data-id="{{ $user->id }}" data-url="{{ route('admin.users.edit') }}">编辑</button>
                                                <button id="users-destroy" class="btn-xs btn-danger btn-rounded m-b-5" data-id="{{ $user->id }}" data-url="{{ route('admin.users.destroy') }}">删除</button>
                                            </td>
                                        </tr>
                                    @endforeach

                                @else

                                    <tr>
                                        <td colspan="3">暂无用户信息</td>
                                    </tr>

                                @endif
                                </tbody>
                            </table>

                            {!! $users->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End Row -->


@endsection

@section('script')
    <script src="{{ asset('admins') }}/js/users.js"></script>
@endsection