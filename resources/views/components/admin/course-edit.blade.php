@extends('layouts.dashboard')
@section('title', $course->name . " kursini tahrirlash" )
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
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                          d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                          clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500">Kurslar</span>
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
                                <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">{{ $course->name }}kursini tahrirlash</span>
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
        <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Tahrirlash</h2>
        <form action="{{ route('admin.course.update', $course->id) }}" enctype="multipart/form-data" method="post">
            @csrf
            @method('put')
            <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3">
                <div class="sm:col-span-2 md:col-span-3">
                    <label for="name" class="e-label">Kurs nomi</label>
                    <input type="text" name="name" id="name" class="e-input" placeholder="Kurs nomi" required=""
                           value="{{ $course->name }}">
                </div>
                <div class="w-full">
                    <label for="slug" class="e-label">Kurs linki (slug)</label>
                    <input type="text" name="slug" id="slug" class="e-input" placeholder="slug" required=""
                           value="{{ $course->slug }}">
                </div>
                <div class="w-full">
                    <label for="author" class="e-label">Kurs muallifi</label>
                    <input type="text" name="author" id="author" class="e-input" placeholder="Muallif fio"
                           value="{{ $course->author }}">
                </div>
                <div class="w-full">
                    <label for="level" class="e-label">Kurs darajasi</label>
                    <input type="text" name="level" id="level" class="e-input" placeholder="Level"
                           value="{{ $course->level }}">
                </div>
                <div class="w-full">
                    <label for="price" class="e-label">Kursning narxi (so'mda)</label>
                    <input type="number" name="price" id="price" class="e-input" placeholder="so'm"
                           value="{{ $course->price }}">
                </div>
                <div class="w-full">
                    <label for="duration" class="e-label">Kursning davomiyligi (soatlarda)</label>
                    <input type="number" name="duration" id="duration" class="e-input" placeholder="soat"
                           value="{{ $course->duration }}">
                </div>
                <div class="w-full">
                    <label for="image" class="e-label">Kurs rasmi (.jpg or .png)</label>
                    <input type="file" name="image" id="image" class="e-file-input">
                </div>


                <div class="sm:col-span-2 md:col-span-3">
                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                    <textarea id="description" name="description" rows="12"
                              placeholder="Kurs haqida ma'lumot">{{ $course->description }}</textarea>
                </div>
            </div>
            <button type="submit"
                    class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                Saqlash
            </button>
        </form>

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


