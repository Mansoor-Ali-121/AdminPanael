@extends('template')
@section('dashboard-content')

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

    <h2>Add Robots</h2>
    <form id="robotsForm" action="{{ route('robots.add') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="allowed">Allow:</label>
            <input type="text" id="allowed" name="allowed" class="form-control" oninput="toggleFields()"
                value="{{ old('allowed') }}">
            @error('allowed')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="disallowed">Disallow:</label>
            <input type="text" id="disallowed" name="disallowed" class="form-control" oninput="toggleFields()"
                value="{{ old('disallowed') }}">
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>

    <script>
        function toggleFields() {
            const allowField = document.getElementById('allowed');
            const disallowField = document.getElementById('disallowed');

            // Enable/disable fields based on input
            if (allowField.value.trim() !== '') {
                disallowField.disabled = true;
            } else {
                disallowField.disabled = false;
            }

            if (disallowField.value.trim() !== '') {
                allowField.disabled = true;
            } else {
                allowField.disabled = false;
            }
        }

        // Initial state
        toggleFields();
    </script>


@endsection
