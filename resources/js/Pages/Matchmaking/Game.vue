<script setup>
import { ref, onMounted } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps(['user', 'potentialMatches', 'potentialMatchesPhotos']);

const listIndex = ref(0);
const currentPhotoIndex = ref(0);

const changePicture = (direction) => {
    //fix this later for the count of how many image sthe profiles have
    const lenghtImagesArray = props.potentialMatchesPhotos[props.potentialMatches[listIndex.value].id].length;

    currentPhotoIndex.value += direction;

    if (currentPhotoIndex.value < 0) {
        currentPhotoIndex.value = 0;
    } else if (currentPhotoIndex.value >= lenghtImagesArray) {
        currentPhotoIndex.value = lenghtImagesArray - 1;
    }
}

const reactToProfile = (status) =>
{
    router.post(route('like.store', status), {
        user_id: props.user.id, // Replace with the actual user_id
        liked_user_id: props.potentialMatches[listIndex.value].id, // Replace with the actual liked_user_id
        is_like: status,
    });
}

onMounted(() => {
    window.Echo.private('matches')
            .listen('MatchFound', (e) => {
                console.log(e.user1, e.user2);
            })
});

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
                    <h1>{{ currentPhotoIndex + 1 }} / 0 </h1>
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
