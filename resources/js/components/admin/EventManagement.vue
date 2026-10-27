<template>
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Event Management</h1>
        <p class="text-gray-600">Manage university events and student registrations</p>
      </div>
      
      <button
        @click="showCreateEvent = true"
        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors"
      >
        <PlusIcon class="h-4 w-4 mr-2" />
        Add New Event
      </button>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <CalendarDaysIcon class="h-8 w-8 text-blue-500" />
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-500">Total Events</p>
            <p class="text-2xl font-semibold text-gray-900">{{ events.length }}</p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <UserGroupIcon class="h-8 w-8 text-green-500" />
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-500">Total Registrations</p>
            <p class="text-2xl font-semibold text-gray-900">{{ totalRegistrations }}</p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <ClockIcon class="h-8 w-8 text-yellow-500" />
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-500">Upcoming Events</p>
            <p class="text-2xl font-semibold text-gray-900">{{ upcomingEvents }}</p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <CheckCircleIcon class="h-8 w-8 text-indigo-500" />
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-500">This Month</p>
            <p class="text-2xl font-semibold text-gray-900">{{ thisMonthRegistrations }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Events List -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
      <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">University Events</h3>
      </div>
      
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Event
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Date & Location
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Registrations
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Status
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Actions
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="event in events" :key="event.id" class="hover:bg-gray-50">
              <td class="px-6 py-4">
                <div class="flex items-center">
                  <img :src="event.image" :alt="event.title" class="w-12 h-12 rounded-lg object-cover mr-4">
                  <div>
                    <div class="text-sm font-medium text-gray-900">{{ event.title }}</div>
                    <div class="text-sm text-gray-500">{{ truncateText(event.description, 50) }}</div>
                  </div>
                </div>
              </td>
              
              <td class="px-6 py-4">
                <div class="text-sm text-gray-900">{{ formatDate(event.event_date) }}</div>
                <div class="text-sm text-gray-500">{{ event.time }}</div>
                <div class="text-sm text-gray-500">{{ event.location }}</div>
              </td>
              
              <td class="px-6 py-4">
                <div class="text-sm text-gray-900">{{ event.registered_count }}/{{ event.max_attendees }}</div>
                <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                  <div 
                    class="bg-blue-600 h-2 rounded-full" 
                    :style="{ width: `${Math.min((event.registered_count / event.max_attendees) * 100, 100)}%` }"
                  ></div>
                </div>
              </td>
              
              <td class="px-6 py-4">
                <span
                  :class="[
                    'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                    event.is_past ? 'bg-gray-100 text-gray-800' : 'bg-green-100 text-green-800'
                  ]"
                >
                  {{ event.is_past ? 'completed' : 'upcoming' }}
                </span>
              </td>
              
              <td class="px-6 py-4 text-sm font-medium">
                <div class="flex items-center space-x-2">
                  <button
                    @click="viewEventDetails(event)"
                    class="text-blue-600 hover:text-blue-900"
                  >
                    View Details
                  </button>
                  
                  <button
                    @click="viewRegistrations(event)"
                    class="text-green-600 hover:text-green-900"
                  >
                    Registrations
                  </button>
                  
                  <button
                    @click="editEvent(event)"
                    class="text-indigo-600 hover:text-indigo-900"
                  >
                    Edit
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Event Registrations Modal -->
    <div v-if="selectedEvent && showRegistrations" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-xl max-w-4xl w-full max-h-screen overflow-y-auto">
        <div class="p-6">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-medium text-gray-900">{{ selectedEvent.title }} - Registrations</h3>
            <button
              @click="closeRegistrations"
              class="text-gray-400 hover:text-gray-600"
            >
              <XMarkIcon class="h-6 w-6" />
            </button>
          </div>
          
          <!-- Registration Statistics -->
          <div class="grid grid-cols-3 gap-4 mb-6">
            <div class="bg-blue-50 p-4 rounded-lg text-center">
              <div class="text-2xl font-bold text-blue-600">{{ eventRegistrations.length }}</div>
              <div class="text-sm text-gray-600">Total Registrations</div>
            </div>
            <div class="bg-green-50 p-4 rounded-lg text-center">
              <div class="text-2xl font-bold text-green-600">{{ confirmedRegistrations }}</div>
              <div class="text-sm text-gray-600">Confirmed</div>
            </div>
            <div class="bg-yellow-50 p-4 rounded-lg text-center">
              <div class="text-2xl font-bold text-yellow-600">{{ selectedEvent.max_attendees - selectedEvent.registered_count }}</div>
              <div class="text-sm text-gray-600">Available Spots</div>
            </div>
          </div>
          
          <!-- Registrations Table -->
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Department</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Registration Date</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200">
                <tr v-for="registration in eventRegistrations" :key="registration.id" class="hover:bg-gray-50">
                  <td class="px-6 py-4">
                    <div>
                      <div class="font-medium text-gray-900">{{ registration.student_name }}</div>
                      <div class="text-sm text-gray-500">{{ registration.student_email }}</div>
                      <div class="text-xs text-gray-400" v-if="registration.student_phone">{{ registration.student_phone }}</div>
                    </div>
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-900">
                    {{ registration.department || 'Not specified' }}
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-900">
                    {{ registration.created_at }}
                  </td>
                  <td class="px-6 py-4">
                    <span
                      :class="[
                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                        registration.registration_status === 'confirmed' ? 'bg-green-100 text-green-800' :
                        registration.registration_status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                        'bg-red-100 text-red-800'
                      ]"
                    >
                      {{ registration.registration_status }}
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Event Details/Edit Modal -->
    <div v-if="selectedEvent && showEventDetails" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-xl max-w-2xl w-full max-h-screen overflow-y-auto">
        <div class="p-6">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-medium text-gray-900">Event Details</h3>
            <button
              @click="closeEventDetails"
              class="text-gray-400 hover:text-gray-600"
            >
              <XMarkIcon class="h-6 w-6" />
            </button>
          </div>
          
          <!-- Event Information -->
          <div class="space-y-6">
            <div class="aspect-w-16 aspect-h-9">
              <img :src="selectedEvent.image" :alt="selectedEvent.title" class="w-full h-48 object-cover rounded-lg">
            </div>
            
            <div>
              <h4 class="text-xl font-bold text-gray-900 mb-2">{{ selectedEvent.title }}</h4>
              <p class="text-gray-700 mb-4">{{ selectedEvent.description }}</p>
              
                <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                  <span class="font-medium text-gray-900">Date:</span> {{ formatDate(selectedEvent.event_date) }}
                </div>
                <div>
                  <span class="font-medium text-gray-900">Time:</span> {{ selectedEvent.time }}
                </div>
                <div>
                  <span class="font-medium text-gray-900">Location:</span> {{ selectedEvent.location }}
                </div>
                <div>
                  <span class="font-medium text-gray-900">Capacity:</span> {{ selectedEvent.max_attendees }}
                </div>
                <div>
                  <span class="font-medium text-gray-900">Registered:</span> {{ selectedEvent.registered_count }}
                </div>
                <div>
                  <span class="font-medium text-gray-900">Registration Deadline:</span> {{ formatDate(selectedEvent.registration_deadline) }}
                </div>
              </div>
              
              <div class="mt-4">
                <h5 class="font-medium text-gray-900 mb-2">Requirements:</h5>
                <ul class="list-disc list-inside space-y-1 text-sm text-gray-700">
                  <li v-for="req in selectedEvent.requirements" :key="req">{{ req }}</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import {
  CalendarDaysIcon,
  UserGroupIcon,
  ClockIcon,
  CheckCircleIcon,
  PlusIcon,
  XMarkIcon
} from '@heroicons/vue/24/outline';

