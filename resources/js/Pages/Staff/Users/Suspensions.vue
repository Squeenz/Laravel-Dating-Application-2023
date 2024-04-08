<script setup>
import { ref, reactive } from 'vue';
import { Head, Link, router, useForm, usePage } from '@inertiajs/vue3';
import { X } from 'lucide-vue-next';
import StaffLayout from '@/Layouts/StaffLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import dayjs from 'dayjs';

const page = usePage();

const props = defineProps({
    suspensions: Object,
});
</script>

<template>
    <Head title="Reports" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold ml-[4rem] text-xl text-white leading-tight">
                Reports
            </h2>
        </template>

        <div>
            <div class="mx-auto">
                <div class="shadow rounded-sm text-white">
                    <div class="grid grid-flow-col">
                        <div class="bg-gray-700 grid grid-flow-col">
                            <div class="m-[1rem] bg-gray-600 p-[2rem] rounded-sm">

                                <table class="w-full bg-gray-700 rounded-sm">
                                <thead>
                                    <tr>
                                    <th class="p-[0.5rem]">ID</th>
                                    <th>Report ID</th>
                                    <th>Handler</th>
                                    <th>Note</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Created</th>
                                    <th>Suspended</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="suspension in props.suspensions"
                                        :key="suspension"
                                        class="bg-gray-500 text-center hover:bg-gray-800"
                                        >
                                        <td class="p-[0.5rem]">{{ suspension.id }}</td>
                                        <td>{{ suspension.report }}</td>
                                        <td>{{ suspension.handler }}</td>
                                        <td>{{ suspension.note }}</td>
                                        <td>{{ dayjs(suspension.from).format('DD/MM/YYYY mm:hh:ss') }}</td>
                                        <td>{{ dayjs(suspension.to).format('DD/MM/YYYY mm:hh:ss') }}</td>
                                        <td>{{ dayjs(suspension.created_at).format('DD/MM/YYYY mm:hh:ss') }}</td>
                                        <td v-if="suspension.suspended === 1" class="text-red-300"> Yes</td>
                                        <td v-else class="text-green-300">No</td>
                                    </tr>
                                </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
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
