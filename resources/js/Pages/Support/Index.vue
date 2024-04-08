<script setup>
import { Head, Link, useForm, usePage, router } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Loader, Check } from 'lucide-vue-next';
import { onMounted, ref } from 'vue';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';

dayjs.extend(relativeTime);

const page = usePage();

const props = defineProps({
    tickets: Object,
    chatMessages: Object,
});

const message = ref('');

const sendMessage = () => {
    router.post(route('support.message.store'), {
        content: message.value,
        support_chat_room: props.chatMessages[0].support_chat_room,
    },
    {
        onSuccess: () => {
            message.value = '';
        }
    })
}

</script>

<template>
    <Head title="Tickets" />

    <GuestLayout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="sm:py-[2rem] bg-[#0A0A0A] shadow rounded-sm">
                <div v-if="props.tickets.length != 0" class="flex grid-flow-col text-white justify-evenly">
                    <div class="p-2 w-[50%]">
                        <h1 class="text-center mb-[1rem]">Tickets</h1>
                        <div
                            class="overflow-y-auto no-scrollbar h-[38rem] scroll-smooth">
                            <Link
                            v-for="ticket in props.tickets"
                            :key="ticket"
                            class="m-[1rem] rounded-md text-center"
                            :href="route('support.show', { supportTicket: ticket })"
                            >
                                <div
                                    :class="ticket.status === 0 || ticket.status === 1 ? 'bg-red-500' : 'bg-green-500' "
                                    class="p-1 rounded-t-md">
                                    <Loader class="float-left mr-[1rem]"/>
                                    <h1 v-if="ticket.status === 0"> Unsolved </h1>
                                    <h1 v-else-if="ticket.status === 1"> In Process </h1>
                                    <h1 v-else> Completed </h1>
                                </div>

                                <h1 class="bg-gray-800 p-1">Reason: {{ ticket.reason }}</h1>
                                <h1 class="bg-gray-800 p-1 rounded-b-md">Created: {{ dayjs(ticket.created_at).format('DD/MM/YYYY hh:mm:ss A') }}</h1>
                            </Link>
                        </div>
                    </div>

                    <div
                        class="p-2 w-full">
                        <h1 class="text-center mb-[1rem]">Support Chat</h1>

                        <div class="overflow-y-auto no-scrollbar h-[29rem] scroll-smooth">
                            <div
                                class="bg-gray-500 p-4 m-5 rounded-lg text-white w-[30rem]"
                                :class="message.user === page.props.auth.user.id ? 'float-right bg-red-900' : 'float-left'"
                                v-for="message in props.chatMessages"
                                :key="message"
                                >
                                    <div
                                    v-if="message.user === page.props.auth.user.id"
                                        >
                                        <h1>{{ message.content }} </h1> <br/>
                                        <h6 class=" float-right text-[0.8rem] text-gray-300"> {{ dayjs(message.created_at).fromNow() }} </h6>
                                    </div>

                                    <div
                                    v-else
                                        >
                                        <h1 class="font-bold">Agent</h1>
                                        <h1>{{  message.content }}</h1>
                                        <h6 class=" float-right text-[0.8rem] text-gray-300"> {{ dayjs(message.created_at).fromNow() }} </h6>
                                    </div>
                            </div>
                        </div>

                        <div>
                            <textarea class="resize-none w-full text-black h-[8rem]" v-model="message" name="message"></textarea>
                            <PrimaryButton class="w-full justify-center" @click="sendMessage">Send Message</PrimaryButton>
                        </div>
                    </div>
                </div>
                <div v-else class="text-center p-[1rem] rounded-md text-white h-[36rem]">
                    <h1> You have no tickets</h1>
                </div>
          </div>
    </div>
    </GuestLayout>
</template>
