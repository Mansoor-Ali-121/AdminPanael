@extends('template')
@section('dashboard-content')

    @include('dashboard.additional.script-scripts')

@section('local-scripts')
    @yield('local-scripts-addBlog')
@endsection


@include('dashboard.includes.alerts')

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
<h2>Add URL</h2>

<form action="{{ route('sitemap.add') }}" method="post">
    @csrf

    {{-- Google Indexing Checkbox --}}
    <div class="form-group form-check mb-3">
        <input type="checkbox" class="form-check-input" id="send_to_google" name="send_to_google" value="yes"
            {{ old('send_to_google') == 'yes' ? 'checked' : '' }}>
        <label class="form-check-label" for="send_to_google">Send this URL to Google Indexing</label>
    </div>


    {{-- Status Field --}}
    <div class="form-group">
        <label for="status">Status:</label>
        <select id="status" name="status" class="form-control">
            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
        @error('status')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Url Field (user yahan slug likhega) --}}
    <div class="form-group">
        <label for="actual_url">URL:</label>
        <input type="text" id="actual_url" name="actual_url" class="form-control" onkeyup="generateurl()"
            value="{{ old('actual_url') }}">
        @error('actual_url')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Full URL Field (readonly, Google ko ye bhejna hai) --}}
    <div class="form-group">
        <label for="url">Actual URL:</label>
        <input class="form-control" type="text" name="url" id="url" readonly
            placeholder="This url will be sent for google Indexing" value="{{ old('url') }}">
        @error('url')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>


    {{-- Priority --}}
    <div class="form-group">
        <label for="priority">Priority:</label>
        <input type="number" id="priority" name="priority" class="form-control" min="0" step="0.1"
            value="{{ old('priority', '0.5') }}">
        @error('priority')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Canonical Field --}}
    <div class="form-group">
        <label for="canonical">Canonical:</label>
        <input type="text" id="canonical" name="canonical" class="form-control" value="{{ old('canonical') }}">
        @error('canonical')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Meta Title --}}
    <div class="form-group">
        <label for="meta_title">Meta Title:</label>
        <input type="text" id="meta_title" name="meta_title" class="form-control" value="{{ old('meta_title') }}">
        @error('meta_title')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Meta Description --}}
    <div class="form-group">
        <label for="meta_description">Meta Description:</label>
        <input type="text" id="meta_description" name="meta_description" class="form-control"
            value="{{ old('meta_description') }}">
        @error('meta_description')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Schema Field --}}
    <div class="form-group">
        <label for="schema">Schema:</label>
        <textarea id="schema" name="schema" rows="7" class="form-control">{{ old('schema') }}</textarea>
        @error('schema')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Page Content --}}
    <div class="form-group">
        <label for="pagecontent">Page Content:</label>
        <textarea id="pagecontent" name="pagecontent" class="tinymce" rows="20">{{ old('pagecontent') }}</textarea>
        @error('pagecontent')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Alternate Pages Container --}}
    <div id="alternateContainer" style="margin-top: 20px;"></div>

    {{-- Submit Buttons --}}
    <div style="display: flex; justify-content: space-between;">
        <div>
            <button type="submit" name="submit" class="btn btn-primary">Add</button>
            <a href="{{ route('sitemap.show') }}" class="btn btn-secondary">Back</a>
        </div>
        <button type="button" onclick="addAlternate()" class="btn btn-secondary">Add Alternate Page</button>
    </div>
</form>


{{--  URL slug --}}
{{-- Script --}}
<script>
    function generateurl() {
        var slug = document.getElementById('actual_url').value.trim();
        if (slug !== "") {
            var fullUrl = 'https://devshieldit.com/' + slug;
            document.getElementById('url').value = fullUrl;
        } else {
            document.getElementById('url').value = "";
        }
    }
</script>


<script>
    let alternateIndex = 0;
    const oldAlternates = @json(old('alternate', []));

    function addAlternate(hreflang = '', href = '') {
        const container = document.getElementById('alternateContainer');

        const html = `
            <div class="alternate-group" style="margin-bottom: 15px; border-top: 1px solid #ccc; padding-top: 10px; position: relative;">
                <h6>Alternate Page ${alternateIndex + 1}</h6>

                <div class="form-group">
                    <label for="hreflang_${alternateIndex}">hreflang:</label>
                    <input type="text" name="alternate[${alternateIndex}][hreflang]" class="form-control" value="${hreflang}">
                </div>

                <div class="form-group">
                    <label for="href_${alternateIndex}">href:</label>
                    <input type="text" name="alternate[${alternateIndex}][href]" class="form-control" value="${href}">
                </div>

                <button type="button" class="btn btn-danger btn-sm remove-alternate" style="margin-top: 10px;">Delete</button>
            </div>
        `;

        container.insertAdjacentHTML('beforeend', html);
        alternateIndex++;
    }

    // Remove alternate group on delete button click
    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('remove-alternate')) {
            e.target.closest('.alternate-group').remove();
        }
    });

    // Populate old alternates if they exist
    if (oldAlternates.length > 0) {
        oldAlternates.forEach(alt => {
            addAlternate(alt.hreflang, alt.href);
        });
    }
</script>


@endsection
