<div>
    @if($showModal)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Reserve Seat #{{ $selectedSeatId }}</h5>
                        <button type="button" class="btn-close" wire:click="$set('showModal', false)"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="dateFrom" class="form-label">From</label>
                                <input type="date" id="dateFrom" class="form-control" wire:model.live="dateFrom">
                            </div>
                            <div class="col-md-6">
                                <label for="dateTo" class="form-label">To</label>
                                <input type="date" id="dateTo" class="form-control" wire:model.live="dateTo">
                            </div>
                        </div>
                        <hr>

                        <p>Days: {{ $reservationDays }}</p>

                        @switch($alertType)
                            @case('danger')
                                <div class="alert alert-danger" role="alert">
                                    {{ $alertMessage }}
                                </div>
                            @break
                            @case('success')
                                <div class="alert alert-success" role="alert">
                                    {{ $alertMessage }}
                                </div>
                            @break
                        @endswitch

                        @if($alertType === 'danger')
                            <div class="d-flex justify-content-end mt-3">
                                <button disabled class="btn btn-secondary">Confirm</button>
                            </div>
                        @else
                            <div class="d-flex justify-content-end mt-3">
                                <button class="btn btn-primary" wire:click="makeReservation">Confirm</button>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    @endif


    <div class="row g-3 mb-3">
        <div class="col-md-6">
            <label for="spaceSelect" class="form-label">Select Space</label>
            <select id="spaceSelect" class="form-select" wire:model.live="selectedSpace">
                @foreach($spaces as $index => $space)
                    <option value="{{ $index }}">{{ $space['name'] }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6">
            <label for="dateSelect" class="form-label">Select Date</label>
            <input type="date" id="dateSelect" class="form-control" wire:model.live="selectedDate">
        </div>
    </div>

    <div>
        @if(array_key_exists($selectedSpace, $spaces) && !empty($spaces[$selectedSpace]['layout']))
            @php
                $targetSpace = $spaces[$selectedSpace];

                $layout = $targetSpace['layout'];

                $cells = $layout['layout'];
                $cols = $layout['cols'];
                $rows = $layout['rows'];

                $grid = [];
                foreach ($layout['layout'] as $cell) {
                    $grid[$cell['row']][$cell['col']] = $cell;
                }

                // Index seats by their layout index (as string)
                $seats = collect($targetSpace['seats'])->keyBy('index');
            @endphp

            <div class="office-container" style="display: grid; grid-template-columns: repeat({{ $cols }}, 60px); grid-template-rows: repeat({{ $rows }}, 60px);">
                @for ($r = 0; $r < $rows; $r++)
                    @for ($c = 0; $c < $cols; $c++)
                        @php
                            $cell = $grid[$r][$c] ?? null;
                            $index = $r * $cols + $c;
                            $seat = $seats->get((string) $index);
                        @endphp
                        <div class="cell">
                            @if ($cell)
                                @switch($cell['type'])
                                    @case('chair')
                                        @php
                                            $isReserved = array_key_exists($seat['id'], $reservations);
                                            $reservedBy = $isReserved ? $reservations[$seat['id']]['user']['name'] : '';
                                            $isMine = $isReserved && $reservations[$seat['id']]['user_id'] === auth()->id();
                                            $chairClass = $isMine
                                                ? 'chair--mine'
                                                : ($isReserved ? 'chair--occupied' : 'chair--available');
                                        @endphp
                                        <div
                                            class="chair {{ $chairClass }}"
                                            title="{{ $isMine ? 'Your reservation' : ($isReserved ? 'Occupied by: '.$reservedBy : 'Available') }}"
                                            style="transform: rotate({{ $cell['rotation'] }}deg);"
                                            wire:click="openReservationModal({{ $seat['id'] }})"
                                        >
                                            <div class="seat"
                                                 style="transform: rotate({{ $cell['rotation'] == 180 ? 180 : 0 }}deg);">
                                                {{ $seat['id'] }}
                                            </div>
                                            <div class="backrest"></div>
                                            <div class="armrest-left"></div>
                                            <div class="armrest-right"></div>
                                        </div>
                                        @break

                                    @case('table')
                                        <div class="table" style="transform: rotate({{ $cell['rotation'] }}deg);"></div>
                                        @break

                                    @case('table-monitor')
                                        <div style="width: 100%; height: 100%; position: relative; transform: rotate({{ $cell['rotation'] }}deg);">
                                            <div class="table"></div>
                                            <div class="monitor"></div>
                                            <div class="keyboard"></div>
                                            <div class="mouse"></div>
                                        </div>
                                        @break
                                @endswitch
                            @endif
                        </div>
                    @endfor
                @endfor
            </div>

        @else
            <div class="alert alert-warning">
                Missing space or layout.
            </div>
        @endif
{{--        @dump($spaces[$selectedSpace])--}}
{{--        @dump($selectedDate)--}}
{{--        @dump($reservations)--}}
    </div>
</div>
