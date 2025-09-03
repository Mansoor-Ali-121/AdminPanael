@extends('template')

@section('dashboard-content')
    @include('dashboard.includes.alerts')


    <div class="btn-right">
        <a href="{{route('blog.add')}}" class="btn btn-primary">Add New Blog</a>
    </div>

    <ul class="nav nav-tabs" id="blogtabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="english-tab" data-toggle="tab" href="#english" role="tab"
                aria-controls="english" aria-selected="true">English Blogs</a>
        </li>
    </ul>

    <div class="tab-content" id="blogtabsContent">
        <div class="tab-pane fade show active" id="english" role="tabpanel" aria-labelledby="english-tab">
            <table id="blogstable" class="table table-striped table-bordered mt-3">
                <thead>
                    <tr>
                        <th>Blog Title</th>
                        <th>Slug</th>
                        <th>Posted Date</th>
                        <th>Updated Date</th>
                        <th>Published Date and Time</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($blogs as $blog)
                        <tr>
                            <td>{{ $blog->blog_title }}</td>

                            <td>{{ $blog->blog_slug }}</td>

                            <td>{{ \Carbon\Carbon::parse($blog->created_at)->format('jS M Y H:i') }}</td>

                            <td>{{ \Carbon\Carbon::parse($blog->updated_at)->format('jS M Y H:i') }}</td>

                            <td>
                                @if ($blog->shedule_date && $blog->shedule_time)
                                    {{ \Carbon\Carbon::parse($blog->shedule_date)->format('jS M Y') }}
                                    {{ \Carbon\Carbon::parse($blog->shedule_time)->format('H:i') }}
                                @elseif($blog->shedule_date)
                                    {{ \Carbon\Carbon::parse($blog->shedule_date)->format('jS M Y') }}
                                @elseif($blog->shedule_time)
                                    {{ \Carbon\Carbon::parse($blog->shedule_time)->format('H:i') }}
                                @else
                                    N/A
                                @endif
                            </td>

                            <td>{{ ucfirst($blog->status) }}</td>

                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown">
                                        Click for Actions
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('blog.view', $blog->blog_id) }}">View</a>
                                        <a class="dropdown-item" href="">Edit</a>
                                        <form action="" method="POST"
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
