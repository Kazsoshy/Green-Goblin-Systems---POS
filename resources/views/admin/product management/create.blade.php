@extends('layouts.admindash')

@section('content')
    <div class="container">
        <h2>Add Product</h2>

        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Name</label>
                <input name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <label>Price</label>
                <input name="price" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Stock Quantity</label>
                <input name="stock_quantity" class="form-control" required>
            </div>
            <button class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
