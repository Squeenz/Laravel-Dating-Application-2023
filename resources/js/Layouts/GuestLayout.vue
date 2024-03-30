<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import { Bell, MessageCircleHeart, Heart, Camera, CameraOff, ListChecks, BellPlus } from 'lucide-vue-next';
import { computed } from 'vue';

const page = usePage();

const user = computed(()=>{
    return page.props.auth.user;
});

</script>

<template>
    <div class="min-h-screen bg-[#1A1A1A]">
        <nav class="bg-[#111111] border-b border-red-800">
            <!-- Primary Navigation Menu -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-flow-col justify-between">
                    <div class="float-left my-[0.9rem]">
                        <Link :href="route('page.index', 'home')">
                            <ApplicationLogo
                                class="block h-9 w-auto fill-current text-red-800"
                            />
                        </Link>
                    </div>

                    <div class="flex justify-center h-16">
                        <div class="flex">
                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink
                                    v-for="page in page.props.pages"
                                    :key="page.id"
                                    :href="route('page.index', page.slug)" :active="route().current('page.index', page.slug)"
                                    >
                                        {{ page.page_name }}
                                </NavLink>

                                <NavLink :href="route('policies.index')" :active="route().current('policies.index')">
                                    Policies
                                </NavLink>

                                <!-- <NavLink :href="route('support')" :active="route().current('support')">
                                    Support
                                </NavLink> -->
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Links -->
                    <div
                        v-if="user === null"
                        class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"
                        >
                        <NavLink :href="route('login')" :active="route().current('login')">
                            Login
                        </NavLink>
                        <NavLink :href="route('register')" :active="route().current('register')">
                            Register
                        </NavLink>
                    </div>

                    <div v-else
                        class="hidden sm:flex sm:items-center sm:ms-6"
                        >
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
                                        <DropdownLink :href="route('logout')" method="post" as="button">
                                            Log Out
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
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
