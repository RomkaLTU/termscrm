@if (count($breadcrumbs))
    <div class="kt-subheader__breadcrumbs">
        <a href="{{ route('dashboard') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
        @foreach ($breadcrumbs as $breadcrumb)
            <span class="kt-subheader__breadcrumbs-separator"></span>
            @if ($breadcrumb->url && !$loop->last)
                <a href="{{ $breadcrumb->url }}" class="kt-subheader__breadcrumbs-link">{{ $breadcrumb->title }}</a>
            @else
                <span class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">{{ $breadcrumb->title }}</span>
            @endif
        @endforeach
    </div>
@endif
