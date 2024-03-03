<script setup>
import { ref, onMounted } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import { Bell, MessageCircleHeart, Heart, Camera, CameraOff, ListChecks, BellPlus } from 'lucide-vue-next';

const page = usePage();

const showingNavigationDropdown = ref(false);

</script>

<template>
    <div>
        <div class="min-h-screen bg-[#1A1A1A]">
            <nav class="bg-[#111111] w-[10rem] h-screen float-left border-r border-red-800">
                <!-- Primary Navigation Menu -->
                <div class="mx-auto px-[1rem]">
                    <div class="flex justify-between h-16">

                        <div class="flex-col">
                            <!-- Logo -->
                            <div class="shrink-0 flex justify-center mt-1">
                                <Link :href="route('matchmaking')">
                                    <ApplicationLogo
                                        class="block h-9 w-auto fill-current text-red-800"
                                    />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="flex-col">
                                <NavLink :href="route('matchmaking')" :active="route().current('matchmaking')">
                                   <Heart class="mr-1" :size="20"/> Matchmaking
                                </NavLink>

                                <NavLink :href="route('matchmaking')" :active="route().current('matchmaking')">
                                   <Heart class="mr-1" :size="20"/> Matchmaking
                                </NavLink>

                                <NavLink :href="route('matchmaking')" :active="route().current('matchmaking')">
                                   <Heart class="mr-1" :size="20"/> Matchmaking
                                </NavLink>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="hidden sm:flex sm:items-center sm:ms-6 float-right mt-[1rem]">
                <!-- Settings Dropdown -->
                <div class="ms-3 relative">
                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <span class="inline-flex rounded-md">
                                <button
                                    type="button"
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                >
                                    {{$page.props.auth.user.first_name + " " +  $page.props.auth.user.surname}} ({{ $page.props.auth.user.username}})

                                    <svg
                                        class="ms-2 -me-0.5 h-4 w-4"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </button>
                            </span>
                        </template>

                        <template #content>
                            <DropdownLink href="#"> Staff Dashboard </DropdownLink>
                            <DropdownLink :href="route('profile.edit')"> Profile </DropdownLink>
                            <DropdownLink :href="route('logout')" @click="stopListening" method="post" as="button">
                                Log Out
                            </DropdownLink>
                        </template>
                    </Dropdown>
                </div>
            </div>

            <!-- Page Heading -->
            <header class="bg-[#242424] shadow ml-[10rem]" v-if="$slots.header">
                <div class="mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main class="ml-[10rem]">
                <slot />
            </main>
        </div>
    </div>
</template>
