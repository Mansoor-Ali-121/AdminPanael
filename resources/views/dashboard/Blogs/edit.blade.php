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
                    <h1 style="font-weight: bold">Edit <span style="color: #ff7b23f8">Blog</span></h1>
                    <p class="lead">Complete information about all blog</p>
                </div>
            </div>
        </div>
    </header>

    <form action="{{ route('blog.update', $blog->blog_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <h4>Blog Details</h4>
        <section class="card p-3 mb-3 card-border">
            <fieldset class="form-group">
                <label for="blog_title"><sup>*</sup>Blog Title:</label>
                <input type="text" id="blog_title" name="blog_title" class="form-control"
                    value="{{ old('blog_title', $blog->blog_title) }}" required>
            </fieldset>

            <fieldset class="form-group">
                <label for="blog_description"><sup>*</sup>Blog Description:</label>
                <input type="text" id="blog_description" name="blog_description" class="form-control"
                    value="{{ old('blog_description', $blog->blog_description) }}" required>
            </fieldset>
        </section>

        <h4>Image Details</h4>
        <section class="card p-3 mb-3 card-border">
            <fieldset class="form-group">
                <label for="blog_image">Change Main Image (optional):</label>
                <input type="file" name="blog_image" id="blog_image" onchange="previewMainImage(event)">
                @if ($blog->blog_image)
                    <div>
                        <small>Current Image:</small><br>
                        <img src="{{ asset('blog_images/' . $blog->blog_image) }}" alt="Current Blog Image" height="100">
                    </div>
                @endif
            </fieldset>

            <fieldset class="form-group">
                <label for="image_alt_text"><sup>*</sup>Image Alternate Text:</label>
                <input type="text" id="image_alt_text" name="image_alt_text" class="form-control"
                    value="{{ old('image_alt_text', $blog->image_alt_text) }}" required>
            </fieldset>
        </section>

        <div class="form-group">
            <label for="blog_content"><sup>*</sup>Blog Content:</label>
            <textarea id="blog_content" name="blog_content" class="tinymce" rows="20">{{ old('blog_content', $blog->blog_content) }}</textarea>
        </div>

        <h4>SEO Details</h4>
        <section class="card p-3 mb-3 card-border">
            {{-- User enters this --}}
            <fieldset class="form-group">
                <label for="actual_slug"><sup>*</sup>Blog Slug (Custom):</label>
                <input type="text" id="actual_slug" class="form-control"
                    value="{{ old('actual_slug', $blog->blog_slug) }}" onkeyup="generateSlug()" required>
            </fieldset>

            {{-- Auto-generated slug (readonly + saved to DB) --}}
            <fieldset class="form-group">
                <label for="blog_slug">Slug to Save:</label>
                <input class="form-control" type="text" name="blog_slug" id="blog_slug"
                    value="{{ old('blog_slug', $blog->blog_slug) }}" readonly>
            </fieldset>


            <fieldset class="form-group">
                <label for="meta_title"><sup>*</sup>Meta Title:</label>
                <input type="text" id="meta_title" name="meta_title" class="form-control"
                    value="{{ old('meta_title', $blog->meta_title) }}" required>
            </fieldset>

            <fieldset class="form-group">
                <label for="meta_description"><sup>*</sup>Meta Description:</label>
                <input type="text" id="meta_description" name="meta_description" class="form-control"
                    value="{{ old('meta_description', $blog->meta_description) }}" required>
            </fieldset>
        </section>

        <h4>Optional Details</h4>
        <div class="card p-3 mb-3">
            <fieldset class="form-group">
                <label for="blog_tags">Tags (Separated by comma):</label>
                <input type="text" id="blog_tags" name="blog_tags" class="form-control"
                    value="{{ old('blog_tags', $blog->blog_tags) }}">
            </fieldset>
        </div>

        <h3>Set Schedule</h3>
        <div class="form-group">
            <input type="radio" id="published" name="status" value="active"
                {{ old('status', $blog->status) == 'active' ? 'checked' : '' }} onclick="toggleFields()" />
            <label for="published">Publish Now</label><br>

            <input type="radio" id="draft" name="status" value="inactive"
                {{ old('status', $blog->status) == 'inactive' ? 'checked' : '' }}
                onclick="toggleFields(); onDraftSelected();" />
            <label for="draft">Draft</label>
        </div>

        <div id="dateTimeFields" class="{{ old('status', $blog->status) == 'active' ? '' : 'hidden' }}">
            <label for="shedule_date">Schedule Date:</label>
            <input type="date" id="shedule_date" name="shedule_date" class="form-control"
                value="{{ old('shedule_date', $blog->shedule_date) }}">

            <br>

            <label for="shedule_time">Schedule Time:</label>
            <input type="time" id="shedule_time" name="shedule_time" class="form-control"
                value="{{ old('shedule_time', $blog->shedule_time) }}">
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Update Blog</button>
    </form>
@endsection
