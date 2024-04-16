<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage, Link, router } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref, onMounted } from 'vue';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';

const allChatMessages = ref([]);

const props = defineProps({
    roomID: Number,
    chatRooms: Array,
    chatMessages: Array,
    otherUser: Object,
});

dayjs.extend(relativeTime);

const page = usePage();
const user = page.props.auth.user;
const currentMessage = ref('');
const chatRoomName = page.url.split('/')[2];

onMounted(() => {
    if (route().current('chat.app.show'))
    {
        props.chatMessages.forEach(chatMessage => {
            allChatMessages.value.push(chatMessage);
        });

        Echo.private('chat.' + chatRoomName)
            .listen('NewMessage', (e) => {
                allChatMessages.value.push(e.chatMessage)
            });
    }
});

const message = () => {
    router.post(route('chat.store'), {
        chat_room_id: props.roomID,
        user_id: user.id,
        content: currentMessage.value,
    });
    currentMessage.value = "";
};
</script>

<template>
    <Head title="Chats" />

    <AuthenticatedLayout>
        <div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="sm:h-[51.3rem] sm:py-[1rem] sm:px-[1rem] bg-[#0A0A0A] shadow rounded-sm text-white">

                    <div>
                        <div class="grid grid-flow-row w-[20rem] float-left">
                            <div class="p-6">Chat Rooms</div>

                            <div class="overflow-y-auto no-scrollbar h-[45rem] scroll-smooth">
                                <Link
                                v-for="chatRoom in chatRooms"
                                :key="chatRoom.id"
                                :href="route('chat.app.show', chatRoom.name)"
                                class="p-1 grid grid-cols-3 m-2 rounded-xl"
                                :class="route().current('chat.app.show', chatRoom.name) ? 'bg-red-900' : 'bg-gray-600'"
                                >
                                    <img class="h-40 w-30 rounded-xl" :src="route('photos.get', otherUser.primaryPhoto[0].photo)" draggable="false">
                                    <h1 v-if="chatRoom.user2.id !== user.id" class="my-auto mx-[3rem] font-bold">{{ chatRoom.user2.first_name }} {{ chatRoom.user2.surname }} ({{ chatRoom.user2.username }})</h1>
                                    <h1 v-else class="my-auto font-bold">{{ chatRoom.user1.first_name }} {{ chatRoom.user1.surname }} ({{ chatRoom.user1.username }})</h1>
                                </Link>
                            </div>
                        </div>

                        <div class="ml-[25rem]">
                            <div class="p-6">Chat's Messages</div>
                            <div v-if="allChatMessages && allChatMessages.length !== 0" class="overflow-y-auto no-scrollbar h-[38rem] scroll-smooth">
                                <div
                                    class="bg-gray-500 p-4 m-5 rounded-lg text-white w-[30rem]"
                                    :class="user.id == chatMessage.user_id ? 'float-right bg-red-900' : 'float-left'"
                                    v-for="chatMessage in allChatMessages"
                                    :key="chatMessage"
                                    >
                                        <div
                                        v-if="user.id == chatMessage.user_id"
                                            >
                                            <h1>{{  chatMessage.content }}</h1> <br/>
                                            <h6 class=" float-right text-[0.8rem] text-gray-300">{{ dayjs(chatMessage.created_at).fromNow() }}</h6>
                                        </div>

                                        <div
                                        v-else
                                            >
                                            <h1>{{   otherUser.information.first_name + " " + otherUser.information.surname + " (" + otherUser.information.username + ")" }}: {{  chatMessage.content }} </h1> <br/>
                                            <h6 class=" float-right text-[0.8rem] text-gray-300">{{ dayjs(chatMessage.created_at).fromNow() }}</h6>
                                        </div>
                                </div>
                            </div>

                            <div v-if="!route().current('chat.app.show')">
                                <h1 class="text-center">Select a chat room.</h1>
                            </div>
                            <div v-else>
                                <textarea class="resize-none w-full text-black" v-model="currentMessage" name="message"></textarea>
                                <PrimaryButton class="w-full justify-center" @click="message">Send Message</PrimaryButton>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
