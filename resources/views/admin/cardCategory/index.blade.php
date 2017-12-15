@extends('admin.layouts.index')
@section('page-title', '卡包分类管理')
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
                    <button id="cards-category-add" class="btn btn-info m-b-5" style="float: right">添加分类</button>
                </div>
                <div class="panel-body">

                    <!-- 添加 -->
                    @include('admin.cardCategory.add')
                    <!-- 修改 -->
                    @include('admin.cardCategory.edit')

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <table id="datatable" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>分类名称</th>
                                    <th>操作</th>
                                </tr>
                                </thead>

                                <tbody>
                                @if(count($cardCategorys) > 0)

                                    @foreach($cardCategorys as $category)
                                        <tr>
                                            <td>{{ $category->id }}</td>
                                            <td>{{ $category->name }}</td>
                                            <td>
                                                <button id="card-categorys-edit" class="btn-xs btn-info btn-rounded m-b-5" data-id="{{ $category->id }}" data-url="{{ route('admin.cards.category.edit') }}">编辑</button>
                                                <button id="card-categorys-destroy" class="btn-xs btn-danger btn-rounded m-b-5" data-id="{{ $category->id }}" data-url="{{ route('admin.cards.category.destroy') }}">删除</button>
                                            </td>
                                        </tr>
                                    @endforeach

                                @else

                                    <tr>
                                        <td colspan="3">暂无宅配卡分类</td>
                                    </tr>

                                @endif
                                </tbody>
                            </table>

                            {!! $cardCategorys->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End Row -->


@endsection

@section('script')
    <script src="{{ asset('admins') }}/js/cardsCategory.js"></script>
@endsection