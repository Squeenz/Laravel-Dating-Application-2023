<script setup>

const props = defineProps({
    type: String,
    content: Object,
});
</script>

<template>
    <div v-if="props.type === 'textBox'">
        <h1 class="text-2xl italic">{{ props.content[0].title }}</h1>
        <p>
            {{ props.content[0].desc }}
        </p>
    </div>

    <div v-if="props.type === 'gridList'">
        <div class="flex flex-wrap justify-center m-2 gap-3">
            <div v-for="(item, index) in props.content"
                :key="item"
                class="bg-[#1A1A1A] p-2 rounded-sm grid grid-flow-col w-[30rem] text-center justify-start"
            >
                <h1 class="bg-red-900 text-center w-[4rem] text-3xl rounded-sm py-[1rem]">{{ index + 1 }}</h1>
                <p class="mx-[1rem] my-auto">
                    {{ item.desc }}
                </p>
            </div>

            <!-- <div class="bg-red-900 p-2 rounded-md grid grid-flow-col w-[30rem] justify-center">
                <h1 class="my-auto text-5xl font-bold">AND MORE</h1>
            </div> -->
        </div>
    </div>

    <div v-if="props.type === 'specialList'">
        <div class="flex flex-wrap justify-center text-white">
            <div class="justify-center m-2 gap-3">
                <div class="bg-red-800 relative rounded-full right-[50%] top-[5.6rem] h-[23rem] w-3 float-right hidden lg:inline-block"></div>

                <div v-for="(item, index) in props.content" :key="item.id" class="bg-[#1A1A1A] p-2 rounded-sm grid grid-flow-col w-[30rem] mx-5 justify-start"
                    :class="item.id % 2 ? 'float-left my-[3rem]' : 'float-right my-[5rem]'">

                    <div class="my-auto h-5 w-0 relative" :class="item.id % 2 ? 'left-[29.6rem]' : 'right-[6.6rem]'">
                        <div class="bg-red-800 rounded-full h-2 w-[6rem] hidden lg:inline-block"> </div>
                    </div>

                    <h1 class="bg-red-900 text-center w-[4rem] text-3xl rounded-sm py-[1rem]">{{ index + 1 }}</h1>

                    <p class="mx-[1rem] my-auto">
                        {{ item.desc }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
