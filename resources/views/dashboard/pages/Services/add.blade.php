@extends('template')
@section('dashboard-content')
    @include('dashboard.includes.alerts')

    {{-- Errors hangling --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h2>Add Service</h2>
    <form action="{{ route('service.add') }}" method="post" enctype="multipart/form-data">
        @csrf

        <!-- Service Name -->
        <div class="form-group">
            <label for="serviceName">Service Name:</label>
            <input type="text" id="serviceName" name="service_name" class="form-control" required
                value="{{ old('service_name') }}">
            @error('service_name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Slug -->
        <div class="form-group">
            <label for="serviceSlug">Service Slug which only add after https://servicefinders.ch/cleaning-services/<span
                    style="color:red;">here</span>:</label>
            <input type="text" id="actual_slug" name="actual_slug" class="form-control" onkeyup="generateSlug()" required
                value="{{ old('actual_slug') }}">
            @error('actual_slug')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Slug (readonly) but stored in databse as well -->
        <div class="form-group">
            <input class="form-control" type="text" name="service_slug" id="service_slug"
                placeholder="This will be your actual Slug" readonly value="{{ old('service_slug') }}">
        </div>

        <!-- Booking Link -->
        <div class="form-group">
            <label for="bookingLink">Booking slug which only add after https://servicefinders.ch/booking/<span
                    style="color:red;">here</span>:</label>
            <input type="text" id="bookingLink" name="booking_link" placeholder="only after /booking/"
                class="form-control" required value="{{ old('booking_link') }}">
            @error('booking_link')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Booking Page -->
        <div class="form-group">
            <label for="bookingpage">Select Booking Page:</label>
            <select id="bookingpage" name="booking_page" class="form-control" required>
                <option value="">-- Select Booking Page --</option>
                <option value="carpet-cleaning" {{ old('booking_page') == 'carpet-cleaning' ? 'selected' : '' }}>Carpet
                    Cleaning</option>
                <option value="moveout-cleaning" {{ old('booking_page') == 'moveout-cleaning' ? 'selected' : '' }}>Moveout
                    Cleaning</option>
                <option value="window-cleaning" {{ old('booking_page') == 'window-cleaning' ? 'selected' : '' }}>Window
                    Cleaning</option>
                <option value="deep-cleaning" {{ old('booking_page') == 'deep-cleaning' ? 'selected' : '' }}>Deep Cleaning
                </option>
                <option value="general-cleaning" {{ old('booking_page') == 'general-cleaning' ? 'selected' : '' }}>General
                    Cleaning</option>
            </select>
            @error('booking_page')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Description -->
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea name="description" class="form-control" cols="30" rows="10" required>{{ old('description') }}</textarea>
            @error('description')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Image -->
        <div class="form-group">
            <label for="serviceImage">Add Image:</label>
            <input type="file" id="serviceImage" name="service_image" class="form-control" required>
            @error('service_image')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Submit -->
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>

    {{-- Slug --}}
    <script>
        function generateSlug() {
            var packageName = document.getElementById('actual_slug').value;
            var packageSlug = packageName.trim().toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
            document.getElementById('service_slug').value = packageSlug;
        }
    </script>
@endsection
