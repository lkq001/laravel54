@extends('admin.layouts.index')
@section('title', '宅配卡管理')
@section('style')
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">宅配计划列表</h3>
                </div>
                {{--<div class="panel-body">--}}
                    {{--<button id="cards-add" class="btn btn-info m-b-5" style="float: right">添加</button>--}}
                {{--</div>--}}
                <div class="panel-body">

                    <!-- 添加 -->
                    {{--@include('admin.cards.add')--}}
                    {{--<!-- 修改 -->--}}
                    {{--@include('admin.cards.edit')--}}
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <table id="datatable" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>宅配卡编号</th>
                                    <th>次数</th>
                                    <th>宅配时间</th>
                                    <th>使用人</th>
                                    <th>电话</th>
                                    <th>使用地址</th>
                                    <th>状态</th>
                                    {{--<th>操作</th>--}}
                                </tr>
                                </thead>

                                <tbody>
                                @if($useCards)
                                    @foreach($useCards as $card)
                                        <tr>
                                            <td>{{ $card->id }}</td>
                                            <td>{{ $card->card_id }}</td>
                                            <td>{{ $card->card_use }}</td>
                                            <td>{{ $card->use_time }}</td>
                                            <td>{{ $card->user_name }}</td>
                                            <td>{{ $card->tel }}</td>
                                            <td>{{ $card->address }}</td>
                                            <td>

                                                @if( $card->status  == 1)
                                                    未配送
                                                @elseif ( $card->status  == 2)
                                                    已配送
                                                @else
                                                    其他
                                                @endif
                                            </td>
                                            {{--<td>--}}
                                            {{--<button id="cards-edit" class="btn-xs btn-info btn-rounded m-b-5"--}}
                                            {{--data-id="{{ $card->id }}"--}}
                                            {{--data-url="{{ route('admin.cards.edit') }}">编辑--}}
                                            {{--</button>--}}
                                            {{--<button id="cards-destroy" class="btn-xs btn-danger btn-rounded m-b-5"--}}
                                            {{--data-id="{{ $card->id }}"--}}
                                            {{--data-url="{{ route('admin.cards.destroy') }}">删除--}}
                                            {{--</button>--}}
                                            {{--</td>--}}
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                            {!! $useCards->links() !!}
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