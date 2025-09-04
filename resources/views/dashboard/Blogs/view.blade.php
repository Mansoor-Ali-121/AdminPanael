@extends('template')

@section('dashboard-content')
    <header class="news-header" style="background-color: #0d2d45; color: white;">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 style="font-weight: bold">Blog <span style="color: #ff7b23f8">Details</span></h1>
                    <p class="lead">Complete information about this blog</p>
                </div>
            </div>
        </div>
    </header>


    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="detail-container">
                    <table class="detail-table">
                        <tbody>
                            <tr>
                                <th>Title</th>
                                <td>{{ $blog->blog_title ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Slug</th>
                                <td>{{ $blog->blog_slug ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td>{{ $blog->blog_description ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Tags</th>
                                <td>{{ $blog->blog_tags ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if ($blog->status === 'active')
                                        <span class="status-badge status-active">
                                            <i class="fas fa-check-circle me-2"></i>Active
                                        </span>
                                    @else
                                        <span class="status-badge status-inactive">
                                            <i class="fas fa-times-circle me-2"></i>Inactive
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Scheduled For</th>
                                <td>
                                    @if ($blog->shedule_date && $blog->shedule_time)
                                        {{ Carbon::parse($blog->shedule_date)->format('jS M Y') }}
                                        at {{ Carbon::parse($blog->shedule_time)->format('H:i') }}
                                    @else
                                        Not Scheduled
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Meta Title</th>
                                <td>{{ $blog->meta_title ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Meta Description</th>
                                <td>{{ $blog->meta_description ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Image</th>
                                <td>
                                    @if ($blog->blog_image)
                                        <div class="news-image-container">
                                            <img src="{{ asset('blog_images/' . $blog->blog_image) }}"
                                                alt="{{ $blog->image_alt_text ?? 'Blog Image' }}" class="news-image">
                                        </div>
                                        <div class="text-muted mt-2">
                                            <i class="fas fa-info-circle me-2"></i>File:
                                            {{ $blog->blog_image }}
                                        </div>
                                    @else
                                        <div class="text-muted mt-2">
                                            <i class="fas fa-image me-2"></i>No image available.
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Timestamps</th>
                                <td>
                                    <div class="mb-2">
                                        <span class="info-label">Created:</span>
                                        {{ $blog->created_at ? $blog->created_at->format('M d, Y') : 'N/A' }}
                                    </div>
                                    <div>
                                        <span class="info-label">Updated:</span>
                                        {{ $blog->updated_at ? $blog->updated_at->format('M d, Y') : 'N/A' }}
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="content-section mt-5">
                    <h3>Blog Content</h3>
                    <div class="content-section-image">
                        {!! $blog->blog_content !!}
                    </div>

                    <div class="action-buttons mt-4">
                        <a href="{{ route('blog.show') }}">
                            <button type="button" class="btn btn-outline-secondary px-4">
                                <i class="fas fa-times me-2"></i> Back
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<!-- Custom Styling -->
<style>
    .news-header {
        background-color: #f8f9fa;
        padding: 2rem 0;
        margin-bottom: 2rem;
        border-bottom: 1px solid #dee2e6;
    }

    .detail-container {
        background-color: transparent;
        padding: 1rem;
        border-radius: 0.25rem;
    }

    .detail-table {
        width: 100%;
    }

    .detail-table th,
    .detail-table td {
        padding: 12px;
        vertical-align: top;
        border-bottom: 1px solid #dee2e6;
    }

    .status-badge {
        padding: 0.35em 0.65em;
        border-radius: 0.25rem;
        font-weight: bold;
        display: inline-flex;
        align-items: center;
    }

    .status-active {
        background-color: #d4edda;
        color: #155724;
    }

    .status-inactive {
        background-color: #f8d7da;
        color: #721c24;
    }

    .news-image-container img,
    .content-section-image img {
        max-width: 100%;
        height: 300px;
        width: 300px;
        object-fit: cover;
        border-radius: 5px;
    }

    .info-label {
        font-weight: 600;
        color: #6c757d;
    }

    .content-section h3 {
        margin-bottom: 1rem;
    }

    .content-section-image {
        margin-top: 1rem;
    }
</style>
