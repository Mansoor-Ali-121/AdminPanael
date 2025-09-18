@extends('template')
@section('dashboard-content')

    @include('dashboard.additional.script-scripts')

@section('local-scripts')
    @yield('local-scripts-addBlog')
@endsection

@include('dashboard.includes.alerts')

{{-- Validation Errors --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<h2>Edit URL</h2>

<form action="{{ route('sitemap.update', $sitemap->sitemap_id) }}" method="post">
    @csrf
    @method('PATCH')

    {{-- Google Indexing Checkbox --}}
    <div class="form-group form-check mb-3">
        <input type="checkbox" class="form-check-input" id="send_to_google" name="send_to_google" value="yes"
            {{ old('send_to_google', $sitemap->send_to_google ?? 'no') === 'yes' ? 'checked' : '' }}>
        <label class="form-check-label" for="send_to_google">
            Send this URL to Google Indexing
        </label>
    </div>

    {{-- URL (user types slug here) --}}
    <div class="form-group">
        <label for="actual_url">URL:</label>
        <input type="text" id="actual_url" name="actual_url" class="form-control" onkeyup="generateurl()"
            value="{{ old('actual_url', $sitemap->actual_url) }}">
        @error('actual_url')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Full URL stored in database --}}
    <div class="form-group">
        <label for="url">Actual Url:</label>
        <input class="form-control" type="text" name="url" id="url" readonly
            value="{{ old('url', $sitemap->url) }}">
        @error('url')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>


    {{-- Priority --}}
    <div class="form-group">
        <label for="priority">Priority:</label>
        <input type="number" id="priority" name="priority" class="form-control" min="0" step="0.1"
            value="{{ old('priority', $sitemap->priority) }}">
        @error('priority')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Canonical --}}
    <div class="form-group">
        <label for="canonical">Canonical:</label>
        <input type="text" id="canonical" name="canonical" class="form-control"
            value="{{ old('canonical', $sitemap->canonical) }}">
        @error('canonical')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Meta Title --}}
    <div class="form-group">
        <label for="meta_title">Meta Title:</label>
        <input type="text" id="meta_title" name="meta_title" class="form-control"
            value="{{ old('meta_title', $sitemap->meta_title) }}">
        @error('meta_title')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Meta Description --}}
    <div class="form-group">
        <label for="meta_description">Meta Description:</label>
        <input type="text" id="meta_description" name="meta_description" class="form-control"
            value="{{ old('meta_description', $sitemap->meta_description) }}">
        @error('meta_description')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Schema --}}
    <div class="form-group">
        <label for="schema">Schema:</label>
        <textarea id="schema" name="schema" rows="7" class="form-control">{{ old('schema', $sitemap->schema) }}</textarea>
        @error('schema')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Page Content --}}
    <div class="form-group">
        <label for="pagecontent">Page Content:</label>
        <textarea id="pagecontent" name="pagecontent" class="tinymce" rows="20">{{ old('pagecontent', $sitemap->pagecontent) }}</textarea>
        @error('pagecontent')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Alternate Pages Container --}}
    <div id="alternateContainer" style="margin-top: 20px;"></div>

    {{-- Buttons --}}
    <div style="display: flex; justify-content: space-between;">
        <div>
            <button type="submit" name="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('sitemap.show') }}" class="btn btn-secondary">Back</a>
        </div>
        <button type="button" onclick="addAlternate()" class="btn btn-secondary">Add Alternate Page</button>
    </div>
</form>

{{-- Scripts --}}
<script>
    function generateurl() {
        var slug = document.getElementById('actual_url').value.trim(); // user types here
        if (slug !== "") {
            var fullUrl = 'https://devshieldit.com/' + slug; // domain
            document.getElementById('url').value = fullUrl; // readonly field me assign
        } else {
            document.getElementById('url').value = "";
        }
    }


    // Alternate Pages Handling
    let alternateIndex = 0;
    const container = document.getElementById('alternateContainer');
    const oldAlternates = @json(old('alternate', $sitemap->alternates ?? []));

    function addAlternate(hreflang = '', href = '', altId = null) {
        const html = `
            <div class="alternate-group" id="alternate-${altId ?? 'new_' + alternateIndex}" style="margin-bottom: 15px; border-top: 1px solid #ccc; padding-top: 10px; position: relative;">
                <h6>Alternate Page ${alternateIndex + 1}</h6>

                <input type="hidden" name="alternate[${alternateIndex}][alternate_id]" value="${altId ?? ''}">

                <div class="form-group">
                    <label>hreflang:</label>
                    <input type="text" name="alternate[${alternateIndex}][hreflang]" class="form-control" value="${hreflang}">
                </div>

                <div class="form-group">
                    <label>href:</label>
                    <input type="text" name="alternate[${alternateIndex}][href]" class="form-control" value="${href}">
                </div>

                ${altId ? `<button type="button" class="btn btn-danger btn-sm mt-2" onclick="deleteAlternate(${altId})">Delete</button>` 
                        : `<button type="button" class="btn btn-danger btn-sm remove-alternate" style="margin-top: 10px;">Delete</button>`}
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        alternateIndex++;
    }

    // Populate old alternates
    oldAlternates.forEach((alt, idx) => {
        const hreflang = alt.hreflang ?? '';
        const href = alt.href ?? '';
        const altId = alt.alternate_id ?? null;
        addAlternate(hreflang, href, altId);
    });

    // Remove dynamically added alternate
    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('remove-alternate')) {
            e.target.closest('.alternate-group').remove();
        }
    });

    // AJAX Delete alternate
    function deleteAlternate(id) {
        if (!confirm('Are you sure you want to delete this alternate?')) return;

        const url = "{{ route('alternate.delete', ['id' => ':id']) }}".replace(':id', id);
        fetch(url, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    document.getElementById('alternate-' + id).remove();
                } else {
                    alert(data.message || 'Failed to delete. Try again.');
                }
            })
            .catch(err => {
                console.error(err);
                alert('An error occurred. Please try again.');
            });
    }
</script>

@endsection
