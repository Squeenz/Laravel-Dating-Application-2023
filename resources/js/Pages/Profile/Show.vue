<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const { userData, userPhotos } = defineProps(['userData', 'userPhotos']);

</script>

<template>
  <div>
    <Head :title="userData.username" />
    <AuthenticatedLayout>
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Profile</h2>
      </template>

      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
          <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <h1>{{ userData.first_name }} {{ userData.surname }} ({{ userData.username }})</h1>
            <h1>Date of birth: {{ userData.dob }}</h1>
            <h1>Location: {{ userData.location }}</h1>
            <h1>Interests: {{ userData.interests }}</h1>
          </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
          <h1>Photos</h1>
          <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <img
              v-for="photo in userPhotos"
              :src="photo.photo"
              :alt="userData.first_name + ' photo'"
              :key="photo.id"
            />
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </div>
</template>
