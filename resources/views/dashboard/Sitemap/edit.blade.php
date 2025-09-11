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

    {{-- URL --}}
    <div class="form-group">
        <label for="url">URL:</label>
        <input type="text" id="url" name="url" class="form-control" onkeyup="generateurl()"
            value="{{ old('url', $sitemap->url) }}">
        @error('url')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Actual URL --}}
    <div class="form-group">
        <label for="actual_url">Actual Url:</label>
        <input class="form-control" type="text" name="actual_url" id="actual_url" readonly
            value="{{ old('actual_url', $sitemap->actual_url) }}">
        @error('actual_url')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Priority: --}}
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
<div id="alternateContainer" style="margin-top: 20px;">
    @foreach (old('alternate', $sitemap->alternates ?? []) as $index => $alternate)
        @php
            $altId = $alternate['alternate_id'] ?? ($alternate->alternate_id ?? null);
            $hreflang = old("alternate.$index.hreflang", $alternate['hreflang'] ?? ($alternate->hreflang ?? ''));
            $href = old("alternate.$index.href", $alternate['href'] ?? ($alternate->href ?? ''));
        @endphp

        <div class="alternate-group"
             id="alternate-{{ $altId ?? 'new_' . $index }}"
             style="margin-bottom: 15px; border-top: 1px solid #ccc; padding-top: 10px;">

            <h6>Alternate Page {{ $index + 1 }}</h6>

            {{-- Hidden alternate_id --}}
            <input type="hidden" name="alternate[{{ $index }}][alternate_id]" value="{{ $altId }}">

            <div class="form-group">
                <label>hreflang:</label>
                <input type="text" name="alternate[{{ $index }}][hreflang]" class="form-control" value="{{ $hreflang }}">
            </div>

            <div class="form-group">
                <label>href:</label>
                <input type="text" name="alternate[{{ $index }}][href]" class="form-control" value="{{ $href }}">
            </div>

            {{-- Show Delete button if record exists in DB --}}
            @if ($altId)
                <button type="button" class="btn btn-danger btn-sm mt-2"
                        onclick="deleteAlternate({{ $altId }})">
                    Delete
                </button>
            @endif
        </div>
    @endforeach
</div>



    {{-- Buttons --}}
    <div style="display: flex; justify-content: space-between;">
        <button type="submit" name="submit" class="btn btn-primary">Update</button>
        <button type="button" onclick="addAlternate()" class="btn btn-secondary">Add Alternate Page</button>
    </div>
</form>

{{-- JavaScript --}}
<script>
    function generateurl() {
        var packageName = document.getElementById('url').value;
        document.getElementById('actual_url').value = "";
        if (!packageName.includes('test.com')) {
            var fullUrl = 'https://test.com/' + packageName;
            document.getElementById('actual_url').value = fullUrl;
        } else {
            document.getElementById('actual_url').value =
                "this url will not be sent to google for indexing because it contains site url";
        }
    }

    let alternateIndex = {{ count(old('alternate', $sitemap->alternates ?? [])) }};

    function addAlternate() {
        const container = document.getElementById('alternateContainer');
        const html = `
        <div class="alternate-group" style="margin-bottom: 15px; border-top: 1px solid #ccc; padding-top: 10px;">
            <h6>Alternate Page ${alternateIndex + 1}</h6>
            <div class="form-group">
                <label>hreflang:</label>
                <input type="text" name="alternate[${alternateIndex}][hreflang]" class="form-control">
            </div>
            <div class="form-group">
                <label>href:</label>
                <input type="text" name="alternate[${alternateIndex}][href]" class="form-control">
            </div>
        </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        alternateIndex++;
    }
</script>

{{-- Delete Alternate --}}
<script>
    function deleteAlternate(id) {
        if (!confirm('Are you sure you want to delete this alternate?')) {
            return;
        }

        const url = "{{ route('alternate.delete', ['id' => ':id']) }}".replace(':id', id);

        fetch(url, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Remove the alternate block from DOM
                document.getElementById('alternate-' + id).remove();
            } else {
                alert(data.message || 'Failed to delete. Try again.');
            }
        })
        .catch(error => {
            console.error(error);
            alert('An error occurred. Please try again.');
        });
    }
</script>


@endsection
