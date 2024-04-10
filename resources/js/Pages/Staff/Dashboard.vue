<script setup>
import StaffLayout from '@/Layouts/StaffLayout.vue';
import { Head, usePage, Link, router } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref, onMounted } from 'vue';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import { Users, MonitorDot, Ticket, TicketX, TicketCheck, Info, Heart, ThumbsUp } from 'lucide-vue-next';
import { usePermissions } from '@/Composables/usePermissions';
import PermissionErrorMsg from '@/Components/PermissionErrorMsg.vue';

const { hasPerm } = usePermissions();
</script>

<template>
    <Head title="Users" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-white leading-tight">
                Overall Dashboard
            </h2>
        </template>

        <div>
            <div class="mx-auto">
                <div v-if="hasPerm('access dashboard statistics')" class="shadow rounded-sm text-white">
                    <div class="bg-orange-600 p-5 m-2 rounded-sm grid grid-flow-col justify-center text-center items-center">
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
                            <ThumbsUp class="mx-auto" :size="40"/>
                            <h1>Total Likes: 2</h1>
                        </div>

                        <div class="bg-red-900 p-5 m-2 rounded-sm text-center">
                            <Heart class="mx-auto" :size="40"/>
                            <h1>Total Matches: 1</h1>
                        </div>
                    </div>

                    <div class="grid grid-flow-col">
                        <div class="bg-red-900 p-5 m-2 rounded-sm text-center">
                            <Ticket class="mx-auto" :size="40"/>
                            <h1>Total Tickets: 0</h1>
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
                <PermissionErrorMsg v-else :role="$page.props.auth.role"/>
            </div>
        </div>
    </StaffLayout>
</template>
