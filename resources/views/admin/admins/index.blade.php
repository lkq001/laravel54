@extends('admin.layouts.index')
@section('page-title', '管理员管理')
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
                    <button id="admins-add" class="btn btn-info m-b-5" style="float: right">添加管理员</button>
                </div>
                <div class="panel-body">

                    <!-- 添加 -->
                    @include('admin.admins.add')
                    <!-- 修改 -->
                    @include('admin.admins.edit')

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
                                @if(count($admins) > 0)

                                    @foreach($admins as $admin)
                                        <tr>
                                            <td>{{ $admin->id }}</td>
                                            <td>{{ $admin->username }}</td>
                                            <td>
                                                <button id="admins-edit" class="btn-xs btn-info btn-rounded m-b-5" data-id="{{ $admin->id }}" data-url="{{ route('admin.admins.edit') }}">编辑</button>
                                                <button id="admins-destroy" class="btn-xs btn-danger btn-rounded m-b-5" data-id="{{ $admin->id }}" data-url="{{ route('admin.admins.destroy') }}">删除</button>
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

                            {!! $admins->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End Row -->


@endsection

@section('script')
    <script src="{{ asset('admins') }}/js/admins.js"></script>
@endsection