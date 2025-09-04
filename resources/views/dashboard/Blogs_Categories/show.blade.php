@extends('template')

@section('dashboard-content')
    @include('dashboard.includes.alerts')
    <header class="news-header py-3 my-3" style="background-color: #0d2d45; color: white;">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 style="font-weight: bold">Show <span style="color: #ff7b23f8">Categories</span></h1>
                    <p class="lead">Complete information about all categories</p>
                </div>
            </div>
        </div>
    </header>

    <div class="btn-right">
        <a href="{{ route('category.add') }}" class="btn btn-primary">Add New Category</a>
    </div>

    <table id="categoriestable" class="table table-striped table-bordered mt-3">
        <thead>
            <tr>
                <th>Category Name</th>
                <th>Slug</th>
                <th>Status</th>
                <th>Created Date</th>
                <th>Updated Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->category_name }}</td>
                    <td>{{ $category->category_slug }}</td>
                    <td>{{ ucfirst($category->category_status) }}</td>
                    <td>{{ \Carbon\Carbon::parse($category->created_at)->format('jS M Y H:i') }}</td>
                    <td>{{ \Carbon\Carbon::parse($category->updated_at)->format('jS M Y H:i') }}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                Click for Actions
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('category.edit', $category->category_id) }}">Edit</a>
                                <form action="{{ route('category.delete', $category->category_id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
