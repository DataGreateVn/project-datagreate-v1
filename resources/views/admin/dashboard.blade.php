@extends('admin.layout')
@section('title','Dashboard')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-semibold mb-4">Admin Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="p-4 border rounded bg-white">
            Tổng sản phẩm:
            <strong>{{ number_format($productCount) }}</strong>
        </div>

        <div class="p-4 border rounded bg-white">
            Tổng bài viết:
            <strong>{{ number_format($postCount) }}</strong>
        </div>

        <div class="p-4 border rounded bg-white">
            Đơn hàng hôm nay:
            <strong>{{ number_format($ordersToday) }}</strong>
        </div>
    </div>
</div>
@endsection