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

const { hasPerm } = usePermissions();

const page = usePage();

const props = defineProps({
    reports: Object,
});

const states = reactive({
    reportToggle: false,
    suspendToggle: false,
});

const chosenReport = ref([]);

const form = useForm({
    report: '',
    handler: page.props.auth.user.id,
    note: '',
    from: '',
    to: '',
    suspended: 0,
});

const reportToggle = (report) => {
    states.reportToggle = true;
    chosenReport.value = report;
    form.report = chosenReport.value.id;
};

const suspendToggle = () => {
    states.suspendToggle = !states.suspendToggle;
}

const suspend = () => {
    form.from !== '' && form.to !== '' ? form.suspended = 1 : form.suspended = 0;
}

const submit = () => {
    form.post(route('staff.dashboard.suspension.store'), {
         onSuccess: () => {
            states.reportToggle = false; form.reset();
            router.patch(route('staff.dashboard.report.update', chosenReport.value ));
        }
    })
};
</script>

<template>
    <Head title="Reports" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-white leading-tight">
                Reports
            </h2>
        </template>

        <div>
            <div class="mx-auto">
                <div v-if="hasPerm('view reports')" class="shadow rounded-sm text-white">
                    <div class="grid grid-flow-col">
                        <div class="bg-gray-700 grid grid-flow-col">
                            <div class="m-[1rem] bg-gray-600 p-[2rem] rounded-sm">
                                <section class="bg-gray-700 rounded-sm p-2 grid grid-flow-col text-center">
                                    <h1>ID</h1>
                                    <h1>Suspect</h1>
                                    <h1>Complainant</h1>
                                    <h1>Violated Rule</h1>
                                    <h1>Status</h1>
                                </section>

                                <div
                                    v-for="report in props.reports"
                                    :key="report"
                                    class="bg-gray-500 rounded-sm p-2 grid grid-flow-col text-center hover:bg-gray-800"
                                    @click="reportToggle(report)"
                                    >
                                    <h1>{{ report.id }}</h1>
                                    <h1>{{ report.suspect.first_name }} {{ report.suspect.surname }} ({{ report.suspect.username }})</h1>
                                    <h1>{{ report.complainant.first_name }} {{ report.complainant.surname }} ({{ report.complainant.username }})</h1>
                                    <h1>{{ report.violated_rule }}</h1>
                                    <h1 v-if="report.status === 0" class="text-gray-400">Unsolved</h1>
                                    <h1 v-else class="text-green-400">Resolved</h1>
                                </div>
                            </div>

                            <Transition name="fade">
                            <div
                                v-if="states.reportToggle"
                                class="m-[1rem] bg-gray-600 p-[2rem] rounded-sm">
                                <X :size="20" class="float-right" @click="states.reportToggle = false"/>
                                <h1 class="text-center">Report Information</h1>

                                <div class="m-[1rem] bg-gray-500 p-[2rem] rounded-sm">
                                    <section class="p-2 bg-gray-700 rounded-sm text-center">
                                        <div class="flex flex-wrap justify-evenly m-[0.2rem]">
                                            <h1 class="w-[50%]">ID</h1>
                                            <p class="bg-gray-500 w-[50%]">{{ chosenReport.id }}</p>
                                        </div>

                                        <div class="flex flex-wrap justify-evenly m-[0.2rem]">
                                            <h1 class="w-[50%]">Suspect</h1>
                                            <p class="bg-gray-500 w-[50%]">{{ chosenReport.suspect.first_name }} {{ chosenReport.suspect.surname }} ({{ chosenReport.suspect.username }})</p>
                                        </div>

                                        <div class="flex flex-wrap justify-evenly m-[0.2rem]">
                                            <h1 class="w-[50%]">Complainant</h1>
                                            <p class="bg-gray-500 w-[50%]">{{ chosenReport.complainant.first_name }} {{ chosenReport.complainant.surname }} ({{ chosenReport.complainant.username }})</p>
                                        </div>

                                        <div class="flex flex-wrap justify-evenly m-[0.2rem]">
                                            <h1 class="w-[50%]">Violated Rule</h1>
                                            <p class="bg-gray-500 w-[50%]">{{ chosenReport.violated_rule }}</p>
                                        </div>
                                    </section>

                                    <section class="my-[1rem]">
                                        <h1 class="bg-gray-700 p-2 rounded-sm">Extra Information</h1>
                                        <p class=" bg-gray-600 p-2 rounded-sm">{{ chosenReport.extra_information }}</p>
                                    </section>

                                    <section class="my-[1rem] opacity-60">
                                        <h1 class="text-center p-[0.5rem]">Chat Room</h1>
                                        <div class="grid grid-flow-col text-center p-2 bg-gray-700 rounded-sm">
                                            <h1>Room name</h1>
                                            <h1>Other user</h1>
                                        </div>
                                        <div class="grid grid-flow-col text-center p-2 bg-gray-600 rounded-sm">
                                            <h1>tuwtuewwersd</h1>
                                            <h1>BOGI</h1>
                                        </div>
                                    </section>

                                    <form @submit.prevent="submit">
                                        <section>
                                            <div class="my-[1rem]">
                                                <InputLabel class="text-white">Note (did the user break the guidlines, etc..)</InputLabel>
                                                <TextInput class="w-full text-black" v-model="form.note"/>
                                                <PrimaryButton v-if="hasPerm('suspend')" class="w-full justify-center mt-[1rem]" @click.prevent="suspendToggle">suspend</PrimaryButton>
                                            </div>
                                        </section>

                                        <section
                                            v-if="states.suspendToggle"
                                            class="my-[1rem]">
                                            <p>Select length to suspend the user for</p>
                                            <div class="my-[1rem]">
                                                <InputLabel class="text-white">From</InputLabel>
                                                <TextInput class="w-full text-black" type="datetime-local" v-model="form.from"/>
                                            </div>

                                            <div class="my-[1rem]">
                                                <InputLabel class="text-white">To</InputLabel>
                                                <TextInput class="w-full text-black" type="datetime-local" v-model="form.to"/>
                                            </div>
                                        </section>

                                        <PrimaryButton v-if="hasPerm('close report')" class="w-full justify-center" @click="suspend">close case</PrimaryButton>
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
