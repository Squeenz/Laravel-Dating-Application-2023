<script setup>
import { ref, onMounted } from 'vue';
import { Head, usePage, Link, router, useForm } from '@inertiajs/vue3';
import StaffLayout from '@/Layouts/StaffLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import dayjs from 'dayjs';

import { Trash2, Pencil, ShieldAlert, Save, Boxes } from 'lucide-vue-next';

import draggable from 'vuedraggable';

import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    layoutID: Number,
    displayBlocksWithContent: Object,
});

const pageComponents = ref([
    { label: 'Text Box', type: 'textBox', new: true },
    // { label: 'Grid List',  type: 'gridList', new: true},
    // { label: 'Special List',  type: 'specialList', new: true },
]);

const pageLayout = ref([]);
const editing = ref(false);
const createNew = ref(false);
const elementID = ref(0);

const title = ref('');
const desc = ref('');

const loadData = (list) =>
{
    for (const key in list) {
        const item = list[key];
        pageLayout.value.push(item);
    }
}

onMounted(() => {
    loadData(props.displayBlocksWithContent);
});

const createNewItem = (element) => {
    router.post(route('staff.dashboard.pages.display.store'),
    {// Data
        layout_id: props.layoutID,
        type: element.type,
        title: element.type === 'gridList' || element.type === 'specialList' ? 'null' : title.value,
        desc: desc.value,
    },
    { // Options
        onSuccess: (response) => {
            createNew.value = false;
            pageLayout.value  = response.props.displayBlocksWithContent;
            title.value = '';
            desc.value = '';
        },
    });
};

const edit = (element) => {
    elementID.value = element.id;
    editing.value = !editing.value;
};

const del = (element) => {
    router.delete(route('staff.dashboard.pages.content.destroy', { content: element.id }),
    {
        onSuccess: (response) => {
            pageLayout.value  = response.props.displayBlocksWithContent;
        }
    }
    );
};

</script>

<template>
    <Head title="Edit page" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold ml-[4rem] text-xl text-white leading-tight">
                Page creation
            </h2>
        </template>

        <div>
            <div class="mx-auto ml-[5rem]">
                <div class="shadow rounded-sm text-white">
                    <div class="grid grid-flow-col">
                        <div class="bg-gray-700">
                            <div class="mx-[1rem] mt-[1rem] bg-gray-600 p-[2rem] rounded-sm">
                                <ShieldAlert :size="30" class="text-orange-400 float-right"/>
                                <p class="w-[40rem]">Drag and drop the display components you want from left to right</p>
                                <p class="w-[40rem]">Then add the information you want to display</p>
                            </div>

                            <div class="m-[1rem] bg-gray-600 p-[2rem]">
                                <h1 class=" font-extrabold">Page Layout</h1>

                                <draggable
                                    v-model="pageLayout"
                                    :group="{ name: 'pageComponents' }"
                                    item-key="id"
                                    @add="createNew = true"
                                 >
                                 <template #item="{element}">
                                    <div class="my-[1rem] bg-gray-700 p-[2rem] rounded-sm">
                                        <div v-if="element.type === 'textBox'">
                                            <div class="float-right grid grid-flow-col">
                                                <Pencil v-if="createNew != true" class="m-2 text-orange-500" :size="20" @click="edit(element)"/>
                                                <Trash2 class="m-2 text-red-500" :size="20" @click="del(element)"/>
                                            </div>

                                            <h1 class="text-gray-600 font-extrabold">Text Box</h1>

                                            <div v-if="(editing === true && elementID === element.id ) || (createNew === true && element.new === true)">
                                                <InputLabel class="text-white">Title: </InputLabel>
                                                <TextInput class="w-full text-black" v-model="title"/>

                                                <InputLabel class="text-white">Desc: </InputLabel>
                                                <TextInput class="w-full text-black" v-model="desc"/>
                                            </div>
                                            <div v-else>
                                                <p>{{ element.contents[0].title }}</p>
                                                <p>{{ element.contents[0].desc }}</p>
                                            </div>
                                        </div>

                                        <!-- <div v-if="element.type === 'gridList'">
                                            <div class="float-right grid grid-flow-col">
                                                <Pencil class="mr-2 text-orange-500" :size="20"/>
                                                <Trash2 class="ml-2 text-red-500" :size="20"/>
                                            </div>

                                            <h1 class="text-gray-600 font-extrabold">Grid List</h1>

                                            <div
                                                v-for="(content, index) in element.contents"
                                                :key="content"
                                                class="bg-gray-800 p-[0.4rem] rounded-sm my-[0.3rem]">
                                                <Trash2 class="float-left my-[0.9rem] mx-[1rem] text-red-500" :size="20"/>
                                                <h1 class=" font-extrabold">Item {{ index + 1 }}:</h1>
                                                <p> {{ content.desc }}</p>
                                            </div>

                                            <div v-if="editing === true || element.editing === true">
                                                <InputLabel class="text-white">Desc: </InputLabel>
                                                <TextInput class="w-full text-black" v-model="desc"/>
                                            </div>
                                        </div> -->

                                        <!-- <div v-if="element.type === 'specialList'">
                                            <div class="float-right grid grid-flow-col">
                                                <Pencil class="mr-2 text-orange-500" :size="20"/>
                                                <Trash2 class="ml-2 text-red-500" :size="20"/>
                                            </div>

                                            <h1 class="text-gray-600 font-extrabold">Special List</h1>

                                            <div
                                                v-for="(content, index) in element.contents"
                                                :key="content"
                                                class="bg-gray-800 p-[0.4rem] rounded-sm my-[0.3rem]">
                                                <Trash2 class="float-left my-[0.9rem] mx-[1rem] text-red-500" :size="20"/>
                                                <h1 class=" font-extrabold">Item {{ index + 1 }}:</h1>
                                                <p> {{ content.desc }}</p>
                                            </div>

                                            <div v-if="editing === true || element.editing === true">
                                                <InputLabel class="text-white">Desc: </InputLabel>
                                                <TextInput class="w-full text-black" v-model="desc"/>
                                            </div>
                                        </div> -->

                                            <div>
                                                <PrimaryButton v-if="(createNew === true && element.new === true)" @click="createNewItem(element)" class="my-2 w-full justify-center">Add</PrimaryButton>
                                                <PrimaryButton v-if="(editing === true && elementID === element.id )" class="my-2 w-full justify-center">Save</PrimaryButton>
                                            </div>


                                        </div>
                                    </template>
                                </draggable>
                            </div>

                        </div>

                        <div class="bg-gray-600 text-center grid-flow-col">
                            <div class="flex justify-around p-2 m-2 bg-gray-700 rounded-sm">
                                <Boxes/><h1>Page Components</h1>
                            </div>

                            <draggable
                            v-model="pageComponents"
                            :group="{ name: 'pageComponents', pull: 'clone', put: false }"
                            item-key="id"
                            >
                                <template #item="{element}">
                                    <h1 class="m-2 p-2 bg-gray-500 rounded-sm"> {{ element.label }} </h1>
                                </template>
                            </draggable>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </StaffLayout>
</template>
