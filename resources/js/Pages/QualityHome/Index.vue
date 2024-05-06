<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head,Link } from '@inertiajs/vue3';
import { ref, defineProps } from 'vue';

const props = defineProps(['categories']);

</script>

<template>
    <Head title="Qualities" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <FontAwesomeIcon class="text-gray-500 text-lg mr-2" icon="ranking-star" />
                Qualities
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <VCard class="pa-4">
                    <VRow>
                        <VCol cols="4" v-for="category in props.categories" :key="category.id">
                           <Link :href="route('qualities.index', {category: category.id})">
                                <VCard
                                    class="mx-auto"
                                >
                                    <template v-slot:title>
                                    <span class="font-weight-black capitalize">{{ category.name }} Qualities</span>
                                    </template>

                                    <VCardText class="bg-surface-light pt-4">
                                        <VImg :src="'images/'+ category.name +'.jpg'" class="h-[25vh]" cover></VImg>
                                    </VCardText>
                                </VCard>
                            </Link>
                        </VCol>
                    </VRow>
                </VCard>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
