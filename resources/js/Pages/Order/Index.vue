<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, defineProps } from 'vue';
import { Link ,Head } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Datatable from '@/Components/Datatable.vue';

const props = defineProps(['orders'])

const orderSearch = ref({
    enabled: true,
    trigger: 'enter',
    placeholder: 'Search this table',
})

const clientSidePaginationOptions = ref({
    enabled: true,
    mode: 'records',
    perPage: 10,
    setCurrentPage: 1,
    position: 'bottom',
    perPageDropdown: [10, 50, 100, 500],
    dropdownAllowAll: false,
    jumpFirstOrLast : true,
    firstLabel : 'First Page',
    lastLabel : 'Last Page',
    nextLabel: 'next',
    prevLabel: 'prev',
    rowsPerPageLabel: 'Rows per page',
    ofLabel: 'of',
    pageLabel: 'page',
    allLabel: 'All',
    infoFn: (params) => `page ${params.firstRecordOnPage}`,

})

const columns = ref([
    {
        label: 'Order No',
        field: 'order_no',
    },
    {
        label: 'User',
        field: 'user',
    },
    {
        label: 'Cancel Status',
        field: 'order_expired_date'
    },
    {
        label: 'Order Status',
        field: 'order_status'
    },
    {
        label: 'Payment',
        field: 'payment_type'
    },
    {
        label: 'Date',
        field: 'created_at'
    },
    {
        label: 'Manage',
        field: 'normal_action',
        sortable: false
    },
])

</script>

<template>
    <Head title="Order" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <FontAwesomeIcon class="text-gray-500 text-lg mr-2" icon="folder-open" />
                Order
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <VCard>
                    <VCardText>
                        <div>
                            <Datatable :columns="columns" :paginationOptions="clientSidePaginationOptions" :rows="props.orders" :clientSideSearch="orderSearch" :action_url="'orders'" title="Order Deletion" />
                        </div>
                    </VCardText>
                </VCard>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
