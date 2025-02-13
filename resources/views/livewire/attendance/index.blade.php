<?php

use Livewire\Volt\Component;
use Mary\Traits\Toast;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    use Toast;
    public string $search = '';
    public bool $drawer = false;
    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];
    public $latitude;
    public $longitude;
    public $punchin = null , $punchout = null;

    // Check if values exist before debugging
    public function showData()
    {
        dd($this->latitude, $this->longitude);
    }

    // Save Attendance
    public function punchIn()
    {
        if (!$this->latitude || !$this->longitude) {
            $this->error('⚠️ Location not found. Please wait.');
            return;
        }

            $this->punchin = Carbon::now(); // Update the punch-in time
            Attendance::create([
                'user' => Auth::user()->name,
                'date' => Carbon::now(),
                'punchin' => $this->punchin,
                'leave' => 0,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude
            ]);
            $this->success(' Punch In Successful');
    }
    public function punchOut()
    {

            $this->punchout = Carbon::now(); // Update the punch-out time
            Attendance::where('user', Auth::user()->name)
                ->whereDate('date', Carbon::today())
                ->update(['punchout' => $this->punchout]);

            $this->success('Punch Out Successful');
    }
};
?>

<div>
    <!-- HEADER -->
    <x-header title="Attendance" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <x-input placeholder="Search..." wire:model.live.debounce="search" clearable icon="o-magnifying-glass" />
        </x-slot:middle>
        <x-slot:actions>
            <x-button label="Filters" @click="$wire.drawer = true" responsive icon="o-funnel" />
        </x-slot:actions>
    </x-header>

        @php 
             $checkPunchin = App\Models\Attendance::where('user', Auth::user()->name)->whereDate('date', Carbon::today())->first(); 
             $punchOutCheck = $checkPunchin->punchout ?? null;
        @endphp
        @if($checkPunchin == null)
            <x-button 
                wire:click="punchIn" 
                class="btn btn-primary px-10 text-2xl" 
                label="Punch In"
            />
        @elseif($checkPunchin != null && $punchOutCheck == null)
            <x-button 
                wire:click="punchOut" 
                class="btn btn-secondary px-10 text-2xl" 
                label="Punch Out"
            />
        @elseif($punchOutCheck != null && $checkPunchin != null)
            <p class="text-green-500 font-bold">✅ You have already punched in & out today.</p>
        @endif

    <!-- PUNCH IN BUTTON (DISABLED UNTIL LOCATION IS SET) -->

    <!-- FILTER DRAWER -->
    <x-drawer wire:model="drawer" title="Filters" right separator with-close-button class="lg:w-1/3">
        <x-input placeholder="Search..." wire:model.live.debounce="search" icon="o-magnifying-glass" @keydown.enter="$wire.drawer = false" />
        <x-slot:actions>
            <x-button label="Reset" icon="o-x-mark" wire:click="clear" spinner />
            <x-button label="Done" icon="o-check" class="btn-primary" @click="$wire.drawer = false" />
        </x-slot:actions>
    </x-drawer>
    <h1>hello</h1>
</div>
<script>
    window.onload = function() {
        getLocation();
    };

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                let lat = position.coords.latitude;
                let lng = position.coords.longitude;

                // ✅ Update Livewire properties
                @this.set('latitude', lat);
                @this.set('longitude', lng);


            }, function(error) {
                console.error("Error getting location:", error);
                alert("❌ Error getting location. Please allow location access.");
            });
        } else {
            alert("⚠️ Geolocation is not supported by this browser.");
        }
    }
</script>
