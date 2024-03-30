<script setup>
import { ref, onMounted, reactive } from 'vue';
import { Head, usePage, Link, router, useForm } from '@inertiajs/vue3';
import StaffLayout from '@/Layouts/StaffLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import dayjs from 'dayjs';
import { Trash2, Pencil, ShieldAlert, Save, Boxes, Plus } from 'lucide-vue-next';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    policies: Array
})

const states = reactive({
    create: false,
    edit: false,
});

const selectedPolicyID = ref(0);
const title = ref('');
const content = ref('');

const create = () =>
{
    router.post(route('staff.dashboard.policies.store'), {
        title: title.value,
        content: content.value,
    },
    {
        preserveScroll: true,
        onSuccess: () => {
            states.create = !states.create;
        }
    });
};

const editToggle = (policy) =>
{
    states.edit = !states.edit;

    if (states.edit)
    {
        selectedPolicyID.value = policy.id;
        title.value = policy.title;
        content.value = policy.content;
    }
    else
    {
        selectedPolicyID.value = 0;
    }
}

const edit = () => {
    router.patch(route('staff.dashboard.policies.update', { policy: selectedPolicyID.value }),
    {
        title: title.value,
        content: content.value,
    },
    {
        preserveScroll: true,
        onSuccess: () => {
            states.edit = false;
            selectedPolicyID.value = 0;
            title.value = '';
            content.value = '';
        }
    });
}

const del = (policy) =>
{
    router.delete(route('staff.dashboard.policies.destroy', { policy: policy }));
}

</script>

<template>
    <Head title="Edit page" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold ml-[4rem] text-xl text-white leading-tight">
                Policy Managment
            </h2>
        </template>

        <div>
            <div class="mx-auto ml-[5rem]">
                <div class="shadow rounded-sm text-white">
                    <div class="grid grid-flow-col">
                        <div class="bg-gray-700">
                            <div class="mx-[1rem] mt-[1rem] bg-gray-600 p-[2rem] rounded-sm">
                                <ShieldAlert :size="30" class="text-orange-400 float-right"/>
                                <p class="w-[40rem]">You can add, edit and delete policies using the interface</p>
                            </div>

                            <div class="m-[1rem] bg-gray-600 p-[2rem]">
                                <div class="flex justify-between mb-[1rem]">
                                    <h1 class="font-extrabold my-auto">Policies</h1>
                                    <PrimaryButton class="justify-center" @click="states.create = !states.create"><Plus class="mr-5"/> create policy</PrimaryButton>
                                </div>

                                <Transition name="fade">
                                <div
                                    v-if="states.create"
                                    class="bg-gray-700 my-[1rem] p-[1rem] rounded-md">
                                    <p>Create Form</p>
                                    <InputLabel class="text-white my-[1rem]">Title:</InputLabel>
                                    <TextInput class="w-full text-black" v-model="title"/>
                                    <InputLabel class="text-white my-[1rem]">Content:</InputLabel>
                                    <textarea class="border-gray-300 text-black focus:border-red-500 focus:ring-red-500 rounded-[0.2rem] shadow-sm w-full" v-model="content"></textarea>
                                    <PrimaryButton class="justify-center w-full my-[1rem]" @click="create">create</PrimaryButton>
                                </div>
                                </Transition>

                                <div class="grid grid-cols-5 gap-2">
                                    <div
                                        v-for="policy in props.policies"
                                        :key="policy"
                                        :class="selectedPolicyID === policy.id ? 'bg-gray-900' : ''"
                                        class="bg-gray-700 p-[1rem] rounded-md text-center">
                                        <div class="float-right flex">
                                            <Pencil class="text-orange-500" @click="editToggle(policy)"/>
                                            <Trash2 class="text-red-500 ml-[1rem]" @click="del(policy)"/>
                                        </div>

                                        <div
                                            class="mt-[2rem]">
                                            <h1 class="text-xl font-bold ">{{ policy.title }}</h1>
                                            <p class="italic text-gray-400">Updated: {{ dayjs(policy.created_at).format('DD/MM/YYYY') }}</p>
                                            <p class="italic text-gray-400">Created: {{ dayjs(policy.updated_at).format('DD/MM/YYYY') }}</p>
                                            <Link :href="route('policies.show', policy)"><PrimaryButton class="m-2 w-full justify-center">VIEW</PrimaryButton></Link>
                                        </div>
                                    </div>
                                </div>

                                <Transition name="fade">
                                    <div
                                        v-if="states.edit"
                                        class="bg-gray-700 my-[1rem] p-[1rem] rounded-md">
                                        <p>Edit Form</p>
                                        <InputLabel class="text-white my-[1rem]">Title:</InputLabel>
                                        <TextInput class="w-full text-black" v-model="title"/>
                                        <InputLabel class="text-white my-[1rem]">Content:</InputLabel>
                                        <textarea class="border-gray-300 text-black focus:border-red-500 focus:ring-red-500 rounded-[0.2rem] shadow-sm w-full resize-none h-[20rem]" v-model="content"></textarea>
                                        <PrimaryButton class="justify-center w-full my-[1rem]" @click="edit">edit</PrimaryButton>
                                    </div>
                                </Transition>
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
