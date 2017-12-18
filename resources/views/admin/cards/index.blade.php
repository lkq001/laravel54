@extends('admin.layouts.index')
@section('title', '宅配卡管理')
@section('style')
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">宅配卡列表</h3>
                </div>
                <div class="panel-body">
                    <button id="cards-add" class="btn btn-info m-b-5" style="float: right">添加</button>
                </div>
                <div class="panel-body">

                    <!-- 添加 -->
                    @include('admin.cards.add')
                    <!-- 修改 -->
                    @include('admin.cards.edit')
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <table id="datatable" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>宅配卡名称</th>
                                    <th>价格</th>
                                    <th>数量</th>
                                    <th>销售数量</th>
                                    <th>状态</th>
                                    <th>操作</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($cards as $card)
                                    <tr>
                                        <td>{{ $card->id }}</td>
                                        <td>{{ $card->name }}</td>
                                        <td>{{ $card->price }}</td>
                                        <td>{{ $card->number }}</td>
                                        <td>{{ $card->sale_number ? $card->sale_number : 0 }}</td>
                                        <td>

                                            @if( $card->status  == 1)
                                                已上架
                                            @else
                                                已下架
                                            @endif
                                        </td>
                                        <td>
                                            <button id="cards-edit" class="btn-xs btn-info btn-rounded m-b-5"
                                                    data-id="{{ $card->id }}"
                                                    data-url="{{ route('admin.cards.edit') }}">编辑
                                            </button>
                                            <button id="cards-destroy" class="btn-xs btn-danger btn-rounded m-b-5"
                                                    data-id="{{ $card->id }}"
                                                    data-url="{{ route('admin.cards.destroy') }}">删除
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
    <script src="{{ asset('admins') }}/js/cards.js"></script>
    <script id="ueditor"></script>
    <script>
        var ue = UE.getEditor("ueditor");
        ue.ready(function () {
            //因为Laravel有防csrf防伪造攻击的处理所以加上此行
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');
        });
    </script>

    <script id="editueditor"></script>
    <script>
        var ue = UE.getEditor("editueditor");
        ue.ready(function () {
            //因为Laravel有防csrf防伪造攻击的处理所以加上此行
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');
        });
    </script>
@endsection