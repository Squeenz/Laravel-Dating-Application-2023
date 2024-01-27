<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage, Link, router } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref } from 'vue';

const props = defineProps({
    roomID: Number,
    chatRooms: Array,
    chatMessages: Array,
});

const page = usePage();
const user = page.props.auth.user;

const currentMessage = ref('');

const message = () => {
    router.post(route('chat.store'), {
        chat_room_id: props.roomID,
        user_id: user.id,
        content: currentMessage.value,
    });
    currentMessage.value = "";
};

console.log(props.chatMessages);
</script>

<template>
    <Head title="Chats" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Chats</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <div>
                        <div class="grid grid-flow-row w-[25rem] float-left">
                            <div class="p-6 text-gray-900">Chat Rooms</div>

                            <Link
                            v-for="chatRoom in chatRooms"
                            :key="chatRoom.id"
                            :href="route('chat.app.show', chatRoom.name)"
                            class="p-1 grid grid-cols-2 m-2 rounded-xl"
                            :class="route().current('chat.app.show', chatRoom.name) ? 'bg-red-900' : 'bg-slate-300'"
                            >
                                <div class="h-20 w-20 bg-red-500 rounded-full text-center">IMG</div>
                                <h1 class="mt-[1rem]">{{ chatRoom.user2.first_name }} {{ chatRoom.user2.surname }} {{ chatRoom.user2.username }}</h1>
                            </Link>
                        </div>

                        <div class="ml-[25rem]">
                            <div class="p-6 text-gray-900">Chat's Messages</div>
                            <div v-if="chatMessages && chatMessages.length !== 0">
                                <div
                                    class="bg-gray-500 p-4 m-5 rounded-lg text-white w-[30rem]"
                                    :class="user.id == chatMessage.user_id ? 'float-right bg-red-900' : 'float-left'"
                                    v-for="chatMessage in chatMessages"
                                    :key="chatMessage.id"
                                    >
                                        <p v-if="user.id == chatMessage.user_id">{{  chatMessage.content }} <br/> {{ chatMessage.created_at }}</p>
                                        <p v-else>{{ chatMessage.user2.first_name + " " + chatMessage.user2.surname + " " + chatMessage.user2.username }}: {{  chatMessage.content }} <br/> {{ chatMessage.created_at }}</p>

                                </div>
                            </div>

                            <div v-if="!route().current('chat.app.show')">
                                <h1 class="text-center">No chat to load</h1>
                            </div>
                            <div v-else>
                                <textarea class="resize-none w-full" v-model="currentMessage"></textarea>
                                <PrimaryButton class="w-full justify-center" @click="message">Send Message</PrimaryButton>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
