<script setup>
import { Head, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    policy: Object,
});
</script>

<template>
    <Head title="Privacy Policy" />

    <GuestLayout>
        <template #header>
            <h1 class="text-5xl italic text-white text-center">{{ props.policy.title }}</h1>
            <p class="text-gray-200 text-center">Read below</p>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="sm:py-[1.5rem] bg-[#0A0A0A] shadow rounded-sm">
                <div class="flex flex-col justify-center p-[1rem] gap-3 text-white w-full">

                    <div class="prose text-white max-w-none" v-html="props.policy.content"></div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
