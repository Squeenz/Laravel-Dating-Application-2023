<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps(['potentialMatches', 'potentialMatchesPhotos']);

const listIndex = ref(0);
const currentPhotoIndex = ref(0);

const changeProfile = (direction) => {
  // Update the listIndex based on the provided direction (1 for next, -1 for previous)
  listIndex.value += direction;

  // Handle boundary conditions, e.g., looping back to the beginning
  if (listIndex.value < 0) {
    listIndex.value = props.potentialMatches.length - 1;
  } else if (listIndex.value >= props.potentialMatches.length) {
    listIndex.value = 0;
  }
};

const changePicture = (direction) => {
    currentPhotoIndex.value += direction;

    const lenghtImagesArray = props.potentialMatchesPhotos[props.potentialMatches[listIndex.value].id].length;

    if (currentPhotoIndex.value < 0) {
        currentPhotoIndex.value = 0;
    } else if (currentPhotoIndex.value >= lenghtImagesArray) {
        currentPhotoIndex.value = lenghtImagesArray - 1;
    }
}

</script>

<template>
  <div>
    <Head title="Matchmaking" />
    <AuthenticatedLayout>
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Matchmaking
        </h2>
      </template>

      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
          <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div v-if="potentialMatches.length > 0">
                <div :key="potentialMatches[listIndex].id">
                    <img
                        :src="route('photos.get', potentialMatchesPhotos[potentialMatches[listIndex].id][currentPhotoIndex].photo)"
                        :alt="potentialMatches[listIndex].first_name + ' photo'"
                    >

                    <PrimaryButton @click="changePicture(-1)">Prev</PrimaryButton>
                    <PrimaryButton @click="changePicture(1)">Next</PrimaryButton>

                    <h1>{{ potentialMatches[listIndex].first_name }} {{ potentialMatches[listIndex].surname }} ({{ potentialMatches[listIndex].username }})</h1>
                    <h1> Age: {{ potentialMatches[listIndex].dob }}</h1>

                    <h1>Interests</h1>
                    <p>{{ potentialMatches[listIndex].interests }}</p>
                </div>

                <PrimaryButton @click="changeProfile(-1)">Dislike</PrimaryButton>
                <PrimaryButton @click="changeProfile(1)">Like</PrimaryButton>

            </div>
            <div v-else>
              <p>No potential matches available.</p>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </div>
</template>