const events = ref([]);
const selectedEvent = ref(null);
const showRegistrations = ref(false);
const showEventDetails = ref(false);
const showCreateEvent = ref(false);
const eventRegistrations = ref([]);
const loading = ref(true);
const createEventForm = ref({
  title: '',
  description: '',
  event_date: '',
  start_time: '09:00',
  end_time: '17:00',
  location: '',
  venue: '',
  image: '',
  category: 'general',
  max_attendees: null,
  registration_deadline: '',
  requirements: [],
  highlights: [],
  contact_email: '',
  contact_phone: '',
  organizer: ''
});
const isCreatingEvent = ref(false);

const totalRegistrations = computed(() => {
  return events.value.reduce((total, event) => total + event.registered_count, 0);
});

const upcomingEvents = computed(() => {
  const now = new Date();
  return events.value.filter(event => new Date(event.date) > now).length;
});

const thisMonthRegistrations = computed(() => {
  const now = new Date();
  const thisMonth = now.getMonth();
  const thisYear = now.getFullYear();
  
  return eventRegistrations.value.filter(reg => {
    const regDate = new Date(reg.created_at);
    return regDate.getMonth() === thisMonth && regDate.getFullYear() === thisYear;
  }).length;
});

const confirmedRegistrations = computed(() => {
  return eventRegistrations.value.filter(reg => reg.registration_status === 'confirmed').length;
});

