<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link ,Head } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Datatable from '@/Components/Datatable.vue';
import { ref, defineProps } from 'vue';

const props = defineProps(['sizes', 'category'])

const sizeSearch = ref({
    enabled: true,
    trigger: 'enter',
    placeholder: 'Search this table',
})

const clientSidePaginationOptions = ref({
        enabled: true,
        mode: 'records',
        perPage: 10,
        position: 'bottom',
        perPageDropdown: [10, 20, 50,100,200],
        dropdownAllowAll: false,
        setCurrentPage: 1,
        nextLabel: 'next',
        prevLabel: 'prev',
        rowsPerPageLabel: 'Rows per page',
        ofLabel: 'of',
        pageLabel: 'page',
        allLabel: 'All',
})

const columns = ref([
    {
        label: 'Name',
        field: 'name',
    },
    {
        label: 'Size',
        field: 'size',
    },
    {
        label: 'Price',
        field: 'price',
    },
    {
        label: 'Name',
        field: 'name',
    },
    {
        label: 'Manage',
        field: 'normal_action',
        sortable: false
    },
    {
        label: 'Status',
        field: 'is_active',
        sortable: false
    },
    {
        label: 'Default',
        field: 'is_default',
        sortable: false
    },
])

</script>

<template>
    <Head :title="props.category?.name" style="text-transform: capitalize;" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight capitalize">
                <FontAwesomeIcon class="text-gray-500 text-lg mr-2" icon="expand" />
                {{ props.category?.name }} Sizes
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <VCard class="bg-white shadow-none rounded-lg">
                    <VCardText>
                        <Link :href="route('sizes.create', {category: props.category?.id})">
                            <PrimaryButton class="float-right">
                                <FontAwesomeIcon class="text-grey-500 mr-2" icon="folder-plus" />
                                {{ props.category?.name }} Size
                            </PrimaryButton>
                        </Link>
                    </VCardText>
                    <VCardText>
                        <div>
                            <Datatable :columns="columns" :paginationOptions="clientSidePaginationOptions" :rows="props.sizes" :clientSideSearch="sizeSearch" :action_url="'sizes'" title="Size Deletion" />
                        </div>
                    </VCardText>
                </VCard>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
