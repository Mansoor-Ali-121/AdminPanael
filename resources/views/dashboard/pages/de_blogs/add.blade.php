<form action="{{ route('blog.add') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <h4>Blog Details</h4>
    <section class="card p-3 mb-3 card-border">
        <fieldset class="form-group">
            <label for="de_blog_title"><sup>*</sup>Blog Title:</label>
            <input type="text" id="de_blog_title" name="de_blog_title" class="form-control"
                value="{{ old('de_blog_title') }}" required>
            @error('de_blog_title')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </fieldset>

        <fieldset class="form-group">
            <label for="de_blog_description"><sup>*</sup>Blog Description:</label>
            <input type="text" id="de_blog_description" name="de_blog_description" class="form-control"
                value="{{ old('de_blog_description') }}" required>
            @error('de_blog_description')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </fieldset>
    </section>

    <h4>Image Details</h4>
    <section class="card p-3 mb-3 card-border">
        <fieldset class="form-group">
            <label for="de_blog_image"><sup>*</sup>Select Main Image:</label>
            <div class="image-upload-row" style="display: flex; align-items: center;">
                <img id="mainImagePreview" src="#" alt="Image Preview" />
                <input class="form-group" required type="file" name="de_blog_image" id="de_blog_image"
                    onchange="previewMainImage(event)">
            </div>
            @error('de_blog_image')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </fieldset>

        <fieldset class="form-group">
            <label for="de_image_alt_text"><sup>*</sup>Image Alternate Text:</label>
            <input type="text" id="de_image_alt_text" name="de_image_alt_text" class="form-control"
                value="{{ old('de_image_alt_text') }}" required>
            @error('de_image_alt_text')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </fieldset>
    </section>

    <div class="form-group">
        <label for="de_blog_content"><sup>*</sup>Blog Content: </label>
        <textarea id="de_blog_content" name="de_blog_content" class="tinymce" rows="20">{{ old('de_blog_content') }}</textarea>
        @error('de_blog_content')
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

        {{-- Auto-generated Slug (saved to DB) --}}
        <fieldset class="form-group">
            <label for="de_blog_slug">Actual Slug Preview:</label>
            <input class="form-control" type="text" name="de_blog_slug" id="de_blog_slug"
                placeholder="Preview of the Actual Slug (Auto-generated)" value="{{ old('de_blog_slug') }}" readonly>
        </fieldset>

        <fieldset class="form-group">
            <label for="de_meta_title"><sup>*</sup>Meta Title:</label>
            <input type="text" id="de_meta_title" name="de_meta_title" class="form-control"
                value="{{ old('de_meta_title') }}" required>
            @error('de_meta_title')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </fieldset>

        <fieldset class="form-group">
            <label for="de_meta_description"><sup>*</sup>Meta Description:</label>
            <input type="text" id="de_meta_description" name="de_meta_description" class="form-control"
                value="{{ old('de_meta_description') }}" required>
            @error('de_meta_description')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </fieldset>
    </section>

    <h4>Optional Details</h4>
    <div class="card p-3 mb-3">
        <fieldset class="form-group">
            <label for="de_blog_tags">Tags (Separated by comma):</label>
            <input type="text" id="de_blog_tags" name="de_blog_tags" class="form-control"
                value="{{ old('de_blog_tags') }}">
            @error('de_blog_tags')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </fieldset>

        {{-- Categories remain same as before --}}
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
        <input type="radio" id="published" name="de_status" value="active"
            {{ old('de_status', 'active') == 'active' ? 'checked' : '' }} onclick="toggleFields()" />
        <label for="published">Publish Now</label>
        <br>

        <input type="radio" id="draft" name="de_status" value="inactive"
            {{ old('de_status') == 'inactive' ? 'checked' : '' }} onclick="toggleFields(); onDraftSelected();" />
        <label for="draft">Draft</label>

        @error('de_status')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div id="dateTimeFields" class="{{ old('de_status', 'active') == 'inactive' ? '' : 'hidden' }}">
        <label for="de_shedule_date">Schedule Date:</label>
        <input type="date" id="de_shedule_date" name="de_shedule_date" class="form-control"
            value="{{ old('de_shedule_date') }}">
        @error('de_shedule_date')
            <small class="text-danger">{{ $message }}</small>
        @enderror

        <br>

        <label for="de_shedule_time">Schedule Time:</label>
        <input type="time" id="de_shedule_time" name="de_shedule_time" class="form-control"
            value="{{ old('de_shedule_time') }}">
        @error('de_shedule_time')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    <a href="{{ route('blog.show') }}" class="btn btn-secondary">Back</a>
</form>
