@extends('admin.layouts.index')
@section('title', '宅配卡管理')
@section('style')
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">订单列表</h3>
                </div>

                <div class="panel-body">

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <table id="datatable" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>订单编号</th>
                                    <th>订单时间</th>
                                    <th>订单状态</th>
                                    <th>创建时间</th>
                                </tr>
                                </thead>

                                <tbody>
                                @if($orderLists)
                                    @foreach($orderLists as $order)
                                        <tr>
                                            <td>{{ $order->id }}</td>
                                            <td>{{ $order->order_no }}</td>
                                            <td>{{ $order->user_id }}</td>
                                            <td>

                                                @if( $order->status  == 1)
                                                    未支付
                                                @elseif ( $order->status  == 2)
                                                    已支付
                                                @elseif ( $order->status  == 3)
                                                    已发货
                                                @elseif ( $order->status  == 4)
                                                    已支付,库存不足
                                                @elseif ( $order->status  == 5)
                                                    已完成
                                                @else
                                                    其他
                                                @endif
                                            </td>
                                            <td>{{ $order->created_at }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                            {!! $orderLists->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- End Row -->
@endsection