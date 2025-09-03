@extends('template')

@include('dashboard.additional.script-scripts')
@section('local-scripts')
    @yield('local-scripts-addBlog')
@endsection

@section('dashboard-content')



@include('dashboard.includes.alerts')


<h3 class="text-center">Add New Blog</h3>


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
            <input required type="file" name="blog_image" id="blog_image" onchange="previewMainImage(event)">
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
        <fieldset class="form-group">
            <label for="blog_slug"><sup>*</sup>Blog Slug: Don't use Special Characters</label>
            <input type="text" id="blog_slug" name="blog_slug" class="form-control" value="{{ old('blog_slug') }}"
                onkeyup="generateSlug()" required>
            @error('blog_slug')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </fieldset>

        <fieldset class="form-group">
            <label for="actual_slug">Actual Slug Preview:</label>
            <input class="form-control" type="text" name="actual_slug" id="actual_slug"
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
</form>

@endsection
