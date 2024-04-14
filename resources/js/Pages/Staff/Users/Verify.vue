<script setup>
import { ref, reactive } from 'vue';
import { Head, Link, router, useForm, usePage } from '@inertiajs/vue3';
import { X } from 'lucide-vue-next';
import StaffLayout from '@/Layouts/StaffLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { usePermissions } from '@/Composables/usePermissions';
import PermissionErrorMsg from '@/Components/PermissionErrorMsg.vue';
import dayjs from 'dayjs';

const { hasPerm } = usePermissions();

const page = usePage();

const props = defineProps({
    identities: Object,
});

const states = reactive({
    identityToggle: false,
    suspendToggle: false,
});

const chosenIdentity = ref([]);

const form = useForm({
    valid: '',
});

const identityToggle = (identity) => {
    states.identityToggle = true;
    chosenIdentity.value = identity;
    form.identity = chosenIdentity.value.id;
};

const verify = (status) => {
    form.valid = status;
}

const submit = () => {
    form.patch(route('staff.dashboard.identity.update', {
        identity: chosenIdentity.value.id,
        status: form.valid,
    }), {
        onSuccess: () => {
            states.identityToggle = false;
            chosenIdentity.value = [];
        }
    });
};
</script>

<template>
    <Head title="Verify Users" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-white leading-tight">
                Verify users
            </h2>
        </template>

        <div>
            <div class="mx-auto">
                <div v-if="hasPerm('view identities')" class="shadow rounded-sm text-white">
                    <div class="grid grid-flow-col">
                        <div class="bg-gray-700 grid grid-flow-col">
                            <div v-if="props.identities.length != 0"
                                class="m-[1rem] bg-gray-600 p-[2rem] rounded-sm">
                                <table class="w-full bg-gray-700 rounded-sm">
                                <thead>
                                    <tr>
                                        <th class="p-[0.5rem]">ID</th>
                                        <th>Firstname</th>
                                        <th>Surname</th>
                                        <th>Date of birth</th>
                                        <th>Verified</th>
                                        <th>Created</th>
                                        <th>Updated</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="identity in props.identities"
                                        :key="identity"
                                        class="bg-gray-500 text-center hover:bg-gray-800"
                                        :class=" chosenIdentity.id === identity.id ? 'bg-gray-900' : ''"
                                        @click="identityToggle(identity)"
                                        >
                                        <td>{{ identity.user.id }}</td>
                                        <td>{{ identity.user.first_name }}</td>
                                        <td>{{ identity.user.surname }}</td>
                                        <td>{{ identity.user.dob }}</td>
                                        <td v-if="identity.valid === 0" class="text-gray-400">Not Verified</td>
                                        <td v-else-if="identity.valid === 2" class="text-green-400">Valid</td>
                                        <td v-else class="text-red-400">Not Valid</td>
                                        <td>{{ dayjs(identity.created_at).format('DD/MM/YYYY hh:mm:ss') }}</td>
                                        <td>{{ dayjs(identity.updated_at).format('DD/MM/YYYY hh:mm:ss') }}</td>
                                    </tr>
                                </tbody>
                                </table>
                            </div>
                            <div v-else class="p-[1rem]">
                                <h1 class="text-center">No identities in the system</h1>
                            </div>

                            <Transition name="fade">
                            <div
                                v-if="states.identityToggle"
                                class="m-[1rem] bg-gray-600 p-[2rem] rounded-sm">
                                <X :size="20" class="float-right" @click="states.identityToggle = false"/>
                                <h1 class="text-center">Identity Information</h1>

                                <div class="my-2 p-2 bg-gray-800 rounded-sm">
                                    <h1 class="text-orange-400 text-xl">Notice</h1>
                                    <h1>Make sure that the user information is valid, otherwise invalidate the user</h1>
                                </div>

                                <div class="m-[1rem] bg-gray-500 p-[2rem] rounded-sm">
                                    <section class="p-2 bg-gray-700 rounded-sm text-center">
                                        <div class="flex flex-wrap justify-evenly m-[0.2rem]">
                                            <h1 class="w-[50%]">ID</h1>
                                            <p class="bg-gray-500 w-[50%]">{{ chosenIdentity.id }}</p>
                                        </div>

                                        <div class="flex flex-wrap justify-evenly m-[0.2rem]">
                                            <h1 class="w-[50%]">Firstname</h1>
                                            <p class="bg-gray-500 w-[50%]">{{ chosenIdentity.user.first_name }}</p>
                                        </div>

                                        <div class="flex flex-wrap justify-evenly m-[0.2rem]">
                                            <h1 class="w-[50%]">Surname</h1>
                                            <p class="bg-gray-500 w-[50%]">{{ chosenIdentity.user.surname }}</p>
                                        </div>

                                        <div class="flex flex-wrap justify-evenly m-[0.2rem]">
                                            <h1 class="w-[50%]">Date of birth</h1>
                                            <p class="bg-gray-500 w-[50%]">{{ chosenIdentity.user.dob }}</p>
                                        </div>

                                        <div class="flex flex-wrap justify-evenly m-[0.2rem]">
                                            <h1 class="w-[50%]">Verified</h1>
                                            <p v-if="chosenIdentity.valid" class="bg-gray-500 w-[50%]">Yes</p>
                                            <p v-else class="bg-gray-500 w-[50%]"> No</p>
                                        </div>
                                    </section>

                                    <section>
                                         <div class="grid grid-cols-2">
                                            <div>
                                                <h1>Self image</h1>
                                                <img
                                                class="h-[100%]  float-left"
                                                :src="route('staff.dashboard.identity.evidence', chosenIdentity.self)"
                                                :alt="chosenIdentity.self + ' evidence '"
                                                draggable="false"
                                                />
                                            </div>

                                            <div>
                                                <h1>Document image</h1>
                                                <img
                                                class="h-[100%] float-left"
                                                :src="route('staff.dashboard.identity.evidence', chosenIdentity.document)"
                                                :alt="chosenIdentity.document + ' evidence '"
                                                draggable="false"
                                                />
                                            </div>
                                        </div>
                                    </section>

                                    <form @submit.prevent="submit" class="mt-[2rem]" v-if="hasPerm('verify users')">
                                        <PrimaryButton class="w-full mt-2 justify-center" @click="verify(2)">Valid</PrimaryButton>
                                        <PrimaryButton class="w-full mt-2 justify-center" @click="verify(1)">Invalid</PrimaryButton>
                                    </form>
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
