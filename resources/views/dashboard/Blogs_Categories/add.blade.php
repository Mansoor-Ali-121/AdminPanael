@extends('template')

@include('dashboard.additional.script-scripts')
@section('local-scripts')
    @yield('local-scripts-addBlog')
@endsection

@section('dashboard-content')
    @include('dashboard.includes.alerts')

    <header class="news-header py-3 my-3" style="background-color: #0d2d45; color: white;">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 style="font-weight: bold">Add <span style="color: #ff7b23f8">Category</span></h1>
                    <p class="lead">Fill information about this category</p>
                </div>
            </div>
        </div>
    </header>

    <form action="{{ route('category.add') }}" method="POST"> {{-- Add your actual route --}}
        @csrf

        <h4>Category Details</h4>
        <section class="card p-3 mb-3 card-border">

            <fieldset class="form-group">
                <label for="category_name"><sup>*</sup>Category Name:</label>
                <input type="text" id="category_name" name="category_name" class="form-control"
                    value="{{ old('category_name') }}" required>
                @error('category_name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </fieldset>

            {{-- Custom Slug --}}
            <fieldset class="form-group">
                <label for="actual_slug"><sup>*</sup>Category Slug (No Special Characters):</label>
                <input type="text" id="actual_slug" name="actual_slug" class="form-control"
                    value="{{ old('actual_slug') }}" onkeyup="generateSlug()" required>
                @error('actual_slug')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </fieldset>

            {{-- Slug Preview --}}
            <fieldset class="form-group">
                <label for="category_slug">Slug Preview:</label>
                <input class="form-control" type="text" name="category_slug" id="category_slug"
                    value="{{ old('category_slug') }}" readonly>
            </fieldset>

        </section>

        <h4>SEO Details</h4>
        <section class="card p-3 mb-3 card-border">


            <fieldset class="form-group">
                <label for="category_status"><sup>*</sup>Category Status:</label>
                <select id="category_status" name="category_status" class="form-control" required>
                    <option value="">-- Select Status --</option>
                    <option value="active" {{ old('category_status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('category_status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('category_status')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </fieldset>
        </section>

        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
