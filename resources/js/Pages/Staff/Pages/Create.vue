<script setup>
import { ref, onMounted } from 'vue';
import { Head, usePage, Link, router, useForm } from '@inertiajs/vue3';
import StaffLayout from '@/Layouts/StaffLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Trash2, Pencil, ShieldAlert, Save, UserPlus, X } from 'lucide-vue-next';
import dayjs from 'dayjs';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import { usePermissions } from '@/Composables/usePermissions';
import PermissionErrorMsg from '@/Components/PermissionErrorMsg.vue';

const { hasPerm } = usePermissions();

const page = usePage();

const props = defineProps({
    pages: Array,
});

const createForm = useForm({
    page_name: '',
    slug: '',
});

const editForm = useForm({
    page_name: '',
    slug: '',
});

const editing = ref(false);
const pageID = ref(0);

const edit = (id) => {
    editing.value = !editing.value;
    pageID.value = id;
};

</script>

<template>
    <Head title="Create a page" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-white leading-tight">
                Page creation
            </h2>
        </template>

        <div>
            <div class="mx-auto">
                <div v-if="hasPerm('view pages controller')" class="shadow rounded-sm text-white">
                    <div class="grid grid-flow-col">
                        <div v-if="hasPerm('add page controller')" class="bg-gray-700">
                            <div class="mx-[1rem] mt-[1rem] bg-gray-600 p-[2rem] rounded-sm">
                                <ShieldAlert :size="30" class="text-orange-400 float-right"/>
                                <p class="w-[40rem]">The page name is the visible title that users encounter throughout the site, including in navigation bars.</p>
                                <p class="w-[40rem]">The page slug serves as the internal identifier for backend processes and is used in the URL. It must adhere to URL standards to ensure validity.</p>
                            </div>

                            <form class="p-5" @submit.prevent="createForm.post(route('staff.dashboard.pages.store'), { onSuccess: () => { createForm.reset(); } })">
                                <div>
                                    <InputLabel class="text-white">Page name:</InputLabel>
                                    <InputError :message="createForm.errors.page_name"/>
                                    <TextInput class="w-full text-black" v-model="createForm.page_name"/>
                                </div>
                                <div>
                                    <InputLabel class="text-white">Page slug:</InputLabel>
                                    <InputError :message="createForm.errors.slug"/>
                                    <TextInput class="w-full text-black" v-model="createForm.slug"/>
                                </div>
                                <PrimaryButton class="my-[1rem] w-full justify-center">Create</PrimaryButton>
                            </form>

                        </div>

                        <div v-if="hasPerm('view pages controller')" class="bg-gray-600 text-center grid-flow-col">
                            <div class="flex justify-around p-2 m-2 bg-gray-700 rounded-sm">
                                <h1>ID</h1>
                                <p>Name</p>
                                <p>Slug</p>
                                <p>Created Date</p>
                                <p>Updated Date</p>
                                <p v-if="hasPerm('edit page component')">Edit</p>
                                <p v-if="hasPerm('delete page component')">Delete</p>
                            </div>

                            <div v-for="page in page.props.pages" :key="page.id">
                                <div class="flex justify-around p-2 m-2 bg-gray-700 rounded-sm">
                                    <h1 class="my-auto mx-2">{{ page.id }}</h1>
                                    <p class="my-auto mx-2">{{ page.page_name }}</p>
                                    <p class="my-auto mx-2"><span class="italic text-gray-500">/page/{{ page.slug }}</span></p>
                                    <p class="my-auto mx-2">{{ dayjs(page.created_at).format('DD/MM/YY') }}</p>
                                    <p class="my-auto mx-2">{{ dayjs(page.updated_at).format('DD/MM/YY') }}</p>
                                    <PrimaryButton v-if="hasPerm('edit page component')" @click="edit(page.id)"><Pencil :size="20"/></PrimaryButton>

                                    <Link v-if="hasPerm('delete page component')" :href="route('staff.dashboard.pages.destroy', page.id)" method="delete" as="button"><Trash2 :size="20"/></Link>
                                </div>

                                <form
                                    @submit.prevent="editForm.patch(route('staff.dashboard.pages.update', page.id), { onSuccess: () => { editing = false;} })"
                                    v-if="editing === true && page.id === pageID && hasPerm('edit page component')" class="flex justify-around p-2 m-2 bg-gray-700 rounded-sm"
                                    >
                                    <h1 class="my-auto mx-2">{{ page.id }}</h1>
                                    <TextInput v-model="editForm.page_name" class="text-black w-full h-full my-auto"/>
                                    <TextInput v-model="editForm.slug" class="text-black w-full h-full my-auto"/>
                                    <p class="my-auto mx-2">{{ dayjs(page.created_at).format('DD/MM/YY') }}</p>
                                    <p class="my-auto mx-2">{{ dayjs(page.updated_at).format('DD/MM/YY') }}</p>

                                    <section v-if="hasPerm('edit page component')">
                                        <PrimaryButton @click="edit(page.id)"><X :size="20"/></PrimaryButton>
                                        <PrimaryButton><Save :size="20"/></PrimaryButton>
                                    </section>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <PermissionErrorMsg v-else :role="$page.props.auth.role"/>
            </div>
        </div>
    </StaffLayout>
</template>
