<?php

namespace App\Livewire\Reservation;

use App\Data\ReservationCreateData;
use App\Data\SpaceData;
use Carbon\Carbon;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;

class SeatReservation extends Component
{
    use SeatReservationHelper;

    public array $spaces;
    public int|string|null $selectedSpace = 0;
    public string $selectedDate;
    public string $dateFrom;
    public string $dateTo;

    public int $reservationDays = 1;

    public array $reservations;
    public bool $showModal = false;
    public ?int $selectedSeatId = null;

    protected bool $canReserve = false;

    public function mount(): void
    {
        $this->initDates();
        $this->loadData();
        $this->loadReservations();
    }

    public function render(): View
    {
        return view('reservation.livewire.seat-reservation');
    }

    public function updatedSelectedSpace(): void
    {
        $this->loadReservations();
    }

    public function updatedSelectedDate(): void
    {
        $this->loadReservations();

        $this->dateTo = $this->selectedDate;
        $this->dateFrom = $this->selectedDate;
    }

    public function updatedDateFrom(): void
    {
        $this->checkAvailability();
    }

    public function updatedDateTo(): void
    {
        $this->checkAvailability();
    }

    public function openReservationModal(int $seatId): void
    {
        if (array_key_exists($seatId, $this->reservations)) {
            return;
        }

        $this->selectedSeatId = $seatId;
        $this->checkAvailability();
        $this->showModal = true;
    }

    protected function loadData(): void
    {
        $this->loadSpaceData();
    }

    protected function loadSpaceData(): void
    {
        $this->spaces = collect($this->getSpaceService()->findAll())
            ->map(fn(SpaceData $dto) => $dto->toArray())
            ->all();
    }

    public function makeReservation(): Redirector
    {
        $this->checkAvailability();

        $reservationCreateTransfer = new ReservationCreateData(
            userId: auth()->id(),
            spaceId: $this->spaces[$this->selectedSpace]['id'],
            seatId: $this->selectedSeatId,
            fromDate: $this->dateFrom,
            toDate: $this->dateTo,
        );

        $this->getReservationService()
            ->createReservation($reservationCreateTransfer);

        session()->flash('success', 'Reservation created successfully!');

        return redirect()->route('reservation.index');
    }

    protected function loadReservations(): void
    {
        $spaceId = $this->spaces[$this->selectedSpace]['id'];

        $reservations = $this->getReservationService()
            ->getReservationsBySpaceAndDate($spaceId, $this->selectedDate);

        $this->reservations = collect($reservations)->keyBy('seat_id')->all();
    }

    protected function checkAvailability(): void
    {
        $this->resetAlert();

        $from = Carbon::parse($this->dateFrom);
        $to = Carbon::parse($this->dateTo);
        $today = Carbon::today();

        // Validate: dates must not be in the past and from <= to
        if ($from->lt($today) || $to->lt($today)) {
            $this->showDangerAlert('Reservation dates cannot be in the past.');
            return;
        }

        if ($from->gt($to)) {
            $this->showDangerAlert('"From" date cannot be after "To" date.');
            return;
        }

        // Calculate reservation days (inclusive)
        $this->reservationDays = $from->diffInDays($to) + 1;

        // Check seat availability
        $reservationConflicts = $this->getReservationService()
            ->getReservationConflicts(
                $this->selectedSeatId,
                $this->dateFrom,
                $this->dateTo,
            );

        if (empty($reservationConflicts)) {
            $this->showSuccessAlert();
            $this->canReserve = true;
        } else {
            $this->showDangerAlert('Reservation has conflicts.');
        }
    }

    protected function initDates(): void
    {
        $this->selectedDate = Carbon::today()->toDateString();
        $this->dateTo  = Carbon::today()->toDateString();
        $this->dateFrom  = Carbon::today()->toDateString();
    }
}
