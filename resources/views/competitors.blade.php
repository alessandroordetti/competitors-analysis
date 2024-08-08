@extends('layout.main')

@section('content')
<h1>Products</h1>
<div class="col-12">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Competitor</th>
                <th scope="col">SKU</th>
                <th scope="col">Product</th>
                <th scope="col">Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($competitors as $competitor)
            <tr>
                <th scope="row">{{$competitor->id}}</th>
                <td>{{$competitor->competitor}}</td>
                <td>{{$competitor->sku}}</td>
                <td>{{$competitor->product_title}}</td>
                <td>{{$competitor->sale_price}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection