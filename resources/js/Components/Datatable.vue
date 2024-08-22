<script setup>
import {ref, defineProps, onMounted } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DeleteButton from '@/Components/DeleteButton.vue';
import StatusBadge from '@/Components/StatusBadge.vue';
import SetDefault from '@/Components/SetDefault.vue';
import { Link ,Head } from '@inertiajs/vue3';
import moment from 'moment';

const props = defineProps({
    columns:
    {
        type: Object,
        required: true
    },
    rows:
    {
        type: Object,
        required: true
    },
    paginationOptions:
    {
        type: Object,
        required: true
    },
    clientSideSearch:
    {
        type: Object,
        required: false
    },
    action_url:
    {
        type: String,
        required: false
    },
    title:
    {
        type: String,
        required: false
    }
})

const getChipColor = (orderStatus) => {
  switch (orderStatus) {
    case 'pending':
      return 'warning';
    case 'confirmed':
      return 'success';
    case 'delivered':
      return 'success';
    case 'cancel':
      return 'red';
    case 'expired':
      return 'red';
    default:
      return 'secondary';
  }
};

const calculateHoursLeft = (order_expired_date) => {
  const now = moment();
  const expirationDate = moment(order_expired_date);
  const diff = expirationDate.diff(now);

  if (diff <= 0) {
    return true;
  }

  return false;
};

const formatOrderDate = (date) => {
  return moment(date).format('MMM, DD, YYYY hh:mm A');
};


onMounted(() => {
    calculateHoursLeft();
});

</script>
<template>
    <vue-good-table
    class="mt-5 data-table"
    styleClass="vgt-table"
    :columns="props.columns"
    :pagination-options="props.paginationOptions"
    :search-options="props.clientSideSearch"
    :rows="props.rows" >
    <template #table-row="dataProps">
        <div v-if="dataProps.column.field == 'image_url'">
            <img class="rounded-lg h-[12vh] w-[10vh]" :src="dataProps.row.image_url">
        </div>
        <div v-if="dataProps.column.field == 'normal_action'">
            <Link :href="route(props.action_url + '.edit', dataProps.row.id)">
                <PrimaryButton class="mx-2">
                    <FontAwesomeIcon class="text-white-500" icon="scissors" />
                </PrimaryButton>
            </Link>
            <DeleteButton :deleteId="dataProps.row.id" :deleteUrl="props.action_url" :title="props.title">
                <FontAwesomeIcon class="text-white" icon="trash-can" />
            </DeleteButton>
        </div>
        <div v-if="dataProps.column.field == 'is_active'">
            <StatusBadge :statusId="dataProps.row.id" :statusUrl="props.action_url + '/status'" :status="dataProps.row.is_active" />
        </div>
        <div v-if="dataProps.column.field == 'is_default'">
            <SetDefault :defaultId="dataProps.row.id" :defaultUrl="props.action_url + '/default'" :default="dataProps.row.is_default" />
        </div>
        <div v-if="dataProps.column.field == 'shippingcity'">
            <span>{{ dataProps.row.shippingcity?.name_en  }}</span>
        </div>
        <div v-if="dataProps.column.field == 'payment_type'">
            <span>{{ dataProps.row.payment_type == 'cod' ? 'COD' : 'Prepaid'  }}</span>
        </div>
        <div v-if="dataProps.column.field == 'order_expired_date'">
            <div v-if="dataProps.row.payment_type != 'cod'">
                <VChip :color="calculateHoursLeft(dataProps.row.order_expired_date) ? 'red' : 'green'"  class="text-capitalize text-white" variant="flat">{{calculateHoursLeft(dataProps.row.order_expired_date) ? 'No' : 'Yes'}} </VChip>
            </div>
            <div v-else>
                <VChip :color="'green'"  class="text-capitalize text-white" variant="flat">Yes</VChip>
            </div>
        </div>
        <div v-if="dataProps.column.field == 'paid_delivery_cost'">
            <span>{{ dataProps.row.paid_delivery_cost ? 'Yes'  : 'No' }}</span>
        </div>
        <div v-if="dataProps.column.field == 'created_at'">
            <span>{{ formatOrderDate(dataProps.row.created_at) }}</span>
        </div>
        <div v-if="dataProps.column.field == 'user'">
            <span>{{ dataProps.row.user?.name }}</span>
        </div>
        <div v-if="dataProps.column.field == 'order_status'">
            <VChip :color="getChipColor(dataProps.row.order_status)" class="text-capitalize" variant="flat">{{ dataProps.row.order_status }}</VChip>
        </div>
    </template>
    </vue-good-table>
</template>

<style>
.data-table table.vgt-table {
    background-color: #f5f5f7;
    border-color: rgb(#f5f5f7);
}
.data-table table.vgt-table td {
    color: #000;
}
.data-table table.vgt-table thead {
    color: #f5f5f7 !important;
}

.table thead th.vgt-checkbox-col {
    background: #f5f5f7 !important;
}
</style>
