@extends('layouts.userdash')

@section('title', 'Services')
@section('header', 'Manage Services')

@section('styles')
<style>
    .settings-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .settings-section {
        padding: 2rem;
        border-bottom: 1px solid #eee;
    }

    .settings-section:last-child {
        border-bottom: none;
    }

    .settings-title {
        color: var(--primary-purple);
        font-weight: 600;
        margin-bottom: 1.5rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        font-weight: 500;
        margin-bottom: 0.5rem;
        display: block;
    }

    .form-control {
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #ddd;
        border-radius: 6px;
    }

    .btn-primary {
        background-color: var(--primary-purple);
        border-color: var(--primary-purple);
    }

    .table {
        width: 100%;
        margin-top: 1rem;
    }

    .table th, .table td {
        padding: 0.75rem;
        text-align: left;
        border-bottom: 1px solid #eee;
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    @if(session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="settings-card">
        <div class="settings-section">
            <h5 class="settings-title">Add New Service</h5>
            <form action="{{ route('services.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="service_type">Service Type</label>
                    <input type="text" name="service_type" id="service_type" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" name="description" id="description" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="price">Price (₱)</label>
                    <input type="number" step="0.01" name="price" id="price" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Add Service</button>
            </form>
        </div>

        <div class="settings-section">
            <h5 class="settings-title">Service List</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>Service Type</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($services as $service)
                        <tr>
                            <td>{{ $service->service_type }}</td>
                            <td>{{ $service->description }}</td>
                            <td>₱{{ number_format($service->price, 2) }}</td>
                            <td>{{ $service->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection