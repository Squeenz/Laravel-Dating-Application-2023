<script setup>
import { ref, onMounted } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavDropdown from '@/Components/NavDropdown.vue';
import NavDropdownLink from '@/Components/NavDropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import { Heart, Users, Layers3, LifeBuoy, Settings, TableProperties } from 'lucide-vue-next';

const page = usePage();

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <div class="min-h-screen bg-[#111111]">
            <nav class="bg-[#111111] w-[15rem] float-left">
                <!-- Primary Navigation Menu -->
                <div class="mx-auto px-[1rem]">
                    <div>
                        <div class="flex-col justify-between">
                            <!-- Logo -->
                            <div class="shrink-0 flex justify-center my-[1rem]">
                                <Link :href="route('staff.dashboard')">
                                    <ApplicationLogo
                                        class="block h-[3.5rem] w-auto fill-current text-red-800"
                                    />
                                </Link>
                                <p class="text-white z-1 absolute top-[4.5rem] opacity-5"> Version v0.1 </p>
                            </div>

                            <!-- Navigation Links -->
                            <div class="grid grid-flow-row">
                                <h1 class="text-gray-500 text-[0.9rem]">Controls</h1>

                                <NavDropdown>
                                    <template #trigger>
                                            <Users class="mr-1" :size="20"/>
                                            <h1>Users</h1>
                                    </template>

                                    <template #content>
                                        <NavDropdownLink
                                            :href="route('staff.dashboard.users')" :active="route().current('staff.dashboard.users')">
                                            View Users
                                        </NavDropdownLink>
                                    </template>
                                </NavDropdown>

                                <NavDropdown>
                                    <template #trigger>
                                            <TableProperties class="mr-1" :size="20"/>
                                            <h1>Roles</h1>
                                    </template>

                                    <template #content>
                                        <NavDropdownLink
                                            :href="route('matchmaking')" :active="route().current('matchmaking')">
                                            Create
                                        </NavDropdownLink>

                                        <NavDropdownLink
                                            :href="route('matchmaking')" :active="route().current('matchmaking')">
                                            Permissions
                                        </NavDropdownLink>
                                    </template>
                                </NavDropdown>

                                <NavDropdown>
                                    <template #trigger>
                                            <Layers3 class="mr-1" :size="20"/>
                                            <h1>Pages</h1>
                                    </template>

                                    <template #content>
                                        <NavDropdownLink
                                            :href="route('staff.dashboard.pages')" :active="route().current('staff.dashboard.pages')">
                                            Page Controller
                                        </NavDropdownLink>

                                        <NavDropdownLink
                                            v-for="page in page.props.pages"
                                            :href="route('staff.dashboard.pages.edit', page.id)" :active="route().current('staff.dashboard.pages')"
                                            :key="page"
                                        >
                                            {{ page.page_name }}
                                        </NavDropdownLink>


                                        <NavDropdownLink
                                            :href="route('staff.dashboard.policies')" :active="route().current('staff.dashboard.policies')">
                                            Policies
                                        </NavDropdownLink>

                                        <!-- <NavDropdownLink
                                            :href="route('matchmaking')" :active="route().current('matchmaking')">
                                            Landing
                                        </NavDropdownLink>

                                        <NavDropdownLink
                                            :href="route('matchmaking')" :active="route().current('matchmaking')">
                                            Policies
                                        </NavDropdownLink>

                                        <NavDropdownLink
                                            :href="route('matchmaking')" :active="route().current('matchmaking')">
                                            Safety
                                        </NavDropdownLink>

                                        <NavDropdownLink
                                            :href="route('matchmaking')" :active="route().current('matchmaking')">
                                            Support
                                        </NavDropdownLink>

                                        <NavDropdownLink
                                            :href="route('matchmaking')" :active="route().current('matchmaking')">
                                            Terms and conditions
                                        </NavDropdownLink> -->
                                    </template>
                                </NavDropdown>

                                <NavDropdown>
                                    <template #trigger>
                                            <LifeBuoy class="mr-1" :size="20"/>
                                            <h1>Support</h1>
                                    </template>

                                    <template #content>
                                        <NavDropdownLink
                                            :href="route('matchmaking')" :active="route().current('matchmaking')">
                                            Tickets
                                        </NavDropdownLink>

                                        <NavDropdownLink
                                            :href="route('matchmaking')" :active="route().current('matchmaking')">
                                            Closed Tickets
                                        </NavDropdownLink>
                                    </template>
                                </NavDropdown>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="sm:flex sm:items-center bg-[#111111] p-5 ml-[15rem]">
                <!-- Settings Dropdown -->
                <div class="relative left-[85%]">
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

            <!-- Page Heading -->
            <header class="bg-[#242424] shadow ml-[15rem]" v-if="$slots.header">
                <div class="mx-auto py-6 px-4 sm:px-6 lg:px-8 bg-gray-800">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main class="ml-[15rem] bg-gray-900">
                <slot />
            </main>
        </div>
    </div>
</template>
