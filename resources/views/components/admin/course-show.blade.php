@extends('layouts.dashboard')
@section('title', "Course add" )
@push('styles')
    @vite('resources/css/ckeditor.css')
@endpush
@section('content')

    <div class="px-4 py-6 block sm:flex items-center justify-between lg:mt-1.5 dark:bg-gray-900 ">
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
                                <a href="{{ route('admin.course.index') }}"
                                   class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                              d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                              clip-rule="evenodd"></path>
                                    </svg>
                                    Kurslar
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                          d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                          clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">Kurs qo'shish</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                <div class="flex items-center mb-4 sm:mb-0">
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Kurslar</h1>
                </div>
                <a href="{{ route('admin.course.index') }}" class="admin-add-btn">
                    Barcha kurslar
                </a>
            </div>
        </div>
    </div>
    <div
        class="p-4 mx-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
        <div class="w-full ">
            <div class="grid grid-cols-3 gap-x-12 gap-y-8 mx-auto">
                <div class="col-span-3">
                    <h1 class="mb-3 text-xl font-bold leading-tight text-primary-950 lg:mb-4 lg:text-3xl dark:text-white">
                        {{ $course->name }}
                    </h1>
                </div>
                <div class="order-2 md:order-1 col-span-3 md:col-span-2">
                    <div class="grid grid-cols-2 text-xl text-gray-950 dark:text-gray-50 pb-4 border-b-2">
                        <div class="col-span-1"><b>Davomiyligi:</b> {{ $course->duration }} soat</div>
                        <div class="col-span-1"><b>Qiyinchiligi:</b> {{ $course->level }}</div>
                    </div>

                    <article class="prose lg:prose-xl dark:prose-invert ">
                        {!! $course->description !!}
                    </article>

                </div>

                <div class="order-1 md:order-2 col-span-3 md:col-span-1">
                    <div id="summary"
                         class="sticky top-0 ring-1 p-4 ring-gray-800 rounded-lg bg-gray-50 dark:bg-gray-800 border border-gray-100 dark:border-gray-500">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-950 dark:text-white mb-4">
                                @if(is_null($course->price) or $course->price == 0)
                                    Bepul
                                @else
                                    Narxi: {{ $course->price }} so'm
                                @endif
                            </h2>
                            <img class="h-56 w-full object-cover rounded-md"
                                 src="{{ asset('images/courses/'.$course->image) }}" alt=""/>

                            <div class="pt-1 mt-3">
                                <h3 class="text-xl mb-1 font-bold leading-tight text-gray-900 hover:underline dark:text-white">{{ $course->name }}</h3>
                                <span class="text inline-block text-gray-800 dark:text-gray-100"><b>Muallif:</b> {{ $course->author }}</span>
                                <div class="mt-4 flex items-center gap-2">
                                    <div class="flex items-center">
                                        <svg class="h-4 w-4 text-yellow-400" aria-hidden="true"
                                             xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                                        </svg>

                                        <svg class="h-4 w-4 text-yellow-400" aria-hidden="true"
                                             xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                                        </svg>

                                        <svg class="h-4 w-4 text-yellow-400" aria-hidden="true"
                                             xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                                        </svg>

                                        <svg class="h-4 w-4 text-yellow-400" aria-hidden="true"
                                             xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                                        </svg>

                                        <svg class="h-4 w-4 text-yellow-400" aria-hidden="true"
                                             xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                                        </svg>
                                    </div>

                                    <p class="text-sm font-medium text-gray-900 dark:text-white">5.0</p>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">(455)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('editor/build/ckeditor.js') }}"></script>

    <script type="text/javascript">
        ClassicEditor
            .create(document.querySelector('#description'))
            .catch(error => {
                console.error(error);
            });

    </script>

@endpush


