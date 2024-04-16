<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';

dayjs.extend(relativeTime);

//define the prop to recieve the count of photos from the server
const props = defineProps(['matches']);
</script>

<template>
    <Head title="Matches" />
    <AuthenticatedLayout>
        <div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="sm:py-[1rem] sm:px-[1rem] bg-[#0A0A0A] shadow rounded-sm text-white">
                    <h1>New Matches</h1>
                    <div
                        v-for="match in props.matches"
                        :key="match"
                        >
                        <div v-if="dayjs(match.matchInformation.created_at).date() >= dayjs().date()" >
                            <div class="grid grid-flow-col w-full m-2 justify-around bg-red-900 rounded-md">
                                <img class="h-40 w-30 rounded-xl" :src="route('photos.get', match.userPrimaryPhoto[0].photo)" draggable="false">
                                <div class="my-auto">
                                    <h1>{{ match.user.first_name }} {{ match.user.surname }}  ({{ match.user.username }})</h1>
                                    <h1>Date: {{ dayjs(match.matchInformation.created_at).format("DD/MM/YYYY") }} ({{ dayjs(match.matchInformation.updated_at).fromNow() }})</h1>
                                </div>
                                <Link :href="route('profile.show', match.user.id)" class="my-auto"><PrimaryButton>Profile</PrimaryButton></Link>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="sm:py-[1rem] sm:px-[1rem] bg-[#0A0A0A] shadow rounded-sm text-white">
                    <h1>Old Matches</h1>
                    <div
                        v-for="match in props.matches"
                        :key="match"
                        >
                        <div v-if="dayjs(match.matchInformation.created_at).date() < dayjs().date()" >
                            <div class="grid grid-flow-col w-full m-2 justify-around bg-red-900 rounded-md">
                                <img class="h-40 w-30 rounded-xl" :src="route('photos.get', match.userPrimaryPhoto[0].photo)" draggable="false">
                                <div class="my-auto">
                                    <h1>{{ match.user.first_name }} {{ match.user.surname }}  ({{ match.user.username }})</h1>
                                    <h1>Date: {{ dayjs(match.matchInformation.created_at).format("DD/MM/YYYY") }} ({{ dayjs(match.matchInformation.updated_at).fromNow() }})</h1>
                                </div>
                                <Link :href="route('profile.show', match.user.id)" class="my-auto"><PrimaryButton>Profile</PrimaryButton></Link>
                            </div>
                        </div>
                        <div v-else>
                            <h1 class="mt-[1rem] text-gray-400">No old matches</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
