@extends('layouts.dashboard')
@section('title', "Buyurtma Nusxalash")
@section('description', "Buyurtma ma'lumotlarini nusxalash")

@section('content')
    <div class="px-4 pt-6 min-h-screen">
        <div class="p-4 rounded-lg shadow-sm sm:p-6">
            <form action="{{ route('bookings.store.copy') }}" method="POST">
                @csrf

                <!-- Booking Info Card -->
                <div class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mb-6">
                    <div class="p-5">
                        <h5 class="mb-4 text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                            Buyurtma #{{ $booking->id }} dan nusxalash
                        </h5>

                        <div class="grid gap-4 mb-4 sm:grid-cols-3">
                            <!-- Tour -->
                            <div>
                                <label for="tour_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tur</label>
                                <select name="tour_id" id="tour_id" class="e-input" required>
                                    <option value="">Turni tanlang</option>
                                    @foreach($tours as $tour)
                                        <option value="{{ $tour->id }}" {{ $booking->tour_id == $tour->id ? 'selected' : '' }}>
                                            {{ $tour->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Holat</label>
                                <select name="status" id="status" class="e-input" required>
                                    <option value="draft" {{ $booking->status == 'draft' ? 'selected' : '' }}>Qoralama</option>
                                    <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Tasdiqlangan</option>
                                    <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Bekor qilingan</option>
                                </select>
                            </div>

                            <!-- Price -->
                            <div>
                                <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Narx</label>
                                <input type="number" name="price" id="price" class="e-input"
                                       value="{{ $booking->price }}" required step="0.01">
                            </div>

                            <!-- Unique Code -->
                            <div>
                                <label for="unique_code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Maxsus kod</label>
                                <input type="text" name="unique_code" id="unique_code" class="e-input"
                                       value="{{ $booking->unique_code }}">
                                <input value="{{ $booking->id }}" name="old_booking_id" hidden="">
                            </div>

                            <!-- Dates -->
                            <div>
                                <label for="start_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Boshlanish sanasi</label>
                                <input type="date" name="start_date" id="start_date" class="e-input"
                                       value="{{ now()->format('Y-m-d') }}" required>
                            </div>

                            <div>
                                <label for="end_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tugash sanasi</label>
                                <input type="date" name="end_date" id="end_date" class="e-input"
                                       value="{{ now()->addDays($booking->start_date->diffInDays($booking->end_date))->format('Y-m-d') }}" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Details Section -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-4">Detallar</h3>

                    @foreach($originalDetails as $index => $detail)
                        <div class="bg-white border relative rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mb-4 p-4 border-primary-500">
                            <input type="hidden" name="details[{{ $index }}][id]" value="{{ $detail->id }}">

                            <div class="grid gap-4 sm:grid-cols-3">
                                <!-- Partner TYPE -->
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" >Partner type</label>
                                    <select name="partner_type" id="partner_type_{{$detail->id}}" class="e-input">
                                        <option selected disabled value="">-- Partner Type --</option>
                                        @foreach($partnerTypes as $type)
                                            <option value="{{$type->id}}" @selected($type->id == $detail->objectItem->partnerObject->partner->type_id )>{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Partners -->
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Partner</label>
                                    <select name="partner" id="partner_{{$detail->id}}" class="e-input">
                                        <option selected disabled value="">-- Partner --</option>
                                        @foreach($partners as $partner)
                                            <option value="{{$partner->id}}" @selected($partner->id == $detail->objectItem->partnerObject->partner_id)>{{ $partner->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Partner Objects -->
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Partner Object</label>
                                    <select name="partner_object" id="partner_object_{{$detail->id}}" class="e-input">
                                        <option selected disabled value="">-- Partner Object--</option>
                                        @foreach($partnerObjects as $obj)
                                            <option value="{{$obj->id}}" @selected($obj->id == $detail->objectItem->partner_object_id )>{{ $obj->name }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Xizmat/Obyekt</label>
                                    <select name="details[{{ $index }}][object_item_id]" class="e-input object-item-select" required>
                                        <option value="">Xizmat/Obyektni tanlang</option>
                                        @foreach($objectItems as $item)
                                            <option value="{{ $item->id }}"
                                                    {{ $detail->object_item_id == $item->id ? 'selected' : '' }}
                                                    data-price="{{ $item->sale_price }}"
                                                    data-cost="{{ $item->price }}">
                                                {{ $item->name }} ({{ number_format($item->sale_price, 2) }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Quantity -->
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Soni</label>
                                    <input type="number" name="details[{{ $index }}][quantity]"
                                           class="e-input calculate-price" value="{{ $detail->quantity }}"
                                           min="1" required>
                                </div>

                                <!-- Price -->
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Narx</label>
                                    <input type="number" name="details[{{ $index }}][price]"
                                           class="e-input price-field" value="{{ $detail->price }}"
                                           readonly step="0.01">
                                </div>

                                <!-- Cost Price -->
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tannarx</label>
                                    <input type="number" name="details[{{ $index }}][cost_price]"
                                           class="e-input cost-price-field" value="{{ $detail->cost_price }}"
                                           readonly step="0.01">
                                </div>

                                <!-- Dates -->
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Boshlanish sanasi</label>
                                    <input type="date" name="details[{{ $index }}][start_date]"
                                           class="e-input" value="{{ $detail->start_date->format('Y-m-d') }}" required>
                                </div>

                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tugash sanasi</label>
                                    <input type="date" name="details[{{ $index }}][end_date]"
                                           class="e-input" value="{{ $detail->end_date->format('Y-m-d') }}" required>
                                </div>

                                <!-- Comment -->
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Izoh</label>
                                    <textarea name="details[{{ $index }}][comment]" class="e-input">{{ $detail->comment }}</textarea>
                                </div>

                                <!-- Remove button -->
                                <div class="absolute bottom-2 right-3">
                                    <button type="button" class="admin-delete-btn remove-detail-btn"> Olib tashlash</button>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <button type="button" id="add-detail-btn" class="admin-add-btn">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                        </svg>
                        Detal qo'shish
                    </button>
                </div>

                <!-- Mashruts Section -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-4">Mashrutlar</h3>

                    @foreach($originalMashruts as $index => $mashrut)
                        <div class="bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mb-4 p-4 relative">
                            <input type="hidden" name="mashruts[{{ $index }}][id]" value="{{ $mashrut->id }}">

                            <div class="grid gap-4 sm:grid-cols-3">
                                <!-- Tour City -->
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Shahar</label>
                                    <select name="mashruts[{{ $index }}][tour_city_id]" class="e-input" required>
                                        <option value="">Shaharni tanlang</option>
                                        @foreach($tourCities as $city)
                                            <option value="{{ $city->id }}" {{ $mashrut->tour_city_id == $city->id ? 'selected' : '' }}>
                                                {{ $city->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Date Time -->
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sana va vaqt</label>
                                    <input type="datetime-local" name="mashruts[{{ $index }}][date_time]"
                                           class="e-input" value="{{ $mashrut->date_time->format('Y-m-d\TH:i') }}" required>
                                </div>

                                <!-- Order No -->
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tartib raqami</label>
                                    <input type="number" name="mashruts[{{ $index }}][order_no]"
                                           class="e-input" value="{{ $mashrut->order_no }}" min="1">
                                </div>

                                <!-- Program -->
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dastur</label>
                                    <textarea name="mashruts[{{ $index }}][program]" class="e-input">{{ $mashrut->program }}</textarea>
                                </div>


                                <div class="absolute bottom-2 right-3">
                                    <button type="button" class="admin-delete-btn remove-mashrut-btn">Olib tashlash</button>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <button type="button" id="add-mashrut-btn" class="admin-add-btn">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                        </svg>
                        Mashrut qo'shish
                    </button>
                </div>

                <!-- Submit buttons -->
                <div class="flex justify-end space-x-4">
                    <button type="submit" class="admin-add-btn">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                        </svg>
                        Nusxalash
                    </button>
                    <a href="{{ route('bookings.index') }}" class="admin-cancel-btn">
                        Bekor qilish
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize all existing cascading selects
            initializeCascadingSelects();

            // Calculate price when object item or quantity changes
            document.querySelectorAll('.object-item-select, .calculate-price').forEach(element => {
                element.addEventListener('change', function() {
                    calculatePrice(this);
                });
            });

            // Remove detail button
            document.querySelectorAll('.remove-detail-btn').forEach(button => {
                button.addEventListener('click', function() {
                    if (confirm('Ushbu detalni o\'chirmoqchimisiz?')) {
                        this.closest('.bg-white').remove();
                    }
                });
            });

            // Remove mashrut button
            document.querySelectorAll('.remove-mashrut-btn').forEach(button => {
                button.addEventListener('click', function() {
                    if (confirm('Ushbu mashrutni o\'chirmoqchimisiz?')) {
                        this.closest('.bg-white').remove();
                    }
                });
            });

            // Add new detail
            let detailIndex = {{ count($originalDetails) }};
            document.getElementById('add-detail-btn').addEventListener('click', function() {
                const newDetailId = 'new_' + Date.now();
                const template = `
        <div class="bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mb-4 p-4 relative">
            <div class="grid gap-4 sm:grid-cols-3">
                <!-- Partner TYPE -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Partner type</label>
                    <select name="partner_type" id="partner_type_${newDetailId}" class="e-input">
                        <option selected disabled value="">-- Partner Type --</option>
                        @foreach($partnerTypes as $type)
                <option value="{{$type->id}}">{{ $type->name }}</option>
                        @endforeach
                </select>
            </div>

            <!-- Partners -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Partner</label>
                <select name="partner" id="partner_${newDetailId}" class="e-input">
                        <option selected disabled value="">-- Partner --</option>
                    </select>
                </div>

                <!-- Partner Objects -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Partner Object</label>
                    <select name="partner_object" id="partner_object_${newDetailId}" class="e-input">
                        <option selected disabled value="">-- Partner Object--</option>
                    </select>
                </div>

                <!-- Object Item -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Xizmat/Obyekt</label>
                    <select name="details[${detailIndex}][object_item_id]" id="object_item_${newDetailId}" class="e-input object-item-select" required>
                        <option value="">Xizmat/Obyektni tanlang</option>
                    </select>
                </div>

                <!-- Quantity -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Soni</label>
                    <input type="number" name="details[${detailIndex}][quantity]"
                           class="e-input calculate-price" value="1"
                           min="1" required>
                </div>

                <!-- Price -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Narx</label>
                    <input type="number" name="details[${detailIndex}][price]"
                           class="e-input price-field" value="0.00"
                           readonly step="0.01">
                </div>

                <!-- Cost Price -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tannarx</label>
                    <input type="number" name="details[${detailIndex}][cost_price]"
                           class="e-input cost-price-field" value="0.00"
                           readonly step="0.01">
                </div>

                <!-- Dates -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Boshlanish sanasi</label>
                    <input type="date" name="details[${detailIndex}][start_date]"
                           class="e-input" value="{{ now()->format('Y-m-d') }}" required>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tugash sanasi</label>
                    <input type="date" name="details[${detailIndex}][end_date]"
                           class="e-input" value="{{ now()->format('Y-m-d') }}" required>
                </div>

                <!-- Comment -->
                <div class="sm:col-span-2">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Izoh</label>
                    <textarea name="details[${detailIndex}][comment]" class="e-input"></textarea>
                </div>

                <!-- Remove button -->
                <div class="absolute bottom-2 right-3">
                    <button type="button" class="admin-delete-btn remove-detail-btn">Olib tashlash</button>
                </div>
            </div>
        </div>
        `;

                document.querySelector('#add-detail-btn').insertAdjacentHTML('beforebegin', template);

                // Initialize cascading selects for the new detail
                initializeCascadingSelects(newDetailId);

                // Attach event listeners to the new elements
                const newDetail = document.querySelector('#add-detail-btn').previousElementSibling;
                newDetail.querySelector('.object-item-select').addEventListener('change', function() {
                    calculatePrice(this);
                });
                newDetail.querySelector('.calculate-price').addEventListener('input', function() {
                    calculatePrice(this);
                });
                newDetail.querySelector('.remove-detail-btn').addEventListener('click', function() {
                    if (confirm('Ushbu detalni o\'chirmoqchimisiz?')) {
                        this.closest('.bg-white').remove();
                    }
                });

                detailIndex++;
            });

            // Add new mashrut
            let mashrutIndex = {{ count($originalMashruts) }};
            document.getElementById('add-mashrut-btn').addEventListener('click', function() {
                const template = `
        <div class="bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mb-4 p-4 relative">
            <div class="grid gap-4 sm:grid-cols-3">
                <!-- Tour City -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Shahar</label>
                    <select name="mashruts[${mashrutIndex}][tour_city_id]" class="e-input" required>
                        <option value="">Shaharni tanlang</option>
                        @foreach($tourCities as $city)
                <option value="{{ $city->id }}">
                                {{ $city->name }}
                </option>
@endforeach
                </select>
            </div>

            <!-- Date Time -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sana va vaqt</label>
                <input type="datetime-local" name="mashruts[${mashrutIndex}][date_time]"
                           class="e-input" value="{{ now()->format('Y-m-d\TH:i') }}" required>
                </div>

                <!-- Program -->
                <div class="sm:col-span-2">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dastur</label>
                    <textarea name="mashruts[${mashrutIndex}][program]" class="e-input"></textarea>
                </div>

                <!-- Order No -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tartib raqami</label>
                    <input type="number" name="mashruts[${mashrutIndex}][order_no]"
                           class="e-input" value="${mashrutIndex + 1}" min="1">
                </div>

                <!-- Remove button -->
                <div class="absolute bottom-2 right-3">
                    <button type="button" class="admin-delete-btn remove-mashrut-btn">Olib tashlash</button>
                </div>
            </div>
        </div>
        `;

                document.querySelector('#add-mashrut-btn').insertAdjacentHTML('beforebegin', template);
                mashrutIndex++;

                // Attach event listener to the new remove button
                const newMashrut = document.querySelector('#add-mashrut-btn').previousElementSibling;
                newMashrut.querySelector('.remove-mashrut-btn').addEventListener('click', function() {
                    if (confirm('Ushbu mashrutni o\'chirmoqchimisiz?')) {
                        this.closest('.bg-white').remove();
                    }
                });
            });

            // Function to initialize cascading selects
            function initializeCascadingSelects(detailId = null) {
                // If detailId is not provided, initialize all existing ones
                if (!detailId) {
                    document.querySelectorAll('[id^="partner_type_"]').forEach(select => {
                        const idParts = select.id.split('_');
                        const currentDetailId = idParts.slice(2).join('_');
                        setupCascadingSelects(currentDetailId);
                    });
                } else {
                    setupCascadingSelects(detailId);
                }
            }

            // Function to setup cascading selects for a specific detail
            function setupCascadingSelects(detailId) {
                const partnerTypeSelect = document.getElementById(`partner_type_${detailId}`);
                const partnerSelect = document.getElementById(`partner_${detailId}`);
                const partnerObjectSelect = document.getElementById(`partner_object_${detailId}`);
                const objectItemSelect = document.getElementById(`object_item_${detailId}`) ||
                    document.querySelector(`[name="details[${detailId}][object_item_id]"]`);

                if (partnerTypeSelect && partnerSelect && partnerObjectSelect && objectItemSelect) {
                    // Partner Type change handler
                    partnerTypeSelect.addEventListener('change', function() {
                        const typeId = this.value;
                        partnerSelect.innerHTML = '<option selected disabled value="">-- Partner --</option>';
                        partnerObjectSelect.innerHTML = '<option selected disabled value="">-- Partner Object--</option>';
                        objectItemSelect.innerHTML = '<option value="">Xizmat/Obyektni tanlang</option>';

                        if (typeId) {
                            fetch(`/api/partners?type_id=${typeId}`)
                                .then(response => response.json())
                                .then(data => {
                                    data.forEach(partner => {
                                        const option = document.createElement('option');
                                        option.value = partner.id;
                                        option.textContent = partner.name;
                                        partnerSelect.appendChild(option);
                                    });
                                });
                        }
                    });

                    // Partner change handler
                    partnerSelect.addEventListener('change', function() {
                        const partnerId = this.value;
                        partnerObjectSelect.innerHTML = '<option selected disabled value="">-- Partner Object--</option>';
                        objectItemSelect.innerHTML = '<option value="">Xizmat/Obyektni tanlang</option>';

                        if (partnerId) {
                            fetch(`/api/partner-objects?partner_id=${partnerId}`)
                                .then(response => response.json())
                                .then(data => {
                                    data.forEach(obj => {
                                        const option = document.createElement('option');
                                        option.value = obj.id;
                                        option.textContent = obj.name;
                                        partnerObjectSelect.appendChild(option);
                                    });
                                });
                        }
                    });

                    // Partner Object change handler
                    partnerObjectSelect.addEventListener('change', function() {
                        const objectId = this.value;
                        objectItemSelect.innerHTML = '<option value="">Xizmat/Obyektni tanlang</option>';

                        if (objectId) {
                            fetch(`/api/object-items?object_id=${objectId}`)
                                .then(response => response.json())
                                .then(data => {
                                    data.forEach(item => {
                                        const option = document.createElement('option');
                                        option.value = item.id;
                                        option.textContent = `${item.name} (${parseFloat(item.sale_price).toFixed(2)})`;
                                        option.dataset.price = item.sale_price;
                                        option.dataset.cost = item.price;
                                        objectItemSelect.appendChild(option);
                                    });
                                });
                        }
                    });
                }
            }

            // Function to calculate price
            function calculatePrice(element) {
                const container = element.closest('.grid');
                if (!container) return;

                const objectItemSelect = container.querySelector('.object-item-select');
                const quantityInput = container.querySelector('.calculate-price');
                const priceInput = container.querySelector('.price-field');
                const costPriceInput = container.querySelector('.cost-price-field');

                if (objectItemSelect && quantityInput && priceInput && costPriceInput) {
                    const selectedOption = objectItemSelect.options[objectItemSelect.selectedIndex];
                    const quantity = parseInt(quantityInput.value) || 1;

                    if (selectedOption && selectedOption.value) {
                        const price = parseFloat(selectedOption.dataset.price) * quantity;
                        const cost = parseFloat(selectedOption.dataset.cost) * quantity;

                        priceInput.value = price.toFixed(2);
                        costPriceInput.value = cost.toFixed(2);
                    }
                }
            }
        });
    </script>
@endpush
