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

    {{-- URL Field --}}
    <div class="form-group">
        <label for="url">URL:</label>
        <input type="text" id="url" name="url" class="form-control" onkeyup="generateurl()"
            value="{{ old('url') }}">
        @error('url')
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

    {{-- Actual URL (readonly field, auto generate hota hai) --}}
    <div class="form-group">
        <label for="actual_url">Actual Url:</label>
        <input class="form-control" type="text" name="actual_url" id="actual_url" readonly
            placeholder="This url will be sent for google Indexing" value="{{ old('actual_url') }}">
        @error('actual_url')
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
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        <button type="button" onclick="addAlternate()" class="btn btn-secondary">Add Alternate Page</button>
    </div>
</form>

{{-- Actual URL --}}
<script>
    function generateurl() {
        var packageName = document.getElementById('url').value;
        document.getElementById('actual_url').value = "";
        if (!packageName.includes('test.com')) {
            var fullUrl = 'https://test.com/' + packageName;
            document.getElementById('actual_url').value = fullUrl;
        } else {
            document.getElementById('actual_url').value =
                "this url will not be sent to goole for indexing because it contains site url";
        }
    }
</script>

{{-- Alternate Pages --}}
<script>
    let alternateIndex = 0;
    const oldAlternates = @json(old('alternate', []));

    function addAlternate(hreflang = '', href = '') {
        const container = document.getElementById('alternateContainer');

        const html = `
            <div class="alternate-group" style="margin-bottom: 15px; border-top: 1px solid #ccc; padding-top: 10px;">
                <h6>Alternate Page ${alternateIndex + 1}</h6>
                <div class="form-group">
                    <label for="hreflang_${alternateIndex}">hreflang:</label>
                    <input type="text" name="alternate[${alternateIndex}][hreflang]" class="form-control" value="${hreflang}">
                </div>
                <div class="form-group">
                    <label for="href_${alternateIndex}">href:</label>
                    <input type="text" name="alternate[${alternateIndex}][href]" class="form-control" value="${href}">
                </div>
            </div>
        `;

        container.insertAdjacentHTML('beforeend', html);
        alternateIndex++;
    }

    // Populate old alternates if they exist
    if (oldAlternates.length > 0) {
        oldAlternates.forEach(alt => {
            addAlternate(alt.hreflang, alt.href);
        });
    }
</script>

@endsection
