@extends('template')

@section('dashboard-content')
    @include('dashboard.includes.alerts')

    <header class="news-header py-3 my-3" style="background-color: #0d2d45; color: white;">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 style="font-weight: bold">Show <span style="color: #ff7b23f8">Services</span></h1>
                    <p class="lead">Complete information about all services</p>
                </div>
            </div>
        </div>
    </header>

    <div class="btn-right">
        <a href="{{ route('service.add') }}" class="btn btn-primary">Add New Service</a>
    </div>

    <div class="tab-content" id="servicetabsContent">
        <div class="tab-pane fade show active" id="english" role="tabpanel" aria-labelledby="english-tab">
            <table id="servicestable" class="table table-striped table-bordered mt-3">
                <thead>
                    <tr>
                        <th>Service Name</th>
                        <th>Slug</th>
                        <th>Booking Link</th>
                        <th>Booking Page</th>
                        <th>Created Date</th>
                        <th>Updated Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($services as $service)
                        <tr>
                            <td>{{ $service->service_name }}</td>
                            <td>{{ $service->service_slug }}</td>
                            <td>{{ $service->booking_link ?? 'N/A' }}</td>
                            <td>{{ $service->booking_page ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($service->created_at)->format('jS M Y H:i') }}</td>
                            <td>{{ \Carbon\Carbon::parse($service->updated_at)->format('jS M Y H:i') }}</td>

                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown">
                                        Click for Actions
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('service.edit', $service->id) }}">Edit</a>
                                        <form action="{{ route('service.delete', $service->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
@endsection
