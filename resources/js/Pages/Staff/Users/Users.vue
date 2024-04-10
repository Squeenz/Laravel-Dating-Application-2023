<script setup>
import StaffLayout from '@/Layouts/StaffLayout.vue';
import { Head, usePage, Link, router } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref, onMounted } from 'vue';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import { ChevronsLeft, ChevronLeft, ChevronsRight, ChevronRight } from 'lucide-vue-next';
import { usePermissions } from '@/Composables/usePermissions';
import PermissionErrorMsg from '@/Components/PermissionErrorMsg.vue';

dayjs.extend(relativeTime);

const props = defineProps(['users']);

const { hasPerm } = usePermissions();
</script>

<template>
    <Head title="All users" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-white leading-tight">
                All Users
            </h2>
        </template>

        <div>
            <div class="mx-auto">
                <div
                    v-if="hasPerm('view users')"
                    class="shadow rounded-sm text-white">
                    <div class="grid grid-flow-row">
                        <div
                            v-for="user in props.users.data"
                            :key="user.id"
                            class="bg-red-900 p-1 m-1 rounded-sm text-center">
                            <div class="grid grid-flow-col items-center">
                                <h1>{{ user.id }}</h1>
                                <h1>{{ user.gender }}</h1>
                                <h1>{{ user.dob }}</h1>
                                <h1>{{ user.first_name }}</h1>
                                <h1>{{ user.surname }}</h1>
                                <h1>{{ user.email }}</h1>
                                <h1>{{ dayjs(user.created_at).format("DD/MM/YYYY") }}</h1>
                                <Link v-if="hasPerm('delete users')" method="delete" :href="route('staff.dashboard.users.destroy', user.id)" as="button"><PrimaryButton class="justify-center mx-2">Delete</PrimaryButton></Link>
                            </div>
                        </div>

                        <div class="grid grid-flow-col my-2 text-center">
                            <Link :href="props.users.first_page_url"><PrimaryButton class="justify-center mx-2 w-[15rem]"><ChevronsLeft/></PrimaryButton></Link>
                            <Link :href="props.users.prev_page_url"><PrimaryButton class="justify-center mx-2 w-[15rem]"><ChevronLeft/></PrimaryButton></Link>
                            <h1 class=" text-center my-auto">{{ props.users.current_page }}/{{ props.users.last_page }}</h1>
                            <Link :href="props.users.next_page_url"><PrimaryButton class="justify-center mx-2 w-[15rem]"><ChevronRight/></PrimaryButton></Link>
                            <Link :href="props.users.last_page_url"><PrimaryButton class="justify-center mx-2 w-[15rem]"><ChevronsRight/></PrimaryButton></Link>
                        </div>
                    </div>
                </div>
                <PermissionErrorMsg v-else :role="$page.props.auth.role"/>
            </div>
        </div>
    </StaffLayout>
</template>
