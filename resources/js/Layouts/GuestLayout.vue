<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import NavLink from '@/Components/NavLink.vue';
import { Bell, MessageCircleHeart, Heart, Camera, CameraOff, ListChecks, BellPlus } from 'lucide-vue-next';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    }
});

</script>

<template>
    <div class="min-h-screen bg-[#1A1A1A]">
        <nav class="bg-[#111111] border-b border-red-800">
            <!-- Primary Navigation Menu -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-flow-col justify-between">
                    <div class="float-left my-[0.9rem]">
                        <Link :href="route('home')">
                            <ApplicationLogo
                                class="block h-9 w-auto fill-current text-red-800"
                            />
                        </Link>
                    </div>

                    <div class="flex justify-center h-16">
                        <div class="flex">
                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink :href="route('home')" :active="route().current('home')">
                                    Home
                                </NavLink>
                                <NavLink :href="route('policies')" :active="route().current('policies')">
                                    Policies
                                </NavLink>
                                <NavLink :href="route('safe')" :active="route().current('safe')">
                                    How To Stay Safe
                                </NavLink>
                                <NavLink :href="route('support')" :active="route().current('support')">
                                    Support
                                </NavLink>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <NavLink :href="route('login')" :active="route().current('login')">
                            Login
                        </NavLink>
                        <NavLink :href="route('register')" :active="route().current('register')">
                            Register
                        </NavLink>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        <header class="bg-[#8e8e8e] shadow" v-if="$slots.header">
            <div class="max-w-7xl mx-auto py-[5rem] px-4 sm:px-6 lg:px-10 text-[1.4rem]">
                <slot name="header" />
            </div>
        </header>

        <!-- Page Content -->
        <main>
            <slot />
        </main>

    </div>
</template>
