<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import FormError from '@/Components/FormError.vue';
import { ref, defineProps } from 'vue';

const props = defineProps(['errors', 'order_detail', 'data']);


const form = useForm({
    order_status: 'pending'
});

const order = ref(props.order_detail?.data)
const orderProducts = ref(props.data)

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

function formatDate(date) {
  const options = {
    month: 'long',
    day: 'numeric',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
    hour12: true
  };

  return new Date(date).toLocaleString('en-US', options);
}

const calculateDaysLeft = (endDate) => {
  const end = new Date(endDate);

  const currentDate = new Date();

  const differenceMs = end - currentDate;

  const differenceDays = Math.ceil(differenceMs / (1000 * 60 * 60 * 24));

  return differenceDays;
};

const updateStatus = (status) => {

    form.order_status = status;

    form.post(route('orders.update', order.value.id) + '?_method=PUT', {
        onSuccess: () => {
        },
        onError: (error) => {
        },
    });

}

</script>

<template>
    <Head title="Modify Category" />

    <AuthenticatedLayout>
        <template #header>
            <!-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <FontAwesomeIcon class="text-gray-500 text-lg mr-2" icon="scissors" />
                Modify Order
            </h2> -->
            <div class="my-3">
                <span class="font-bold text-xl mr-2">{{ order.order_no }}</span>
                <VChip class="text-capitalize mb-2" variant="flat" :color="getChipColor(order.order_status)" x-small>{{ order.order_status }}</VChip>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <VCard class="rounded-lg shadow-sm">
                    <VCardText>
                        <VRow>
                            <VCol cols="6">
                                <div class="text-left">
                                    <p class="text-sm py-1 text-black">Waiting time left <span class="font-bold">{{ calculateDaysLeft(order.waiting_end_date)  }} days</span></p>
                                    <p class="py-1 text-black">Order will be expired at <span class="font-bold">{{ formatDate(order.order_expired_date) }}</span></p>
                                    <p class="py-1 text-black">Total Amount is <span class="font-bold">{{ order.overall_price  }} MMK</span></p>
                                    <p class="py-1 text-black">Total Quantity is <span class="font-bold">{{ order.total_qty  }}</span></p>
                                </div>
                            </VCol>
                            <VCol cols="6">
                                <div class="text-right">
                                    <p class="font-bold text-capitalize py-1">{{ order.user.name }} [ {{ order.user.msisdn }} ], {{ order.user.shipping_address + ' ' + (order.user.shippingcity ? ', ' + order.user.shippingcity?.name_en : '')}}</p>
                                    <p :class="'font-bold text-capitalize my-1 ' +  (order.paid_delviery_cost == true ? 'text-[#4caf4f]' : 'text-[#c51162]')">{{ order.paid_delviery_cost ? 'Paid Delivery Fees' : 'Delivery Fees Not Included' }}</p>
                                    <div v-if="order.order_status == 'pending'">
                                        <p class="font-bold text-capitalize py-2 text-[#f44336]">Payment Action is required</p>
                                    </div>
                                    <div v-else-if="order.order_status == 'confirmed'">
                                        <PrimaryButton class="my-2 text-sm">View Payment</PrimaryButton>
                                    </div>
                                </div>
                            </VCol>
                        </VRow>
                        <hr class="my-5">
                        <div>
                            <span class="font-bold text-black">Note</span>
                            <p class="text-red-600 font-bold my-1">
                                {{ order.note ?? 'empty...' }}
                            </p>
                        </div>
                        <hr class="my-5">
                        <div v-for="(orderProduct,index) in orderProducts" :key="index">
                            <h1 class="text-capitalize font-bold text-xl">#{{ orderProduct.category}}</h1>
                            <VRow class="my-1">
                                <VCol cols="3" v-for="product in orderProduct?.products?.data" :key="product.id">
                                    <VCard class="rounded-lg card-shadow">
                                        <VCardText>
                                            <VImg height="250" class="rounded-lg align-start" :src="product.image_url" cover>
                                                <VCardTitle class="text-left">
                                                    <VChip variant="elevated" size="small">{{product.per_amt + ' MMK' }}</VChip>
                                                </VCardTitle>
                                            </VImg>
                                            <div class="d-flex justify-between">
                                                <div class="text-left mt-2">
                                                    <p class="font-bold my-1">{{product.qty}} Qty</p>
                                                    <p class="font-bold">{{product.total_amt}} MMK</p>
                                                </div>
                                                <div class="text-right mt-2">
                                                    <p class="font-bold my-1">{{product.quality?.name}}</p>
                                                    <p class="font-bold">{{product.size?.size}}</p>
                                                </div>
                                            </div>
                                        </VCardText>
                                    </VCard>
                                </VCol>
                            </VRow>
                            <hr class="my-3">
                        </div>
                        <div class="text-right my-4">
                            <Link :href="route('orders.index')">
                                <PrimaryButton>Back</PrimaryButton>
                            </Link>
                            <PrimaryButton class="mx-2 bg-red" @click="updateStatus('cancel')">Cancel</PrimaryButton>
                            <PrimaryButton class="bg-success" @click="updateStatus('confirmed')">Approve</PrimaryButton>
                        </div>
                    </VCardText>
                </VCard>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<style>
.card-shadow {
  box-shadow: 2px 2px 3px rgb(25,25,25, 0.5); /* Adjust the shadow properties as needed */
}
</style>
