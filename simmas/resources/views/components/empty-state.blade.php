@props(['title' => 'Tidak ada data', 'description' => null, 'actionHref' => null, 'actionLabel' => null])

<div class="text-center py-10">
    <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor"><path d="M3 4a1 1 0 011-1h16a1 1 0 011 1v14a3 3 0 01-3 3H6a3 3 0 01-3-3V4z"/></svg>
    <h3 class="mt-2 text-sm font-semibold text-gray-900">{{ $title }}</h3>
    @if($description)
        <p class="mt-1 text-sm text-gray-500">{{ $description }}</p>
    @endif
    @if($actionHref && $actionLabel)
        <div class="mt-6">
            <a href="{{ $actionHref }}" class="inline-flex items-center px-3 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">{{ $actionLabel }}</a>
        </div>
    @endif
</div>