const fetchEvents = async () => {
  try {
    loading.value = true;
    const response = await fetch('/api/admin/events');
    if (response.ok) {
      const data = await response.json();
      events.value = data.events || [];
    }
  } catch (error) {
    console.error('Failed to fetch events:', error);
  } finally {
    loading.value = false;
  }
};

const fetchEventRegistrations = async () => {
  try {
    const response = await fetch('/api/admin/event-registrations');
    if (response.ok) {
      const data = await response.json();
      eventRegistrations.value = data.registrations || [];
    }
  } catch (error) {
    console.error('Failed to fetch event registrations:', error);
  }
};

const viewEventDetails = (event) => {
  selectedEvent.value = event;
  showEventDetails.value = true;
};

const viewRegistrations = (event) => {
  selectedEvent.value = event;
  showRegistrations.value = true;
};

const editEvent = (event) => {
  // TODO: Implement event editing
  console.log('Edit event:', event);
};

const closeRegistrations = () => {
  showRegistrations.value = false;
  selectedEvent.value = null;
};

const closeEventDetails = () => {
  showEventDetails.value = false;
  selectedEvent.value = null;
};

const createEvent = async () => {
  if (!createEventForm.value.title || !createEventForm.value.event_date || !createEventForm.value.location) {
    alert('Please fill in all required fields.');
    return;
  }

  isCreatingEvent.value = true;

  try {
    const response = await fetch('/api/v1/events', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
      },
      body: JSON.stringify(createEventForm.value)
    });

    if (response.ok) {
      const data = await response.json();
      if (data.success) {
        showCreateEvent.value = false;
        createEventForm.value = {
          title: '',
          description: '',
          event_date: '',
          start_time: '09:00',
          end_time: '17:00',
          location: '',
          venue: '',
          image: '',
          category: 'general',
          max_attendees: null,
          registration_deadline: '',
          requirements: [],
          highlights: [],
          contact_email: '',
          contact_phone: '',
          organizer: ''
        };
        fetchEvents();
        showNotification('success', 'Success', 'Event created successfully');
      } else {
        alert(data.message || 'Failed to create event');
      }
    } else {
      alert('Failed to create event. Please try again.');
    }
  } catch (error) {
    console.error('Error creating event:', error);
    alert('Failed to create event. Please try again.');
  } finally {
    isCreatingEvent.value = false;
  }
};

const formatDate = (dateString) => {
  if (!dateString) return '';
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  });
};

const truncateText = (text, length) => {
  return text.length > length ? text.substring(0, length) + '...' : text;
};

onMounted(() => {
  fetchEvents();
  fetchEventRegistrations();
});
</script>