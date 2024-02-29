<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { MessageCircleHeart, Heart, ThumbsUp, XSquare } from 'lucide-vue-next';
import { computed } from 'vue';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';

dayjs.extend(relativeTime);

const props = defineProps(['notifications']);

const user = computed(() => {
    return (notification) => `${notification.other_user.first_name} ${notification.other_user.surname} (${notification.other_user.username})`;
});
</script>

<template>
    <Head title="Notifications" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-white leading-tight">
                Notifications
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="h-screen bg-[#0A0A0A] shadow rounded-sm text-white">

                    <div
                    v-for="notification in props.notifications"
                    :key="notification.id"
                    class="bg-red-900 border-b-2 border-b-red-950 w-full p-[1rem]">
                        <div
                            v-if="notification.type == 'Match'"
                            class="grid grid-flow-col items-center justify-between"
                        >
                            <Heart class="bg-red-950 h-10 w-10 p-1 rounded-sm"/>
                            <h1>Matched with <strong> {{ user(notification) }}</strong> <span class="text-[0.7rem] text-gray-300">{{ dayjs(notification.created_at).fromNow() }}</span> </h1>
                            <XSquare class="bg-red-950 h-10 w-10 p-1 rounded-sm"/>
                        </div>
                        <div
                            v-else-if="notification.type == 'Message'"
                            class="grid grid-flow-col items-center justify-between"
                        >
                            <MessageCircleHeart class="bg-red-950 h-10 w-10 p-1 rounded-sm"/>
                            <h1>New message from <strong> {{ user(notification) }}</strong> <span class="text-[0.7rem] text-gray-300">{{ dayjs(notification.created_at).fromNow() }}</span> </h1>
                            <XSquare class="bg-red-950 h-10 w-10 p-1 rounded-sm"/>
                        </div>
                        <div
                            v-else-if="notification.type == 'Like'"
                            class="grid grid-flow-col items-center justify-between"
                        >
                            <ThumbsUp class="bg-red-950 h-10 w-10 p-1 rounded-sm"/>
                            <h1><strong> {{ user(notification) }} </strong> liked your profile <span class="text-[0.7rem] text-gray-300">{{ dayjs(notification.created_at).fromNow() }}</span></h1>
                            <XSquare class="bg-red-950 h-10 w-10 p-1 rounded-sm"/>
                        </div>
                    </div>

                    <!-- <h3 class="text-center">
                     No notifications
                    </h3> -->
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
