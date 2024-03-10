<script setup>
import { Head, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import DisplayBlocks from '@/Components/DisplayBlocks.vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    }
});


const text = {
    title: "Why should you choose us?",
    desc: "At Gamer Love, we believe in the power of shared interests, and what better foundation for a relationship than a love for gaming? Here's why you should choose us:",
}


const text2 = {
    title: "How does it work?",
    desc: "Simple, here's a breakdown",
}

const features = {
    featuresList: [],
}

const createFeature = () => {
    for (let n = 1; n <= 5; n++) {
        features.featuresList.push({
            id: n,
            desc: `Description for Feature ${n}`
        });
    }
}

createFeature();
</script>

<template>
    <Head title="Welcome" />
    <GuestLayout :canLogin="canLogin" :canRegister="canRegister">

    <template #header>
        <h1 class="text-white text-center">Welcome to our site, we are a new dating service which focuses on gamers and non-profit service model. Unlike majority of
            dating applications we don't charge for basic features that people should have access to.
        </h1>
    </template>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="sm:py-[1.8rem] bg-[#0A0A0A] shadow rounded-sm">
                <div class="flex flex-wrap justify-center text-white">
                    <DisplayBlocks type="textBox" :content="text"/>
                    <DisplayBlocks type="gridList" :content="features.featuresList"/>

                    <DisplayBlocks type="textBox" :content="text2"/>
                    <DisplayBlocks type="specialList" :content="features.featuresList"/>
                </div>
          </div>
    </div>

    </GuestLayout>
</template>
