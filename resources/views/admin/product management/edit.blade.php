@extends('layouts.admindash')

@section('content')
    <div class="container">
        <h2>Edit Product</h2>

        <form action="{{ route('products.update', $product) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Name</label>
                <input name="name" class="form-control" value="{{ $product->name }}" required>
            </div>
            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control">{{ $product->description }}</textarea>
            </div>
            <div class="mb-3">
                <label>Price</label>
                <input name="price" class="form-control" value="{{ $product->price }}" required>
            </div>
            <div class="mb-3">
                <label>Stock Quantity</label>
                <input name="stock_quantity" class="form-control" value="{{ $product->stock_quantity }}" required>
            </div>
            <button class="btn btn-success">Update</button>
        </form>
    </div>
@endsection
