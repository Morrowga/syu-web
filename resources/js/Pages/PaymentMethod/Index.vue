<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link ,Head } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Datatable from '@/Components/Datatable.vue';
import { ref, defineProps } from 'vue';

const props = defineProps(['payment_methods'])

const paymentMethodSearch = ref({
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
        setCurrentPage: 2,
        nextLabel: 'next',
        prevLabel: 'prev',
        rowsPerPageLabel: 'Rows per page',
        ofLabel: 'of',
        pageLabel: 'page',
        allLabel: 'All',
})

const columns = ref([
    {
        label: 'Image',
        field: 'image_url',
        sortable: false
    },
    {
        label: 'Name',
        field: 'name',
    },
    {
        label: 'Acc No.',
        field: 'value'
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
])

</script>

<template>
    <Head title="Payment Method" class="capitalize" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight capitalize">
                <FontAwesomeIcon class="text-gray-500 text-lg mr-2" icon="note-sticky" />
                Payment Methods
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <VCard class="bg-white shadow-none rounded-lg">
                    <VCardText>
                        <Link :href="route('payment-methods.create')">
                            <PrimaryButton class="float-right">
                                <FontAwesomeIcon class="text-grey-500 mr-2" icon="folder-plus" />
                                Payment Methods
                            </PrimaryButton>
                        </Link>
                    </VCardText>
                    <VCardText>
                        <div>
                            <Datatable :columns="columns" :paginationOptions="clientSidePaginationOptions" :rows="props.payment_methods" :clientSideSearch="paymentMethodSearch" :action_url="'payment-methods'" title="Payment Method Deletion" />
                        </div>
                    </VCardText>
                </VCard>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
