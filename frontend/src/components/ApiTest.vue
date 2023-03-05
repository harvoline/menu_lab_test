<template>
  <div class="mx-2.5 my-5">
    <div v-if="isLoading" class="flex justify-center items-center h-64">
      <svg class="animate-spin h-10 w-10 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm12 0a8 8 0 100-16v3a5 5 0 015 5h3zm-4 4a5 5 0 01-5 5v3a8 8 0 008-8h-3zm-10 0a8 8 0 008 8v-3a5 5 0 01-5-5H4z"></path>
      </svg>
    </div>

    <table v-else id="usersTable" class="table-auto w-full">
      <thead class="bg-gray-300 border">
        <tr>
          <th class="border px-4 py-2">Name</th>
          <th class="border px-4 py-2">Email</th>
          <th class="border px-4 py-2">Latitude</th>
          <th class="border px-4 py-2">Longitude</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id" @click="openModal(user)" class="border bg-white hover:bg-gray-100 hover:shadow-md">
          <td class="border px-4 py-2">{{ user.name }}</td>
          <td class="border px-4 py-2">{{ user.email }}</td>
          <td class="border px-4 py-2">{{ user.latitude }}</td>
          <td class="border px-4 py-2">{{ user.longitude }}</td>
        </tr>
      </tbody>
    </table>

    <div v-if="selectedUser" class="fixed z-10 inset-0 overflow-y-auto">
      <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
          <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full">
          <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="p-6">
              <h2 class="text-2xl font-bold mb-4">{{ selectedUser.name }}</h2>
              
              <h3>User Live Weather</h3>
              <div v-if="isLiveModalLoading" class="flex justify-center items-center h-64">
                <svg class="animate-spin h-8 w-8 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-3.647zm10-10.582A7.963 7.963 0 0120 12h4c0-6.627-5.373-12-12-12v4zm-3.293 7.707a4 4 0 005.656 0l-5.656-5.656a4 4 0 000 5.656z"></path>
                </svg>
              </div>
              <div v-else>
                <table id="usersTable" class="table-auto w-full">
                  <thead class="bg-gray-300 border">
                    <tr>
                      <th class="border px-4 py-2">Fetch at</th>
                      <th class="border px-4 py-2">Source</th>
                      <th class="border px-4 py-2">Weather</th>
                      <th class="border px-4 py-2">Description</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-if="selectedUserLiveWeather" :key="selectedUser.id" @click="openModal(user)" class="border bg-white hover:bg-gray-100 hover:shadow-md">
                      <td class="border px-4 py-2">{{ selectedUserLiveWeather.created_at }}</td>
                      <td class="border px-4 py-2">{{ selectedUserLiveWeather.type }}</td>
                      <td class="border px-4 py-2">{{ selectedUserLiveWeather.weather }}</td>
                      <td class="border px-4 py-2">{{ selectedUserLiveWeather.description }}</td>
                    </tr>
                    <tr v-else :key="selectedUser.id" class="border bg-white hover:bg-gray-100 hover:shadow-md">
                      <td class="border px-4 py-2" colspan="4">Unable to fetch live weather data for the user. Please retry again.</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              
              <br />
              <h3>User Weather History</h3>
              <div v-if="isModalLoading" class="flex justify-center items-center h-64">
                <svg class="animate-spin h-8 w-8 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-3.647zm10-10.582A7.963 7.963 0 0120 12h4c0-6.627-5.373-12-12-12v4zm-3.293 7.707a4 4 0 005.656 0l-5.656-5.656a4 4 0 000 5.656z"></path>
                </svg>
              </div>
              <div v-else>
                <table id="usersTable" class="table-auto w-full">
                  <thead class="bg-gray-300 border">
                    <tr>
                      <th class="border px-4 py-2">Fetch at</th>
                      <th class="border px-4 py-2">Source</th>
                      <th class="border px-4 py-2">Weather</th>
                      <th class="border px-4 py-2">Description</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-if="selectedUserWeather" v-for="user_weather in selectedUserWeather" :key="selectedUser.id" @click="openModal(user)" class="border bg-white hover:bg-gray-100 hover:shadow-md">
                      <td class="border px-4 py-2">{{ user_weather.created_at }}</td>
                      <td class="border px-4 py-2">{{ user_weather.type }}</td>
                      <td class="border px-4 py-2">{{ user_weather.weather }}</td>
                      <td class="border px-4 py-2">{{ user_weather.description }}</td>
                    </tr>
                    <tr v-else :key="selectedUser.id" class="border bg-white hover:bg-gray-100 hover:shadow-md">
                      <td class="border px-4 py-2" colspan="4">No data found for the user</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row justify-end">
            <button type="button" v-if="isLiveModalLoading" @click="cancelModalLoading" class="text-red-500 hover:text-red-700">Stop Request</button>
            <button type="button" v-else @click="retryFetchLiveData" class="text-red-500 hover:text-red-700">Retry</button>
            <button type="button" class="w-full inline-flex rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm" @click="selectedUser = null">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      users: [],
      selectedUser: null,
      isLoading: false,
      isModalLoading: false,
      isLiveModalLoading: false,
      selectedUserWeather: null,
      selectedUserLiveWeather: null,
      controller: null,
      signal: null
    };
  },
  mounted() {
    // Set isLoading to true when the component is mounted
    this.isLoading = true;
    // Simulate a delay to fetch data
    this.fetchData()
      .then((data) => {
        this.users = data.users;
      })
      .catch((error) => {
          console.log(error);
        this.users = [];
        this.errors = "Cant fetch users data";
      })
      .finally(() => {
        this.isLoading = false;
      });
  },
  methods: {
    openModal(user) {
      this.controller = new AbortController();
      this.signal = this.controller.signal;
      this.selectedUser = user;
      this.isModalLoading = true;
      this.isLiveModalLoading = true;

      this.fetchWeatherData(this.selectedUser.id)
        .then((data) => {
          this.selectedUserWeather = data.user_weather_data;
        })
        .catch((error) => {
          console.log(error);
          this.selectedUserWeather = null;
        })
        .finally(() => {
          this.isModalLoading = false;
        });

      this.fetchWeatherDataLive(this.selectedUser.id)
        .then((data) => {
          this.selectedUserLiveWeather = data.user_live_weather_data;
        })
        .catch((error) => {
          console.log(error);
          this.selectedUserLiveWeather = null;
        })
        .finally(() => {
          this.isLiveModalLoading = false;
        });
    },
    closeModal() {
      this.selectedUser = null;
    },
    cancelModalLoading() {
      if (this.controller) {
        this.controller.abort();
        console.log("Request aborted");
      }
    },
    retryFetchLiveData() {
      this.controller = new AbortController();
      this.signal = this.controller.signal;
      this.isLiveModalLoading = true;

      this.fetchWeatherDataLive(this.selectedUser.id)
        .then((data) => {
          this.selectedUserLiveWeather = data.user_live_weather_data;
        })
        .catch((error) => {
          console.log(error);
          this.selectedUserLiveWeather = null;
        })
        .finally(() => {
          this.isLiveModalLoading = false;
        });
    },
    async fetchData() {
      const url = 'http://localhost/'
      // this.apiResponse = await (await fetch(url)).json()
      const response = await fetch(url);

      if (!response.ok) {
        return Promise.reject()
      }

      return response.json();
    },
    async fetchWeatherData(id) {
      const url = `http://localhost/user/${id}/weather`;
      const signal = this.signal;

      const response = await fetch(url);

      if (!response.ok) {
        return Promise.reject()
      }

      return response.json();
    },
    async fetchWeatherDataLive(id) {
      const url = `http://localhost/user/${id}/live_weather`;
      const signal = this.signal;

      const response = await fetch(url, { signal });

      if (!response.ok) {
        return Promise.reject()
      }

      return response.json();
    }
  },
};
</script>