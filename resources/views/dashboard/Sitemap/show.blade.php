@extends('template')

@section('dashboard-content')
@include('dashboard.includes.alerts')
    <script>
        $(document).ready(function() {
            $('.toggle-btn').on('click', function() {
                const targetId = $(this).data('target');
                const target = $('#' + targetId);
                target.toggleClass('line-clamp');
                const isExpanded = !target.hasClass('line-clamp');
                $(this).text(isExpanded ? 'Show Less' : 'Show More');
            });
        });
    </script>

    <p style="margin-left: auto;">
        <a href="{{ route('sitemap.add') }}" class="btn btn-primary">Add New URL</a>
    </p>

    <table class="table table-bordered table-striped w-100">
        <thead>
            <tr>
                <th style="width: 20%;">URL</th>
                <th style="width: 20%;">Canonical</th>
                <th style="width: 20%;">Schema</th>
                <th style="width: 30%;">Content</th>
                <th style="width: 10%;">Operation</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($urls as $url)
                <tr>
                    <td style="word-break: break-word;">{{ $url->url }}</td>
                    <td style="word-break: break-word;">{{ $url->canonical }}</td>

                    {{-- Schema Field --}}
                    <td>
                        <div class="line-clamp" id="schema-{{ $url->id }}">
                            {{ $url->schema }}
                        </div>
                        @if (!empty($url->schema) && trim($url->schema) !== '')
                            <button class="btn btn-link p-0 toggle-btn" data-target="schema-{{ $url->id }}">Show
                                More</button>
                        @endif
                    </td>

                    {{-- Page Content Field --}}
                    <td>
                        <div class="line-clamp" id="content-{{ $url->id }}">
                            {{ $url->pagecontent }}
                        </div>
                        @if (!empty($url->pagecontent) && trim($url->pagecontent) !== '')
                            <button class="btn btn-link p-0 toggle-btn" data-target="content-{{ $url->id }}">Show
                                More</button>
                        @endif
                    </td>

                    <td>
                        <a href="{{ route('sitemap.edit',  $url->sitemap_id) }}" class="btn btn-secondary btn-sm">Edit</a>
                        <form action="{{ route('sitemap.delete', $url->sitemap_id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-secondary btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
@endsection
