
@props(['path' => '', 'content' => '', 'active' => false])

<a href="{{ $path }}"
   class="flex items-center p-2 text-base text-gray-900 rounded-lg hover:bg-gray-100 group dark:text-gray-200 dark:hover:bg-gray-700
          {{ $active ? 'bg-gray-100 dark:bg-gray-700 text-blue-600 dark:text-blue-400' : '' }}">
    {{ $slot }}
    @if($content)
        <span class="ml-3" sidebar-toggle-item>{{ $content }}</span>
    @endif
</a>
