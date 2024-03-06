<script setup>
import { Head, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    }
});
</script>

<template>
    <Head title="Policies" />

    <GuestLayout :canLogin="canLogin" :canRegister="canRegister">
        <template #header>
            <p class=" text-white">
                We're committed to providing you with a safe and enjoyable experience. To ensure transparency and clarity,
                please review our policies below. By using our website, you agree to abide by these policies and guidelines.
            </p>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="sm:py-[1.5rem] bg-[#0A0A0A] shadow rounded-sm">
                <div class="flex flex-wrap justify-center m-1 gap-3 text-white w-full">
                    <div v-for="n in 7"
                        :key="n"
                        class="bg-[#1A1A1A] p-5 rounded-sm grid grid-flow-row w-[20rem] text-center"
                        :class="n === 7 ? 'md:w-[61.5rem]' : ''"
                    >
                        <h1 class="font-bold m-2 text-2xl">Privacy</h1>
                        <p class="m-1">Created at: 20 April 2023</p>
                        <p class="m-1">Updated at: 20 April 2024</p>
                        <Link :href="route('policies.show')"><PrimaryButton class="bg-red-900 justify-center">READ NOW</PrimaryButton></Link>
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
