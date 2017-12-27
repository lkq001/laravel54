@extends('admin.layouts.index')
@section('title', '城市管理')
@section('style')
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">地址列表</h3>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <form action="{{ route('admin.city.index') }}" method="get">
                            <div class="col-md-3 col-sm-3 col-xs-3">
                                <select class="form-control" name="id">
                                    @if(!empty($addressLists))
                                        @foreach($addressLists as $val)
                                            <option value="{{$val->id}}"
                                                    @if($val->id == $id) selected @endif >{{$val->name}}</option>
                                        @endforeach
                                    @else
                                        <option value="0">请去添加省份</option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-2">
                                @if(!empty($addressLists))

                                    <input type="submit" value="搜索" class="btn btn-info m-b-5"/>

                                @endif
                            </div>
                        </form>
                        <div class="col-md-7 col-sm-7 col-xs-7">
                            <button id="city-add" class="btn btn-info m-b-5" style="float: right">添加城市</button>
                        </div>
                    </div>
                </div>


                <div class="panel-body">

                    <!-- 添加 -->
                    @include('admin.city.add')
                    @include('admin.city.edit')
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <table id="datatable" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>城市</th>
                                    <th>状态</th>
                                    <th>操作</th>
                                </tr>
                                </thead>

                                <tbody>
                                @if(count($cityLists) > 0)
                                    @foreach($cityLists as $v)
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
                                                            data-id="{{$v->id}}" data-pid="{{$v->pid}}"
                                                            data-name="{{ $v->name }}">编辑
                                                    </button>
                                                    <button class="btn-sm btn-danger m-b-5 changeStatus"
                                                            data-id="{{$v->id}}"
                                                            data-url="{{ route('admin.city.status') }}"
                                                            data-status="{{$v->status}}">禁用
                                                    </button>
                                                @else
                                                    <button class="btn-sm btn-info m-b-5 changeStatus"
                                                            data-id="{{$v->id}}"
                                                            data-url="{{ route('admin.city.status') }}"
                                                            data-status="{{$v->status}}">启用
                                                    </button>
                                                @endif
                                                <button class="btn-sm btn-danger m-b-5 destroy"
                                                        data-url="{{ route('admin.city.destroy') }}"
                                                        data-id="{{$v->id}}">
                                                    删除
                                                </button>
                                                <a href="{{ route('admin.area.index', ['id'=> $v->id]) }}">
                                                    <button class="btn-sm btn-info m-b-5">查看区域</button>
                                                </a>

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
                            @if(count($cityLists) > 0)
                                {!! $cityLists->links() !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- End Row -->
@endsection
@section('script')
    <script src="{{ asset('admins') }}/js/city.js"></script>
@endsection