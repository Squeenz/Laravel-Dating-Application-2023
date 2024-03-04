<script setup>
import StaffLayout from '@/Layouts/StaffLayout.vue';
import { Head, usePage, Link, router } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref, onMounted } from 'vue';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import { Users, MonitorDot, TicketX, TicketCheck, Info } from 'lucide-vue-next';
</script>

<template>
    <Head title="Users" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold ml-[4rem] text-xl text-white leading-tight">
                Overall Dashboard
            </h2>
        </template>

        <div>
            <div class="mx-auto ml-[5rem]">
                <div class="shadow rounded-sm text-white">
                    <div class="bg-red-900 p-5 m-2 rounded-sm grid grid-flow-col justify-center text-center items-center">
                        <Info class="mr-[1rem]" :size="40"/>
                        <h1>Important Notice: Support System is down</h1>
                    </div>

                    <div class="grid grid-flow-col">
                        <div class="bg-red-900 p-5 m-2 rounded-sm text-center">
                            <Users class="mx-auto" :size="40"/>
                            <h1>Total Users: 2</h1>
                        </div>

                        <div class="bg-red-900 p-5 m-2 rounded-sm text-center">
                            <MonitorDot class="mx-auto" :size="40"/>
                            <h1>Online Users: 1</h1>
                        </div>

                        <div class="bg-red-900 p-5 m-2 rounded-sm text-center">
                            <TicketX class="mx-auto" :size="40"/>
                            <h1>Open Tickets: 0</h1>
                        </div>

                        <div class="bg-red-900 p-5 m-2 rounded-sm text-center">
                            <TicketCheck class="mx-auto" :size="40"/>
                            <h1>Closed Tickets: 0</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </StaffLayout>
</template>
