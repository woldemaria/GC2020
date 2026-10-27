<template>
    <div class="min-h-screen bg-gray-50">
        <div class="container mx-auto px-4 py-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">
                    Campus Map
                </h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Explore GC University campus locations in real-time. Find buildings,
                    departments, facilities, and navigate your way around campus.
                </p>
            </div>

            <!-- Location Filter Chips -->
            <div class="flex flex-wrap justify-center gap-2 mb-6">
                <button
                    v-for="cat in categories"
                    :key="cat.id"
                    @click="activeCategory = activeCategory === cat.id ? null : cat.id"
                    :class="[
                        'px-4 py-2 rounded-full text-sm font-medium transition-all duration-200',
                        activeCategory === cat.id
                            ? 'bg-blue-600 text-white shadow-md'
                            : 'bg-white text-gray-700 border border-gray-300 hover:border-blue-400 hover:text-blue-600'
                    ]"
                >
                    <span class="mr-1">{{ cat.icon }}</span>
                    {{ cat.label }}
                </button>
            </div>

            <!-- Map Container -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <!-- Map -->
                <div class="relative">
                    <div ref="mapContainer" class="h-[500px] md:h-[600px] w-full"></div>

                    <!-- Map Controls Overlay -->
                    <div class="absolute top-4 right-4 z-[1000] flex flex-col gap-2">
                        <button
                            @click="centerOnCampus"
                            class="bg-white p-2 rounded-lg shadow-md hover:bg-gray-50 transition"
                            title="Center on campus"
                        >
                            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        </button>
                        <button
                            @click="locateUser"
                            class="bg-white p-2 rounded-lg shadow-md hover:bg-gray-50 transition"
                            :class="{ 'bg-blue-50': userLocationActive }"
                            title="Show my location"
                        >
                            <svg class="w-5 h-5" :class="userLocationActive ? 'text-blue-600' : 'text-gray-700'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>
                    </div>

                    <!-- Live indicator -->
                    <div class="absolute top-4 left-4 z-[1000]">
                        <div class="bg-white/95 backdrop-blur-sm rounded-full px-3 py-1.5 shadow-md flex items-center gap-2">
                            <span class="relative flex h-2.5 w-2.5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-green-500"></span>
                            </span>
                            <span class="text-xs font-semibold text-gray-700">Live Map</span>
                        </div>
                    </div>
                </div>

                <!-- Locations List -->
                <div class="border-t border-gray-200">
                    <div class="p-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">
                            Campus Locations
                            <span class="text-sm font-normal text-gray-500 ml-2">
                                ({{ filteredLocations.length }} locations)
                            </span>
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div
                                v-for="loc in filteredLocations"
                                :key="loc.id"
                                @click="flyToLocation(loc)"
                                class="flex items-start gap-3 p-3 rounded-xl bg-gray-50 hover:bg-blue-50 cursor-pointer transition-colors group"
                            >
                                <div class="text-2xl flex-shrink-0">{{ loc.icon }}</div>
                                <div class="min-w-0">
                                    <h3 class="font-semibold text-gray-900 group-hover:text-blue-700 transition-colors text-sm">
                                        {{ loc.name }}
                                    </h3>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ loc.description }}</p>
                                    <span class="inline-block mt-1 px-2 py-0.5 rounded-full text-[10px] font-medium uppercase tracking-wide"
                                        :class="categoryColor(loc.category)"
                                    >
                                        {{ loc.category }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Directions / Info Card -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-1">Main Campus</h3>
                    <p class="text-sm text-gray-600">Addis Ababa, Ethiopia</p>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-1">Open Hours</h3>
                    <p class="text-sm text-gray-600">Mon-Fri: 7AM - 8PM</p>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-1">Campus Security</h3>
                    <p class="text-sm text-gray-600">+251-11-123-4500</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "CampusMap",
    data() {
        return {
            map: null,
            markers: [],
            userMarker: null,
            userLocationActive: false,
            activeCategory: null,
            categories: [
                { id: 'academic', label: 'Academic', icon: '🎓' },
                { id: 'library', label: 'Libraries', icon: '📚' },
                { id: 'admin', label: 'Administration', icon: '🏛️' },
                { id: 'facility', label: 'Facilities', icon: '🏢' },
                { id: 'sports', label: 'Sports', icon: '⚽' },
                { id: 'dining', label: 'Dining', icon: '🍽️' },
            ],
            locations: [
                { id: 1, name: 'Main Administration Building', description: 'University headquarters & registrar office', lat: 9.0358, lng: 38.7633, icon: '🏛️', category: 'admin' },
                { id: 2, name: 'College of Natural Sciences', description: 'Biology, Chemistry, Physics departments', lat: 9.0365, lng: 38.7620, icon: '🔬', category: 'academic' },
                { id: 3, name: 'College of Social Sciences', description: 'Sociology, Psychology, Political Science', lat: 9.0370, lng: 38.7645, icon: '📖', category: 'academic' },
                { id: 4, name: 'Engineering Building', description: 'Civil, Electrical, Mechanical Engineering', lat: 9.0345, lng: 38.7615, icon: '⚙️', category: 'academic' },
                { id: 5, name: 'JFK Memorial Library', description: 'Main university library with study spaces', lat: 9.0360, lng: 38.7640, icon: '📚', category: 'library' },
                { id: 6, name: 'College of Business & Economics', description: 'MBA, Accounting, Finance programs', lat: 9.0380, lng: 38.7630, icon: '💼', category: 'academic' },
                { id: 7, name: 'Student Cafeteria', description: 'Main dining hall for students', lat: 9.0355, lng: 38.7650, icon: '🍽️', category: 'dining' },
                { id: 8, name: 'Sports Complex', description: 'Stadium, gym, swimming pool', lat: 9.0340, lng: 38.7660, icon: '🏟️', category: 'sports' },
                { id: 9, name: 'ICT Center', description: 'Computer labs & IT services', lat: 9.0372, lng: 38.7625, icon: '💻', category: 'facility' },
                { id: 10, name: 'Health Sciences Building', description: 'Medical school & teaching hospital', lat: 9.0350, lng: 38.7610, icon: '🏥', category: 'academic' },
                { id: 11, name: 'Law School', description: 'Faculty of Law & legal clinic', lat: 9.0375, lng: 38.7655, icon: '⚖️', category: 'academic' },
                { id: 12, name: 'Student Services Center', description: 'ID cards, counseling, housing', lat: 9.0362, lng: 38.7628, icon: '🏢', category: 'facility' },
                { id: 13, name: 'Research & Graduate Center', description: 'PhD programs & research labs', lat: 9.0368, lng: 38.7618, icon: '🎓', category: 'academic' },
                { id: 14, name: 'Dormitory Block A', description: 'Male student residence halls', lat: 9.0342, lng: 38.7642, icon: '🏠', category: 'facility' },
                { id: 15, name: 'Dormitory Block B', description: 'Female student residence halls', lat: 9.0338, lng: 38.7648, icon: '🏠', category: 'facility' },
            ],
        };
    },
    computed: {
        filteredLocations() {
            if (!this.activeCategory) return this.locations;
            return this.locations.filter(loc => loc.category === this.activeCategory);
        },
    },
    methods: {
        categoryColor(category) {
            const colors = {
                academic: 'bg-blue-100 text-blue-700',
                library: 'bg-amber-100 text-amber-700',
                admin: 'bg-purple-100 text-purple-700',
                facility: 'bg-gray-100 text-gray-700',
                sports: 'bg-green-100 text-green-700',
                dining: 'bg-red-100 text-red-700',
            };
            return colors[category] || 'bg-gray-100 text-gray-700';
        },

        async initMap() {
            // Dynamically load Leaflet CSS and JS
            if (!window.L) {
                await this.loadLeaflet();
            }

            const L = window.L;

            this.map = L.map(this.$refs.mapContainer, {
                center: [9.0358, 38.7633],
                zoom: 16,
                zoomControl: false,
            });

            // Add zoom control to bottom-right
            L.control.zoom({ position: 'bottomright' }).addTo(this.map);

            // Use OpenStreetMap tiles (free, no API key needed)
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: 19,
            }).addTo(this.map);

            this.addMarkers();
        },

        loadLeaflet() {
            return new Promise((resolve, reject) => {
                // Load CSS
                const css = document.createElement('link');
                css.rel = 'stylesheet';
                css.href = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css';
                css.integrity = 'sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=';
                css.crossOrigin = '';
                document.head.appendChild(css);

                // Load JS
                const script = document.createElement('script');
                script.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
                script.integrity = 'sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=';
                script.crossOrigin = '';
                script.onload = () => resolve();
                script.onerror = () => reject(new Error('Failed to load Leaflet'));
                document.head.appendChild(script);
            });
        },

        addMarkers() {
            const L = window.L;

            // Clear existing markers
            this.markers.forEach(m => m.remove());
            this.markers = [];

            this.filteredLocations.forEach(loc => {
                const markerIcon = L.divIcon({
                    html: `<div style="font-size:24px;text-align:center;line-height:1;filter:drop-shadow(0 2px 4px rgba(0,0,0,0.3))">${loc.icon}</div>`,
                    className: 'custom-marker',
                    iconSize: [32, 32],
                    iconAnchor: [16, 32],
                    popupAnchor: [0, -32],
                });

                const marker = L.marker([loc.lat, loc.lng], { icon: markerIcon })
                    .addTo(this.map)
                    .bindPopup(`
                        <div style="min-width:180px">
                            <div style="font-size:20px;margin-bottom:4px">${loc.icon}</div>
                            <h3 style="font-weight:700;font-size:14px;margin:0 0 4px">${loc.name}</h3>
                            <p style="font-size:12px;color:#666;margin:0">${loc.description}</p>
                            <div style="margin-top:8px">
                                <a href="https://www.google.com/maps/dir/?api=1&destination=${loc.lat},${loc.lng}"
                                   target="_blank" rel="noopener noreferrer"
                                   style="color:#2563eb;font-size:12px;font-weight:600;text-decoration:none">
                                    Get Directions →
                                </a>
                            </div>
                        </div>
                    `);

                this.markers.push(marker);
            });
        },

        flyToLocation(loc) {
            if (this.map) {
                this.map.flyTo([loc.lat, loc.lng], 18, { duration: 1.5 });

                // Open popup for this location
                const marker = this.markers.find((m, i) => this.filteredLocations[i]?.id === loc.id);
                if (marker) {
                    setTimeout(() => marker.openPopup(), 800);
                }
            }
        },

        centerOnCampus() {
            if (this.map) {
                this.map.flyTo([9.0358, 38.7633], 16, { duration: 1 });
            }
        },

        locateUser() {
            if (!navigator.geolocation) {
                alert('Geolocation is not supported by your browser.');
                return;
            }

            const L = window.L;

            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const { latitude, longitude } = position.coords;
                    this.userLocationActive = true;

                    if (this.userMarker) {
                        this.userMarker.setLatLng([latitude, longitude]);
                    } else {
                        const userIcon = L.divIcon({
                            html: `<div style="width:16px;height:16px;background:#3b82f6;border:3px solid white;border-radius:50%;box-shadow:0 0 0 2px #3b82f6,0 2px 8px rgba(59,130,246,0.5)"></div>`,
                            className: 'user-location-marker',
                            iconSize: [22, 22],
                            iconAnchor: [11, 11],
                        });

                        this.userMarker = L.marker([latitude, longitude], { icon: userIcon })
                            .addTo(this.map)
                            .bindPopup('<strong>You are here</strong>');
                    }

                    this.map.flyTo([latitude, longitude], 17, { duration: 1.5 });
                },
                (error) => {
                    alert('Unable to get your location. Please enable location services.');
                    this.userLocationActive = false;
                },
                { enableHighAccuracy: true }
            );
        },
    },
    watch: {
        activeCategory() {
            this.addMarkers();
        },
    },
    mounted() {
        this.initMap();
    },
    beforeUnmount() {
        if (this.map) {
            this.map.remove();
            this.map = null;
        }
    },
};
</script>

<style>
.custom-marker {
    background: none !important;
    border: none !important;
}
.user-location-marker {
    background: none !important;
    border: none !important;
}
</style>
