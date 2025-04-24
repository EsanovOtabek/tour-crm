@extends('layouts.dashboard')
@section('title', "Admin Dashboard" )
@section('description', "Admin Dashboard" )

@section('content')

    <div
        class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="mb-4">
                <nav class="flex mb-5" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                        <li class="inline-flex items-center">
                            <a href="{{ route('admin.dashboard') }}"
                               class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                                <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                </svg>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                          d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                          clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500"
                                      aria-current="page">News</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                <div class="flex items-center mb-4 sm:mb-0">
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Yangiliklar</h1>
                </div>
                <button id="createNewsButton" class="admin-add-btn" type="button"
                        data-drawer-target="drawer-create-news-default" data-drawer-show="drawer-create-news-default"
                        aria-controls="drawer-create-news-default" data-drawer-placement="right">
                    Yangilik qo'shish
                </button>
            </div>
        </div>
    </div>
    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden shadow">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="p-2 text-white dark:text-gray-200">
                                T/r
                            </th>
                            <th scope="col"
                                class="p-2 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400 w-2/12">
                                Image
                            </th>
                            <th scope="col"
                                class="p-2 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400 w-3/12">
                                Title
                            </th>
                            <th scope="col"
                                class="p-2 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400 w-5/12">
                                Text
                            </th>
                            <th scope="col"
                                class="p-2 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                CRUD
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        @foreach($news as $n)

                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="w-4 p-2 text-base font-medium text-gray-900 dark:text-white">
                                    {{ $loop->index + 1 }}
                                </td>
                                <td class="p-2 text-base font-medium text-gray-900  dark:text-white">
                                    <img src="{{ asset('images/news/'.$n->image) }}" class="rounded w-full border"
                                         alt="">
                                </td>
                                <td class="p-2 text-base font-medium text-gray-900 dark:text-white">
                                    {{ $n->title }}
                                </td>

                                <td class="max-w-sm p-2 overflow-hidden text-base font-normal text-gray-600 xl:max-w-xs dark:text-gray-300">{{ $n->description }}</td>

                                <td class="p-2 space-x-2 whitespace-nowrap">
                                    <button type="button" id="updateNewsButton-{{ $n->id }}"
                                            onclick="editNews({{ $n->id }})"
                                            data-drawer-target="drawer-update-news-default"
                                            data-drawer-show="drawer-update-news-default"
                                            aria-controls="drawer-update-news-default" data-drawer-placement="right"
                                            class="admin-edit-btn">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path>
                                            <path fill-rule="evenodd"
                                                  d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                  clip-rule="evenodd"></path>
                                        </svg>
                                        Edit
                                    </button>

                                    <button type="button" id="deleteNewsButton-{{ $n->id }}"
                                            data-news-route="{{ route('admin.news') }}" data-news-id="{{$n->id}}"
                                            data-drawer-target="drawer-delete-news-default"
                                            data-drawer-show="drawer-delete-news-default"
                                            aria-controls="drawer-delete-news-default" data-drawer-placement="right"
                                            class="deleteNewsButton admin-delete-btn">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                  d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                  clip-rule="evenodd"></path>
                                        </svg>
                                        O'chirish
                                    </button>
                                </td>

                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit News Drawer -->
    @include('components.dashboard.include.edit-news')


    <!-- Delete News Drawer -->
    @include('components.dashboard.include.delete-news')

    <!-- Add News Drawer -->
    @include('components.dashboard.include.create-news')

    @push('scripts')
        <script>
            let allNews = @json($news);

            function editNews(newsID) {
                let news = allNews.find(item => item.id === newsID);
                document.getElementById('news_edit_title').value = news.title;
                document.getElementById('news_edit_description').value = news.description;
                const route = "{{ route('admin.news') }}/" + newsID;

                document.getElementById('editNewsForm').setAttribute('action', route);
            }
        </script>
    @endpush

@endsection

