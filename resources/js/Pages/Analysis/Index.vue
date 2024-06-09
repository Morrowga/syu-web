<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref,onMounted } from 'vue';
import axios from 'axios';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const currentDate = new Date().toISOString().split('T')[0];
const startDate = ref(currentDate);
const endDate = ref(currentDate);
const analysis = ref([]);


onMounted(() => {
});

</script>

<template>
    <Head title="Sales" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <FontAwesomeIcon class="text-gray-500 text-lg mr-2" icon="home" />
                Analysis
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
.icon-font{
    font-size: 5rem;
}
</style>
