@extends('admin.layouts.index')
@section('page-title', '宅配卡分类管理')
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
                    <a href="{{ route('admin.card.excel.export') }}" class="btn btn-info m-b-5" style="float: right">宅配卡模板</a>
                    <button id="cards-excel-import" class="btn btn-info m-b-5" style="float: right; margin-right: 10px;">导入宅配卡</button>
                </div>
                <div class="panel-body">

                    <!-- 导入 -->
                    @include('admin.cardExcel.import')

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <table id="datatable" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>卡号</th>
                                </tr>
                                </thead>

                                <tbody>
                                @if(count($cardExcel) > 0)

                                    @foreach($cardExcel as $card)
                                        <tr>
                                            <td>{{ $card->id }}</td>
                                            <td>{{ $card->code }}</td>

                                        </tr>
                                    @endforeach

                                @else

                                    <tr>
                                        <td colspan="3">暂无宅配卡</td>
                                    </tr>

                                @endif
                                </tbody>
                            </table>

                            {!! $cardExcel->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End Row -->


@endsection

@section('script')
    <script src="{{ asset('admins') }}/js/cardExcel.js"></script>
@endsection