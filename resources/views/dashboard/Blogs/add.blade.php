@extends('template')
@include('dashboard.additional.style-links')
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
                    <h1 style="font-weight: bold">Add <span style="color: #ff7b23f8">Blog</span></h1>
                    <p class="lead">Fill information about this blog</p>
                </div>
            </div>
        </div>
    </header>

    {{-- Error Messages --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form action="{{ route('blog.add') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <h4>Blog Details</h4>
        <section class="card p-3 mb-3 card-border">
            <fieldset class="form-group">
                <label for="blog_title"><sup>*</sup>Blog Title:</label>
                <input type="text" id="blog_title" name="blog_title" class="form-control" value="{{ old('blog_title') }}"
                    required>
                @error('blog_title')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </fieldset>

            <fieldset class="form-group">
                <label for="blog_description"><sup>*</sup>Blog Description:</label>
                <input type="text" id="blog_description" name="blog_description" class="form-control"
                    value="{{ old('blog_description') }}" required>
                @error('blog_description')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </fieldset>
        </section>

        <h4>Image Details</h4>
        <section class="card p-3 mb-3 card-border">

            <fieldset class="form-group">
                <label for="blog_image"><sup>*</sup>Select Main Image:</label>
                <div class="image-upload-row" style="display: flex; align-items: center;">
                    <img id="mainImagePreview" src="#" alt="Image Preview" />
                    <input class="form-group" required type="file" name="blog_image" id="blog_image"
                        onchange="previewMainImage(event)">
                </div>
                @error('blog_image')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </fieldset>

            <fieldset class="form-group">
                <label for="image_alt_text"><sup>*</sup>Image Alternate Text:</label>
                <input type="text" id="image_alt_text" name="image_alt_text" class="form-control"
                    value="{{ old('image_alt_text') }}" required>
                @error('image_alt_text')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </fieldset>

        </section>

        <div class="form-group">
            <label for="blog_content"><sup>*</sup>Blog Content: </label>
            <textarea id="blog_content" name="blog_content" class="tinymce" rows="20">{{ old('blog_content') }}</textarea>
            @error('blog_content')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <h4>SEO Details</h4>
        <section class="card p-3 mb-3 card-border">

            {{-- Custom Slug --}}
            <fieldset class="form-group">
                <label for="actual_slug"><sup>*</sup>Blog Slug: Don't use Special Characters</label>
                <input type="text" id="actual_slug" name="actual_slug" class="form-control"
                    value="{{ old('actual_slug') }}" onkeyup="generateBlogSlug()" required>
                @error('actual_slug')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </fieldset>

            {{-- System generated Slug which is stored in database --}}
            <fieldset class="form-group">
                <label for="blog_slug">Actual Slug Preview:</label>
                <input class="form-control" type="text" name="blog_slug" id="blog_slug"
                    placeholder="Preview of the Actual Slug (Auto-generated)" value="{{ old('blog_slug') }}" readonly>
            </fieldset>

            <fieldset class="form-group">
                <label for="meta_title"><sup>*</sup>Meta Title:</label>
                <input type="text" id="meta_title" name="meta_title" class="form-control"
                    value="{{ old('meta_title') }}" required>
                @error('meta_title')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </fieldset>

            <fieldset class="form-group">
                <label for="meta_description"><sup>*</sup>Meta Description:</label>
                <input type="text" id="meta_description" name="meta_description" class="form-control"
                    value="{{ old('meta_description') }}" required>
                @error('meta_description')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </fieldset>
        </section>

        <h4>Optional Details</h4>
        <div class="card p-3 mb-3">
            <fieldset class="form-group">
                <label for="blog_tags">Tags (Separated by comma):</label>
                <input type="text" id="blog_tags" name="blog_tags" class="form-control" value="{{ old('blog_tags') }}">
                @error('blog_tags')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </fieldset>

            {{-- Categories --}}
            <fieldset class="form-group">
                <legend>Categories:</legend>
                @php
                    $selectedCategories = old('category_id', []);
                @endphp

                @foreach ($categories as $category)
                    <div class="form-check">
                        <input type="checkbox" id="category_{{ $category->category_id }}" name="category_id[]"
                            value="{{ $category->category_id }}" class="form-check-input category-checkbox"
                            {{ in_array($category->category_id, $selectedCategories) ? 'checked' : '' }}>
                        <label class="form-check-label" for="category_{{ $category->category_id }}">
                            {{ $category->category_name }}
                        </label>
                    </div>
                @endforeach

                @error('category_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </fieldset>



        </div>

        <h3>Set Schedule</h3>
        <div class="form-group">
            <input type="radio" id="published" name="status" value="active"
                {{ old('status', 'active') == 'active' ? 'checked' : '' }} onclick="toggleFields()" />
            <label for="published">Publish Now</label>
            <br>

            <input type="radio" id="draft" name="status" value="inactive"
                {{ old('status') == 'inactive' ? 'checked' : '' }} onclick="toggleFields(); onDraftSelected();" />
            <label for="draft">Draft</label>

            @error('status')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div id="dateTimeFields" class="{{ old('status') == 'active' ? '' : 'hidden' }}">
            <label for="shedule_date">Schedule Date:</label>
            <input type="date" id="shedule_date" name="shedule_date" class="form-control"
                value="{{ old('shedule_date') }}">
            @error('shedule_date')
                <small class="text-danger">{{ $message }}</small>
            @enderror

            <br>

            <label for="shedule_time">Schedule Time:</label>
            <input type="time" id="shedule_time" name="shedule_time" class="form-control"
                value="{{ old('shedule_time') }}">
            @error('shedule_time')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>


        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        <a href="{{ route('blog.show') }}" class="btn btn-secondary">Back</a>
    </form>

    {{-- Blogs Slug --}}
    <script>
        function generateSlug() {
            console.log('jjj');
        }
    </script>
@endsection
