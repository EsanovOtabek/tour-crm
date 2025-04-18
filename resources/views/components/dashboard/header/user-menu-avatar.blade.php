<div>
    <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" id="user-menu-button-2" aria-expanded="false" data-dropdown-toggle="dropdown-2">
      <span class="sr-only">Open user menu</span>
        @if (auth()->user()->picture)
            <img src="{{ asset('storage/' . auth()->user()->picture) }}" alt="Profile Picture" class="w-10 h-10 rounded-full">
        @endif
    </button>
  </div>
