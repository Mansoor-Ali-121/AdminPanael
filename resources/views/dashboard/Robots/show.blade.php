@extends('template')
@section('dashboard-content')

    @include('dashboard.includes.alerts')


    {{-- Alerts handling --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <ul class="nav nav-tabs" id="blogtabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="allow-tab" data-bs-toggle="tab" href="#allow" role="tab" aria-controls="allow"
                aria-selected="true">Allowed</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="disallow-tab" data-bs-toggle="tab" href="#disallow" role="tab"
                aria-controls="disallow" aria-selected="false">Disallowed</a>
        </li>
        <p style="margin-left: auto;">

            <a href='{{ route('robots.add') }}' class="btn btn-primary">Add
                New Entry</a>
        </p>
    </ul>

    <div class="tab-content" id="blogtabsContent">
        <!-- allow Articles Tab -->
        <div class="tab-pane fade show active" id="allow" role="tabpanel" aria-labelledby="allow-tab">
            <table class="table table-striped table-bordered mt-3">
                <thead>
                    <tr>
                        <!-- <th>ID</th> -->
                        <th>Entry</th>
                        <th>Update</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($allowed_entries as $allowed)
                        <tr>
                            {{-- <td>{{ $allowed->id }}</td> --}}
                            <td>{{ $allowed->allowed }}</td>
                            <td>
                                <a href="{{ route('robots.edit', $allowed->id) }}" class="btn btn-primary">Edit</a>
                            </td>
                            <td>
                                <form action="{{ route('robots.delete', $allowed->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id" value="{{ $allowed->id }}">
                                    <button type="submit" class="btn btn-secondary btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

        <!-- disallow Articles Tab -->
        <div class="tab-pane fade" id="disallow" role="tabpanel" aria-labelledby="disallow-tab">
            <table class="table table-striped table-bordered mt-3">
                <thead>
                    <tr>
                        <!-- <th>ID</th> -->
                        <th>Entry</th>
                        <th>Update</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($disallowed_entries as $disallowed)
                        <tr>
                            {{-- <td>{{ $disallowed->id }}</td> --}}
                            <td>{{ $disallowed->disallowed }}</td>
                            <td>
                                <a href="{{ route('robots.edit', $disallowed->id) }}" class="btn btn-primary">Edit</a>
                            </td>
                              <td>
                                <form action="{{ route('robots.delete', $disallowed->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id" value="{{ $disallowed->id }}">
                                    <button type="submit" class="btn btn-secondary btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
@endsection
