<script setup>
import { Head } from '@inertiajs/vue3';
import { Gavel } from 'lucide-vue-next';
import dayjs from 'dayjs';

const props = defineProps({
    report: Object,
    suspension: Object,
});
</script>

<template>
    <Head title="Suspended" />

    <div class="w-full min-h-screen bg-[#0A0A0A]">
        <div class="p-[6rem]">
            <div class="text-white bg-gray-900 rounded-md p-[5rem] border-b-2 border-gray-800">
                <Gavel class="my-auto mx-auto" :size="100"/>
                <h1 class="text-red-600 my-2">You have been suspended from using our service</h1>

                <section class="bg-gray-800 p-[1rem] flex flex-wrap rounded-sm">
                    <h1>Reason:</h1>
                    <p class="text-gray-400 mx-1">{{ props.report.violated_rule }}</p>
                </section>

                <p class="text-gray-400 my-2">If you think this is a mistake contact our support team</p>
            </div>

            <div class="grid grid-flow-col gap-5">
                <div class=" text-white bg-gray-900 rounded-md p-[1rem] my-[2rem] border-b-2 border-gray-800">
                    <h1>From</h1>
                    <p class="text-gray-400">{{ props.suspension.from }}</p>
                </div>

                <div class=" text-white bg-gray-900 rounded-md p-[1rem] my-[2rem] border-b-2 border-gray-800">
                    <h1>To</h1>
                    <p class="text-gray-400">{{ props.suspension.to }}</p>
                </div>
            </div>
        </div>
    </div>
</template>
