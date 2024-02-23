<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

//define the prop to recieve the count of photos from the server
const props = defineProps(['users']);

</script>

<template>
    <Head title="Matches" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-white leading-tight">
                Your Matches
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="sm:h-[51.3rem] sm:py-[1rem] sm:px-[1rem] bg-[#0A0A0A] shadow rounded-sm text-white">
                    <div
                        v-for="user in users"
                        :key="user.id"
                        class="grid grid-flow-col justify-around bg-red-900 rounded-md"
                        >
                        <img class="h-[5rem] w-[5rem] bg-red-500 rounded-full my-auto">
                        <div class="my-auto">
                            <h1>{{ user.first_name }} {{ user.surname }}  ({{ user.username }})</h1>
                            <h1>Age: {{ user.dob }}</h1>
                        </div>
                        <Link :href="route('profile.show', user.id)" class="my-auto"><PrimaryButton>Profile</PrimaryButton></Link>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
