@extends('admin.layouts.index')
@section('title', '幻灯片管理')
@section('style')
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">幻灯片列表</h3>
                </div>
                <div class="panel-body">
                    <button id="banners-add" class="btn btn-info m-b-5" style="float: right">添加</button>
                </div>
                <div class="panel-body">

                    <!-- 添加 -->
                    @include('admin.banners.add')
                    <!-- 修改 -->
                    @include('admin.banners.edit')
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <table id="datatable" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>名称</th>
                                    <th>幻灯片</th>
                                    <th>状态</th>
                                    <th>操作</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($banners as $banner)
                                    <tr>
                                        <td>{{ $banner->id }}</td>
                                        <td>{{ $banner->name }}</td>
                                        <td><img src="{{ 'http://p0ztvlsi6.bkt.clouddn.com/' . $banner->image }}" style="width: 100px" alt=""></td>
                                        <td>

                                            @if( $banner->status  == 1)
                                                展示
                                            @else
                                                隐藏
                                            @endif
                                        </td>
                                        <td>
                                            <button id="banners-edit" class="btn-xs btn-info btn-rounded m-b-5"
                                                    data-id="{{ $banner->id }}"
                                                    data-url="{{ route('admin.banners.edit') }}">编辑
                                            </button>
                                            <button id="banners-destroy" class="btn-xs btn-danger btn-rounded m-b-5"
                                                    data-id="{{ $banner->id }}"
                                                    data-url="{{ route('admin.banners.destroy') }}">删除
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- End Row -->
@endsection

@section('script')
    <script src="{{ asset('admins') }}/js/banners.js"></script>
@endsection