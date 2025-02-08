<?php

use Livewire\Volt\Component;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    public string $search = '';
    public bool $drawer = false;
    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];
    public $latitude;
    public $longitude;

    public function showData(){
        dd($this->latitude ,$this->longitude );
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

 
    <!-- FILTER DRAWER -->
    <x-drawer wire:model="drawer" title="Filters" right separator with-close-button class="lg:w-1/3">
        <x-input placeholder="Search..." wire:model.live.debounce="search" icon="o-magnifying-glass" @keydown.enter="$wire.drawer = false" />
        <x-slot:actions>
            <x-button label="Reset" icon="o-x-mark" wire:click="clear" spinner />
            <x-button label="Done" icon="o-check" class="btn-primary" @click="$wire.drawer = false" />
        </x-slot:actions>
    </x-drawer>

<!-- JavaScript to Get User Location -->
    <p>Latitude: <input type="text" id="latitude" wire:model="latitude" readonly></p>
    <p>Longitude: <input type="text" id="longitude" wire:model="longitude" readonly></p>

    <button onclick="getLocation()" class="btn btn-primary px-10 text-2xl">Punch In</button>

</div>

<script>
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                let lat = position.coords.latitude;
                let lng = position.coords.longitude;

                // Update input fields (Optional)
                document.getElementById("latitude").value = lat;
                document.getElementById("longitude").value = lng;

                // ✅ Update Livewire data directly
                @this.set('latitude', lat);
                @this.set('longitude', lng);

            }, function(error) {
                console.error("Error getting location:", error);
            });
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    }
</script>


