<script setup>
import { ref, onMounted, reactive } from 'vue';
import { Head, usePage, Link, router, useForm } from '@inertiajs/vue3';
import StaffLayout from '@/Layouts/StaffLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import dayjs from 'dayjs';

import { Trash2, Pencil, ShieldAlert, Save, Boxes, Plus } from 'lucide-vue-next';

import draggable from 'vuedraggable';

import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    layoutID: Number,
    displayBlocksWithContent: Object,
});

const pageComponents = ref([
    { label: 'Text Box', type: 'textBox', new: true },
    { label: 'Grid List',  type: 'gridList', new: true},
    { label: 'Special List',  type: 'specialList', new: true },
]);

const pageLayout = ref([]);

const states = reactive({
    editing: false,
    createNew: false,
    addItem: false,
    adding: false,
});

const elementID = ref(0);
const itemIndex = ref(0);
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
    states.adding = true;
    router.post(route('staff.dashboard.pages.display.store'), {
        layout_id: props.layoutID,
        type: element.type,
        title: element.type === 'gridList' || element.type === 'specialList' ? 'null' : title.value,
        desc: desc.value,
    },
    {
        preserveScroll: true,
        onSuccess: (response) => {
            pageLayout.value  = response.props.displayBlocksWithContent;
            title.value = '';
            desc.value = '';
            states.createNew = false;
            states.adding = false;
        },
    });
};

const toggleAddItem = (element) =>
{
    elementID.value = element.id;
    states.addItem = !states.addItem;
}

const addItemToGrid = (content) => {
    states.adding = true;
    router.post(route('staff.dashboard.pages.content.store'), {
        display_block_id: elementID.value,
        title: 'null',
        desc: content,
    },
    {
        preserveScroll: true,
        onSuccess: (response) => {
            pageLayout.value  = response.props.displayBlocksWithContent;
            desc.value = '';
            states.addItem = false;
            states.adding = false;
        },
    });
};

const editToggle = (element, index = 0) => {
    elementID.value = element.id;
    itemIndex.value = index;
    states.editing = !states.editing;
};

const update = (element) => {
    router.patch(route('staff.dashboard.pages.content.update', { content: element.contents[itemIndex.value].id, }), {
        title: element.type != 'textBox' ? 'null' : title.value,
        desc: desc.value,
    },
    {
        preserveScroll: true,
        onSuccess: (response) => {
            pageLayout.value  = response.props.displayBlocksWithContent;
            states.editing = false;
            title.value = '';
            desc.value = '';
        },
    });
}

const delWithRelative = (element) => {
    router.delete(route('staff.dashboard.pages.content.destroyRelative', { content: element.contents[0].id }),{
        preserveScroll: true,
        onSuccess: (response) => {
            pageLayout.value  = response.props.displayBlocksWithContent;
        },
    });
};

const delItem = (element) => {
    router.delete(route('staff.dashboard.pages.content.destroy', { content: element.contents[0].id }),{
        preserveScroll: true,
        onSuccess: (response) => {
            pageLayout.value  = response.props.displayBlocksWithContent;
        },
    });
}

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
                                    @add="states.createNew = false"
                                 >
                                 <template #item="{element}">
                                    <div class="my-[1rem] bg-gray-700 p-[2rem] rounded-sm">
                                        <div v-if="element.type === 'textBox'">
                                            <div class="float-right grid grid-flow-col">
                                                <Pencil v-if="states.createNew != false || element.new != true " class="m-2 text-orange-500" :size="20" @click="editToggle(element)"/>
                                                <Trash2 v-if="states.createNew != false || element.new != true" class="m-2 text-red-500" :size="20" @click="delWithRelative(element)"/>
                                            </div>

                                            <h1 class="text-gray-600 font-extrabold">Text Box</h1>

                                            <div v-if="(states.editing === true && elementID === element.id ) || (states.createNew === false && element.new === true)">
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

                                        <div v-if="element.type === 'gridList' || element.type === 'specialList'">
                                            <div class="float-right grid grid-flow-col">
                                                <Trash2 v-if="states.createNew != false || element.new != true" class="mr-2 text-red-500" :size="20" @click="delWithRelative(element)"/>
                                            </div>

                                            <h1 class="text-gray-600 font-extrabold">List</h1>

                                            <div
                                                v-for="(content, index) in element.contents"
                                                :key="content"
                                                class="bg-gray-800 p-[0.4rem] rounded-sm my-[0.3rem]"
                                                >
                                                    <Pencil class="float-left my-[0.9rem] ml-[0.9rem] text-orange-500" :size="20" @click="editToggle(element, index)"/>
                                                    <Trash2 class="float-left my-[0.9rem] mx-[1rem] text-red-500" :size="20" @click="delItem(element)"/>

                                                    <h1 class=" font-extrabold">Item {{ index + 1 }}:</h1>

                                                    <div v-if="states.editing && index === itemIndex && elementID === element.id">
                                                        <TextInput class="w-[29rem] text-black" v-model="desc"/>
                                                    </div>
                                                    <div v-else>
                                                        <p>{{ content.desc }}</p>
                                                    </div>
                                            </div>

                                            <div
                                                class="bg-gray-800 p-[0.4rem] rounded-sm my-[0.3rem]"
                                                @click="toggleAddItem(element)"
                                                >
                                                <Plus class="float-left my-[0.9rem] mx-[1rem] text-gray-400" :size="20"/>
                                                <h1 v-if="!states.addItem || elementID != element.id" class="my-[0.7rem] font-extrabold text-gray-400">Add Item</h1>
                                                <div v-if="states.addItem && elementID === element.id">
                                                    <h1 class=" my-[0.7rem] font-extrabold text-white">Description: </h1>
                                                    <TextInput class="w-full text-black" v-model="desc"/>
                                                </div>
                                            </div>

                                            <PrimaryButton v-if="states.addItem && elementID === element.id && !element.new && !states.adding" @click="addItemToGrid(desc)" class="my-2 w-full justify-center">Add</PrimaryButton>
                                        </div>

                                        <div>
                                            <PrimaryButton v-if="(states.createNew === false && element.new === true) && !states.addItemToGrid && !states.adding" @click="createNewItem(element)" class="my-2 w-full justify-center">Add</PrimaryButton>
                                            <PrimaryButton v-if="(states.editing === true && elementID === element.id )" @click="update(element)" class="my-2 w-full justify-center">Save</PrimaryButton>
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
