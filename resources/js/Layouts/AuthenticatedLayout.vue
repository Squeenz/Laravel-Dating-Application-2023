<script setup>
import { onMounted } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import Navigation from '@/Components/Navigation.vue';

const page = usePage();

onMounted(() => {
    Echo.private('notification')
            .listen('UserNotification', (e) => {
                if (page.props.auth.user.id === e.notification.other_user_id) {
                        router.post(route('notification.store'), {
                        user_id: e.notification.other_user_id,
                        other_user_id: e.notification.user_id,
                        type: e.notification.type,
                        read: 0,
                    });
                }
            });
    Echo.private('matches')
            .listen('MatchFound', (e) => {
                router.post(route('matchmaking.store'), {
                    user1_id: e.user1,
                    user2_id: e.user2,
                });
            });
    Echo.private('chatRooms')
            .listen('CreateChatRoom', (e) => {
                router.post(route('chat.room.store'), {
                    user1_id: e.user1,
                    user2_id: e.user2,
                });
            });
});
</script>

<template>
    <div>
        <div class="min-h-screen bg-[#1A1A1A]">
            <Navigation />

            <!-- Page Heading -->
            <header class="bg-[#242424] shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
