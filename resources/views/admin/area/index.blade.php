@extends('admin.layouts.index')
@section('title', '区域管理')
@section('style')
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">区域列表</h3>
                </div>
                <div class="panel-body">
                    <button id="area-add" class="btn btn-info m-b-5" data-pid="{{$pids}}" style="float: right">添加区域
                    </button>
                </div>
                <div class="panel-body">

                    <!-- 添加 -->
                    @include('admin.area.add')
                    @include('admin.area.edit')
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <table id="datatable" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>区域</th>
                                    <th>状态</th>
                                    <th>操作</th>
                                </tr>
                                </thead>

                                <tbody>
                                @if(count($areaLists) > 0)
                                    @foreach($areaLists as $v)
                                        <tr>
                                            <td>{{ $v->id }}</td>
                                            <td>{{ $v->name }}</td>
                                            <td>
                                                @if($v->status == 1)
                                                    启用
                                                @else
                                                    禁用
                                                @endif
                                            </td>
                                            <td>

                                                @if($v->status == 1)
                                                    <button class="btn-sm btn-info m-b-5 changeEdit"
                                                            data-id="{{$v->id}}" data-name="{{ $v->name }}">编辑
                                                    </button>
                                                    <button class="btn-sm btn-danger m-b-5 changeStatus"
                                                            data-id="{{$v->id}}"
                                                            data-url="{{ route('admin.area.status') }}"
                                                            data-status="{{$v->status}}">禁用
                                                    </button>
                                                @else
                                                    <button class="btn-sm btn-info m-b-5 changeStatus"
                                                            data-id="{{$v->id}}"
                                                            data-url="{{ route('admin.area.status') }}"
                                                            data-status="{{$v->status}}">启用
                                                    </button>
                                                @endif
                                                <button class="btn-sm btn-danger m-b-5 destroy"
                                                        data-url="{{ route('admin.area.destroy') }}"
                                                        data-id="{{$v->id}}">
                                                    删除
                                                </button>


                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" style="text-align: center">暂无城市信息,请添加!</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                            @if(count($areaLists) > 0)
                                {!! $areaLists->links() !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- End Row -->
@endsection
@section('script')
    <script src="{{ asset('admins') }}/js/area.js"></script>
@endsection