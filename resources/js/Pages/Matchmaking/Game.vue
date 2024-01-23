<script setup>
import { ref, onMounted, watch } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps(['user', 'potentialMatches', 'potentialMatchesPhotos']);

const listIndex = ref(0);
const currentPhotoIndex = ref(0);
const lengthImagesArray = ref(0);

onMounted(() => {
  // Watch for changes in user data and potential matches
  watch([() => props.user, () => props.potentialMatches], () => {
    setUserIndexAndPhotoCount();
  });

  setUserIndexAndPhotoCount();
});

const setUserIndexAndPhotoCount = () => {
  currentPhotoIndex.value = 0;

  if (props.user.length !== 0 && props.potentialMatches[listIndex.value]) {
    const userId = props.potentialMatches[listIndex.value].id;

    // Check if potentialMatchesPhotos for the current user is available
    if (props.potentialMatchesPhotos[userId]) {
      lengthImagesArray.value = props.potentialMatchesPhotos[userId].length;
    } else {
      lengthImagesArray.value = 0;
    }
  } else {
    lengthImagesArray.value = 0;
  }
};

const changePicture = (direction) => {
  currentPhotoIndex.value += direction;

  if (currentPhotoIndex.value < 0) {
    currentPhotoIndex.value = 0;
  } else if (currentPhotoIndex.value === lengthImagesArray.value) {
    currentPhotoIndex.value = lengthImagesArray.value - 1;
  }
};

const reactToProfile = (status) => {
  router.post(route('like.store', status), {
    user_id: props.user.id,
    liked_user_id: props.potentialMatches[listIndex.value].id,
    is_like: status,
  });
};
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
                    <h1>{{ currentPhotoIndex + 1 }} / {{ lengthImagesArray }} </h1>
                    <PrimaryButton @click="changePicture(1)">Next</PrimaryButton>

                    <h1>{{ potentialMatches[listIndex].first_name }} {{ potentialMatches[listIndex].surname }} ({{ potentialMatches[listIndex].username }})</h1>
                    <h1> Age: {{ potentialMatches[listIndex].dob }}</h1>

                    <h1>Interests</h1>
                    <p>{{ potentialMatches[listIndex].interests }}</p>
                </div>

                <PrimaryButton @click="reactToProfile(0)">Dislike</PrimaryButton>
                <PrimaryButton @click="reactToProfile(1)">Like</PrimaryButton>

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
