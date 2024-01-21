<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

//define the prop to recieve the count of photos from the server
const props = defineProps(['users']);

</script>

<template>
    <Head title="Matches" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Your Matches</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <h1 class="text-[2rem] text-center">Your Matches</h1>

                    <div
                        v-for="user in users"
                        :key="user.id"
                        >
                        <h1>{{ user.first_name }} {{ user.surname }}  ({{ user.username }})</h1>
                        <h1>Age: {{ user.dob }}</h1>
                        <h1>Bio: {{ user.bio }}</h1>
                        <h1>Interests: {{ user.interests }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
