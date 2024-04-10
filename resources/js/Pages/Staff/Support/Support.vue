<script setup>
import { ref, reactive, onMounted } from 'vue';
import { Head, router, usePage } from '@inertiajs/vue3';
import { Loader } from 'lucide-vue-next';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import StaffLayout from '@/Layouts/StaffLayout.vue';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import { usePermissions } from '@/Composables/usePermissions';
import PermissionErrorMsg from '@/Components/PermissionErrorMsg.vue';

const { hasPerm } = usePermissions();

dayjs.extend(relativeTime);

const page = usePage();

const props = defineProps({
    tickets: Object,
    user: Object,
    hasHandler: Boolean,
    selectedTicket: Object,
});

const message = ref('');

const sendMessage = () => {
    router.post(route('support.message.store'), {
        content: message.value,
        support_chat_room: props.selectedTicket.support_chat_room.id,
    },
    {
        onSuccess: () => {
            message.value = '';
        }
    })
}

const selectTicket = (ticket) => {
    router.get(route('staff.dashboard.tickets.show', { supportTicket: ticket }));
};

const selfAssingCase = () => {
    router.patch(route('staff.dashboard.tickets.update.handler.status', { supportTicket: props.selectedTicket }));
}

const updateTicketStatus = (status) => {
    router.patch(route('staff.dashboard.tickets.update.status', { supportTicket: props.selectedTicket, status: status }));
}
</script>

<template>
    <Head title="Tickets" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-white leading-tight">
                Ticket Managment
            </h2>
        </template>

        <div>
            <div class="mx-auto">
                <div v-if="hasPerm('view tickets')" class="shadow rounded-sm text-white">
                    <div class="grid grid-flow-col">
                        <div class="bg-gray-700 grid grid-flow-col">
                            <div class="m-[1rem] bg-gray-600 p-[1rem] rounded-sm">
                                <h1 class="text-center mb-[1rem]">Tickets</h1>
                                <div
                                v-for="ticket in props.tickets"
                                :key="ticket"
                                class="m-[1rem] rounded-md text-center"
                                @click="selectTicket(ticket)"
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
                                </div>
                            </div>

                            <Transition name="fade">
                            <div
                            v-if="props.selectedTicket"
                            class="m-[1rem] bg-gray-600 p-[2rem] rounded-sm">
                                <div class="text-center justify-evenly flex">
                                    <PrimaryButton v-if="!props.hasHandler && hasPerm('self assing ticket') && props.selectedTicket.user !== page.props.auth.user.id" @click="selfAssingCase" class="m-1">SELF ASSING CASE</PrimaryButton>
                                    <section v-if="hasPerm('update tickets')">
                                        <PrimaryButton @click="updateTicketStatus(1)" class="m-1">OPEN TICKET</PrimaryButton>
                                        <PrimaryButton @click="updateTicketStatus(2)" class="m-1">CLOSE TICKET</PrimaryButton>
                                    </section>
                                </div>
                                <div class="p-2 w-full">
                                    <h1 class="text-center mb-[1rem]">Support Chat</h1>

                                    <div class="overflow-y-auto no-scrollbar h-[29rem] scroll-smooth">
                                        <div
                                            class="bg-gray-500 p-4 m-5 rounded-lg text-white w-[30rem]"
                                            :class="message.user === page.props.auth.user.id ? 'float-right bg-red-900' : 'float-left'"
                                            v-for="message in props.selectedTicket.support_chat_room.support_chat_messages"
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
                                                    <h1 class="font-bold"> {{ props.user.firstname }} {{ props.user.surname }} ({{ props.user.username }})</h1>
                                                    <h1>{{  message.content }}</h1>
                                                    <h6 class=" float-right text-[0.8rem] text-gray-300"> {{ dayjs(message.created_at).fromNow() }} </h6>
                                                </div>
                                        </div>
                                    </div>

                                    <div v-if="props.selectedTicket.status != 2 && props.hasHandler && hasPerm('send ticket message') && props.selectedTicket.user !== page.props.auth.user.id">
                                        <textarea class="resize-none w-full text-black h-[8rem]" v-model="message" name="message"></textarea>
                                        <PrimaryButton class="w-full justify-center" @click="sendMessage">Send Message</PrimaryButton>
                                    </div>
                                    <div v-else-if="!props.hasHandler" class="bg-gray-900 p-[2rem] relative bottom-[10rem]">
                                        <h1 class="text-orange-500 text-2xl">Notice</h1>
                                        <p>In order to send a message you need to self assing to the case.</p>
                                    </div>
                                    <PermissionErrorMsg v-if="!hasPerm('send ticket message')" :role="$page.props.auth.role"/>
                                </div>
                            </div>
                            </Transition>
                        </div>
                    </div>
                </div>
                <PermissionErrorMsg v-else :role="$page.props.auth.role"/>
            </div>
        </div>
    </StaffLayout>
</template>

<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
