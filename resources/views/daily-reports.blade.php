@extends('layouts.dashboard')
@section('title', "Kunlik hisobotlar")
@section('description', "Kunlik hisobotlar boshqaruvi")

@section('content')
    <div class="px-4 pt-6 min-h-screen">
        <div class="px-3 py-1 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <!-- Card header -->
            <div class="items-center justify-between lg:flex">
                <div class="mb-4 lg:mb-0">
                    <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Kunlik hisobotlar</h3>
                    <div id="email-btn">
                        <button type="button" id="openEmailModal" class="admin-email-btn">
                            <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path></svg>
                            Email jo'natish
                        </button>

                    </div>
                </div>
                <div class="items-center sm:flex">
                    <!-- Date picker -->
                    <form action="{{ route('daily-reports.index') }}" method="GET" class="flex">
                        <input type="date" name="date" value="{{ $selectedDate->format('Y-m-d') }}" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        <button type="submit" class="ml-2 admin-add-btn">
                            Ko'rish
                        </button>
                    </form>

                </div>
            </div>

            <!-- Active bookings table -->
            <div class="flex flex-col mt-6">
                <div class="text-end mb-2">
                    <button onclick="exportToExcel()" class="admin-info-btn">Excel</button>
                    <button onclick="exportToPDF()" class="admin-delete-btn">PDF</button>
                </div>
                <div class="overflow-x-auto">
                    <div class="inline-block min-w-full align-middle">
                        <div class="overflow-hidden shadow">
                            <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600" id="report-div-table">
                                <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-3 py-1 w-10">
                                        <div class="flex items-center">
                                            <input id="selectAll" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="selectAll" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Tanlash</label>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-3 py-1 text-sm font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Sana
                                    </th>
                                    <th scope="col" class="px-3 py-1 text-sm font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Buyurtma kodi
                                    </th>
                                    <th scope="col" class="px-3 py-1 text-sm font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Tur kodi
                                    </th>
                                    <th scope="col" class="px-3 py-1 text-sm font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Tur nomi
                                    </th>
                                    <th scope="col" class="px-3 py-1 text-sm font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        PAX
                                    </th>
                                    <th scope="col" class="px-3 py-1 text-sm font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Git
                                    </th>
                                    <th scope="col" class="px-3 py-1 text-sm font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Hotel
                                    </th>
                                    <th scope="col" class="px-3 py-1 text-sm font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        City
                                    </th>
                                    <th scope="col" class="px-3 py-1 text-sm font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Muammo
                                    </th>
                                    <th scope="col" class="px-3 py-1 text-sm font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Yechim
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @forelse($activeBookings as $booking)
                                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <td class="px-3 py-1">
                                            <input type="checkbox" name="selected_bookings[]" value="{{ $booking->id }}" class="booking-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <span class="hidden">{{ $loop->index + 1 }}</span>
                                        </td>
                                        <td class="px-3 py-1 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $selectedDate->format('d.m.Y') }}
                                        </td>
                                        <td class="px-3 py-1 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $booking->unique_code }}
                                        </td>
                                        <td class="px-3 py-1 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $booking->tour->{'unique-code'} ?? 'N/A' }}
                                        </td>
                                        <td class="px-3 py-1 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $booking->tour->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-3 py-1 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $booking->groupMembers->count() ?? 'N/A' }}
                                        </td>
                                        <td class="px-3 py-1 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            @foreach($booking->guides as $guideBooking)
                                                @if($selectedDate->between($guideBooking->start_date, $guideBooking->end_date))
                                                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                                                        {{ $guideBooking->guide->name ?? 'N/A' }}
                                                    </span>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td class="px-3 py-1 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            @foreach($booking->details as $detail)
                                                @if(
                                                    $detail->objectItem->partnerObject->partner->type->name === 'Hotels' &&
                                                    $selectedDate->between($detail->start_date, $detail->end_date)
                                                )
                                                    <span class="bg-green-100 text-green-800 text-sm font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                                                        {{ $detail->objectItem->partnerObject->name ?? 'N/A' }}
                                                    </span>
                                                @endif
                                            @endforeach
                                        </td>

                                        <td class="px-3 py-1 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            @foreach($booking->details as $detail)
                                                @if(
                                                    $detail->objectItem->partnerObject->partner->type->name === 'Hotels' &&
                                                    $selectedDate->between($detail->start_date, $detail->end_date)
                                                )
                                                    <span class="bg-yellow-100 text-yellow-800 text-sm font-medium px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">
                                                        {{ $detail->objectItem->partnerObject->city->code ?? 'N/A' }}
                                                    </span>
                                                @endif
                                            @endforeach
                                        </td>

                                        <td class="px-3 py-1 text-sm font-medium text-gray-900 dark:text-white">
                                            <div class="max-h-32 overflow-y-auto">
                                                @foreach($booking->dailyReports->where('created_at', '>=', $selectedDate->startOfDay())->where('created_at', '<=', $selectedDate->copy()->endOfDay()) as $report)
                                                    <div class="mb-2 bg-gray-50 p-2 rounded dark:bg-gray-700">
                                                        <p class="text-xs mb-2">{{ $report->problem }}</p>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </td>

                                        <td class="px-3 py-1 text-sm font-medium text-gray-900 dark:text-white">
                                            <div class="max-h-32 overflow-y-auto">
                                                @foreach($booking->dailyReports->where('created_at', '>=', $selectedDate->startOfDay())->where('created_at', '<=', $selectedDate->copy()->endOfDay()) as $report)
                                                    <div class="mb-2 bg-gray-50 p-2 rounded dark:bg-gray-700">
                                                        <p class="text-xs">{{ $report->solve }}</p>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="px-3 py-4 text-sm text-center text-gray-500 dark:text-gray-400">
                                            Ushbu sana uchun faol buyurtmalar mavjud emas
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Hisobot qo'shish tugmasini o'zgartiramiz -->
                <div class="w-full mt-4 text-end hidden" id="report-btn">
                    <button type="button" id="openReportModal" class="ml-3 admin-add-btn">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                        Hisobot qo'shish
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal dialog for adding reports -->
    <div id="reportModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-gray-900 bg-opacity-50 flex items-center justify-center p-4">
        <div class="relative w-full max-w-2xl">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-700">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Kunlik hisobot qo'shish
                    </h3>
                    <button type="button" id="closeModal" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-700 dark:hover:text-white">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <form action="{{ route('daily-reports.store') }}" method="POST" id="reportForm">
                        @csrf
                        <input type="hidden" name="date" value="{{ $selectedDate->format('Y-m-d') }}">

                        <div class="grid grid-cols-1  gap-6 mb-6 ">
                            <div class="h-48 overflow-y-auto border border-gray-300 rounded-lg p-3 dark:border-gray-600 hidden">
                                <h4 class="text-sm font-semibold mb-2 text-gray-900 dark:text-white">Buyurtmalar:</h4>
                                <ul class="space-y-2">
                                    @forelse($activeBookings as $booking)
                                        <li class="flex items-center">
                                            <input type="checkbox" name="selected_bookings[]" value="{{ $booking->id }}" id="booking-{{ $booking->id }}" class="modal-booking-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="booking-{{ $booking->id }}" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                {{ $booking->unique_code }} - {{ $booking->tour->name ?? 'N/A' }}
                                            </label>
                                        </li>
                                    @empty
                                        <li class="text-sm text-gray-500 dark:text-gray-400">
                                            Ushbu sana uchun faol buyurtmalar mavjud emas
                                        </li>
                                    @endforelse
                                </ul>
                            </div>

                            <div>
                                <div class="mb-4">
                                    <label for="modalProblem" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Muammo</label>
                                    <textarea id="modalProblem" name="problem" rows="4" class="e-input" placeholder="Muammoni kiriting...">ALL Good!</textarea>
                                </div>
                                <div>
                                    <label for="modalSolve" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Yechim</label>
                                    <textarea id="modalSolve" name="solve" rows="4" class="e-input" placeholder="Yechimni kiriting..."></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center justify-end p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-700">
                    <button type="button" id="cancelModal" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                        Bekor qilish
                    </button>
                    <button type="submit" form="reportForm" id="submitReportBtn" class="admin-add-btn">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                        Hisobot qo'shish
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Email Modal -->
    <div id="emailModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-gray-900 bg-opacity-50 flex items-center justify-center p-4">
        <div class="relative w-full max-w-4xl">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-700">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Email jo'natish
                    </h3>
                    <button type="button" id="closeEmailModal" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-700 dark:hover:text-white">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <form action="{{ route('daily-reports.send-emails') }}" method="POST" id="emailForm">
                        @csrf
                        <input type="hidden" name="date" value="{{ $selectedDate->format('Y-m-d') }}">

                        <h4 class="text-sm font-semibold mb-4 text-gray-900 dark:text-white">Agentlar:</h4>
                        <div class="overflow-y-auto max-h-64">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-4 py-3">Tanlash</th>
                                    <th scope="col" class="px-4 py-3">Ism</th>
                                    <th scope="col" class="px-4 py-3">Email</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($agents as $agent)
                                    <tr class="border-b dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <td class="px-4 py-3">
                                            <input type="checkbox" name="recipients[]" value="{{ $agent['email'] }}" checked class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        </td>
                                        <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $agent['name'] }}
                                        </td>
                                        <td class="px-4 py-3">
                                            <input type="email" name="agent_emails[{{ $agent['id'] }}]" value="{{ $agent['email'] }}" class="e-input text-sm p-2">
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center justify-end p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-700">
                    <button type="button" id="cancelEmailModal" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                        Bekor qilish
                    </button>
                    <button type="submit" form="emailForm" class="admin-email-btn">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path></svg>
                        Email jo'natish
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('reportModal');
            const openModalBtn = document.getElementById('openReportModal');
            const closeModalBtn = document.getElementById('closeModal');
            const cancelModalBtn = document.getElementById('cancelModal');
            const reportBtn = document.getElementById('report-btn');
            const tableCheckboxes = document.querySelectorAll('.booking-checkbox');
            const selectAllCheckbox = document.getElementById('selectAll');
            const modalBookingCheckboxes = document.querySelectorAll('.modal-booking-checkbox');
            const submitReportBtn = document.getElementById('submitReportBtn');

            // Jadvaldagi checkboxlarni kuzatish
            function handleTableCheckboxChange() {
                const checkedCount = [...tableCheckboxes].filter(cb => cb.checked).length;

                // Agar kamida bitta checkbox tanlangan bo'lsa, hisobot tugmasini ko'rsatamiz
                if (checkedCount > 0) {
                    reportBtn.classList.remove('hidden');
                } else {
                    reportBtn.classList.add('hidden');
                }

                // Select All holatini yangilaymiz
                selectAllCheckbox.checked = checkedCount === tableCheckboxes.length && tableCheckboxes.length > 0;
                selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < tableCheckboxes.length;
            }

            // Jadvaldagi har bir checkbox uchun hodisani qo'shamiz
            tableCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', handleTableCheckboxChange);
            });

            // Select All checkboxi uchun hodisa
            selectAllCheckbox.addEventListener('change', function() {
                tableCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                handleTableCheckboxChange();
            });

            // Modalni ochish
            openModalBtn.addEventListener('click', function() {
                const checkedBoxes = [...tableCheckboxes].filter(cb => cb.checked);

                // Agar hech narsa tanlanmagan bo'lsa, modalni ochmaymiz
                if (checkedBoxes.length === 0) {
                    alert('Iltimos, kamida bitta buyurtmani tanlang!');
                    return;
                }

                // Modal ichidagi checkboxlarni yangilaymiz
                modalBookingCheckboxes.forEach(modalCb => {
                    const correspondingCb = [...tableCheckboxes].find(
                        tableCb => tableCb.value === modalCb.value
                    );
                    if (correspondingCb) {
                        modalCb.checked = correspondingCb.checked;
                    }
                });

                // Modalni ko'rsatamiz
                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            });

            // Modalni yopish
            function hideModal() {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            closeModalBtn.addEventListener('click', hideModal);
            cancelModalBtn.addEventListener('click', hideModal);

            // Modal tashqarisiga bosganda yopish
            modal.addEventListener('click', function(event) {
                if (event.target === modal) {
                    hideModal();
                }
            });


            // Formani yuborishdan oldin tekshirish
            document.getElementById('reportForm').addEventListener('submit', function(e) {
                const checkedCount = [...modalBookingCheckboxes].filter(cb => cb.checked).length;

                if (checkedCount === 0) {
                    e.preventDefault();
                    alert('Iltimos, kamida bitta buyurtmani tanlang!');
                }
            });

            // Dastlabki holatni yangilaymiz
            handleTableCheckboxChange();
        });

        document.addEventListener('DOMContentLoaded', function() {
            const emailModal = document.getElementById('emailModal');
            const openEmailModalBtn = document.getElementById('openEmailModal');
            const closeEmailModalBtn = document.getElementById('closeEmailModal');
            const cancelEmailModalBtn = document.getElementById('cancelEmailModal');

            // Modalni ochish
            openEmailModalBtn.addEventListener('click', function() {
                emailModal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            });

            // Modalni yopish
            function hideEmailModal() {
                emailModal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            closeEmailModalBtn.addEventListener('click', hideEmailModal);
            cancelEmailModalBtn.addEventListener('click', hideEmailModal);

            // Modal tashqarisiga bosganda yopish
            emailModal.addEventListener('click', function(event) {
                if (event.target === emailModal) {
                    hideEmailModal();
                }
            });

            // Email formani yuborishdan oldin tekshirish
            document.getElementById('emailForm').addEventListener('submit', function(e) {
                const checkedCount = document.querySelectorAll('input[name="recipients[]"]:checked').length;

                if (checkedCount === 0) {
                    e.preventDefault();
                    alert('Iltimos, kamida bitta qabul qiluvchini tanlang!');
                }
            });
        });

        function exportToExcel() {
            let wb = XLSX.utils.table_to_book(document.getElementById("report-div-table"), { sheet: "Sheet1" });
            XLSX.writeFile(wb, "jadval.xlsx");
        }

        function exportToPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();
            doc.autoTable({ html: "#report-div-table" });
            doc.save("jadval.pdf");
        }

    </script>
@endpush
