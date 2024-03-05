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
        <h1 class="text-white">Welcome to our site, we are a new dating service which focuses on gamers and non-profit service model. Unlike majority of
            dating applications we don't charge for basic features that people should have access to.
        </h1>
    </template>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="sm:py-[6.8rem] bg-[#0A0A0A] shadow rounded-sm">
                <div class="flex flex-wrap justify-center text-white">
                    <h1 class="text-2xl italic">Why should you choose us?</h1>
                    <p>
                        At Gamer Love, we believe in the power of shared interests,
                        and what better foundation for a relationship than a love for gaming?
                         <br />Here's why you should choose us:
                    </p>
                    <div class="flex flex-wrap justify-center m-2 gap-3">
                        <div v-for="n in 5"
                            :key="n"
                            class="bg-[#1A1A1A] p-2 rounded-sm grid grid-flow-col w-[30rem]"
                        >
                            <h1 class="bg-red-900 text-center w-[4rem] text-3xl rounded-sm pt-[1rem] mr-2">{{ n }}</h1>
                            <p class="mx-auto my-auto">
                                Gamer-Centric Community: We're a community built by and for gamers.
                                We understand your world, your interests, and your passion for gaming.
                            </p>
                        </div>

                        <div class="bg-red-900 p-2 rounded-md grid grid-flow-col w-[30rem] justify-center">
                            <h1 class="my-auto text-5xl font-bold">AND MORE</h1>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap justify-center text-white">
                    <h1 class="text-2xl italic">How does it work?</h1>
                    <div class="justify-center m-2 gap-3">
                        <div class="bg-red-800 relative rounded-full right-[50%] top-[5.7rem] h-[23.4rem] w-3 float-right "></div>

                        <div v-for="n in 5" :key="n" class="bg-[#1A1A1A] p-2 rounded-sm grid grid-flow-col w-[30rem] mx-5"
                            :class="n % 2 ? 'float-left my-[3rem]' : 'float-right my-[5rem]'">

                            <div class="my-auto mr-2 h-1 w-4 relative" :class="n % 2 ? 'left-[29.6rem]' : 'right-[6.6rem]'">
                                <div class="bg-red-800 rounded-full h-2 w-[6rem] "> </div>
                            </div>

                            <h1 class="bg-red-900 text-center w-[4rem] text-3xl rounded-sm pt-[1rem] mr-2">{{ n }}</h1>

                            <p class="mx-auto my-auto">
                                Gamer-Centric Community: We're a community built by and for gamers. We understand your world, your interests,
                                and your passion for gaming.
                            </p>
                        </div>
                    </div>
                </div>

          </div>
    </div>

    </GuestLayout>
</template>
