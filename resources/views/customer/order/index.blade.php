@extends('app')

@section('content')
    <div class="container">
        <h3>Mues pedidos</h3>

        <a href="{{route('customer.order.create')}}" class="btn btn-default">Novo Pedido</a>
        <br /><br />

        <table class="table table-bordered">
            <thead>
            <tr>
            <th>ID</th>
            <th>Total</th>
            <th>Status</th>
            </tr>
            </thead>
            <tboby>
                @foreach($orders as $order)
                <tr>
                    <td>{{$order->id}}</td>
                    <td>{{$order->total}}</td>
                    <td>{{$order->status}}</td>
                </tr>
                @endforeach
            </tboby>
            
        </table>

        {!! $orders->render() !!}
    </div>

@endsection