<script setup>
import { Head, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';

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
    <Head title="Welcome" />


    <GuestLayout :canLogin="canLogin" :canRegister="canRegister">

    <template #header>
        <h1 class="text-white">
            Your safety is our top priority, and we want to ensure that your dating experience is enjoyable and secure. Follow these guidelines to stay safe while using our platform:
        </h1>
    </template>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="sm:py-[2rem] bg-[#0A0A0A] shadow rounded-sm">
                <div class="flex flex-wrap justify-center text-white">
                    <div class="flex flex-wrap justify-center m-2 gap-3">
                        <div v-for="n in 10"
                            :key="n"
                            class="bg-[#1A1A1A] p-2 rounded-sm grid grid-flow-col w-[30rem]"
                        >
                            <h1 class="bg-red-900 text-center w-[4rem] text-3xl rounded-sm pt-[1rem] mr-2">{{ n }}</h1>
                            <p class="mx-auto my-auto">
                                Gamer-Centric Community: We're a community built by and for gamers.
                                We understand your world, your interests, and your passion for gaming.
                            </p>
                        </div>

                    </div>
                </div>
          </div>
    </div>

    </GuestLayout>
</template>
