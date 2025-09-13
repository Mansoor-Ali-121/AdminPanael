@extends('template')
@section('dashboard-content')
    @include('dashboard.includes.alerts')

    {{-- Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h2>Edit Service</h2>

    <form action="{{ route('service.update', $service->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <!-- Service Name -->
        <div class="form-group">
            <label for="serviceName">Service Name:</label>
            <input type="text" id="serviceName" name="service_name" class="form-control" required
                value="{{ old('service_name', $service->service_name) }}">
            @error('service_name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Slug Input -->
        <div class="form-group">
            <label for="serviceSlug">Service Slug which only add after https://servicefinders.ch/cleaning-services/<span style="color:red;">here</span>:</label>
            <input type="text" id="actual_slug" name="actual_slug" class="form-control" onkeyup="generateSlug()" required
                value="{{ old('actual_slug', $service->service_slug) }}">
            @error('actual_slug')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Slug (readonly) but stored in databse as well -->
        <div class="form-group">
            <input class="form-control" type="text" name="service_slug" id="service_slug"
                placeholder="This will be your actual Slug" readonly value="{{ old('service_slug', $service->service_slug) }}">
        </div>

        <!-- Booking Link -->
        <div class="form-group">
            <label for="bookingLink">Booking slug which only add after https://servicefinders.ch/booking/<span style="color:red;">here</span>:</label>
            <input type="text" id="bookingLink" name="booking_link" class="form-control" required
                value="{{ old('booking_link', $service->booking_link) }}">
            @error('booking_link')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Booking Page -->
        <div class="form-group">
            <label for="bookingpage">Select Booking Page:</label>
            <select id="bookingpage" name="booking_page" class="form-control" required>
                <option value="">-- Select Booking Page --</option>
                <option value="carpet-cleaning" {{ old('booking_page', $service->booking_page) == 'carpet-cleaning' ? 'selected' : '' }}>Carpet Cleaning</option>
                <option value="moveout-cleaning" {{ old('booking_page', $service->booking_page) == 'moveout-cleaning' ? 'selected' : '' }}>Moveout Cleaning</option>
                <option value="window-cleaning" {{ old('booking_page', $service->booking_page) == 'window-cleaning' ? 'selected' : '' }}>Window Cleaning</option>
                <option value="deep-cleaning" {{ old('booking_page', $service->booking_page) == 'deep-cleaning' ? 'selected' : '' }}>Deep Cleaning</option>
                <option value="general-cleaning" {{ old('booking_page', $service->booking_page) == 'general-cleaning' ? 'selected' : '' }}>General Cleaning</option>
            </select>
            @error('booking_page')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Description -->
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea name="description" class="form-control" cols="30" rows="10" required>{{ old('description', $service->description) }}</textarea>
            @error('description')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Existing Image Preview (optional) -->
        @if($service->service_image)
            <div class="form-group">
                <label>Current Image:</label><br>
                <img src="{{ asset('Uploads/service_images/' . $service->service_image) }}" alt="Service Image" width="150">
            </div>
        @endif

        <!-- Image Upload -->
        <div class="form-group">
            <label for="serviceImage">Change Image (optional):</label>
            <input type="file" id="serviceImage" name="service_image" class="form-control">
            @error('service_image')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Submit -->
      <button type="submit" name="submit" class="btn btn-primary">Update</button>
    </form>

    {{-- Slug Generator --}}
    <script>
        function generateSlug() {
            var input = document.getElementById('actual_slug').value;
            var slug = input.trim().toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
            document.getElementById('service_slug').value = slug;
        }
    </script>
@endsection
