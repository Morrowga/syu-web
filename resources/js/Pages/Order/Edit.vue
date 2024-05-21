<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import FormError from '@/Components/FormError.vue';
import { ref, defineProps } from 'vue';

const props = defineProps(['errors', 'order_detail']);

const order = ref(props.order_detail?.data)

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

  // Format date and time together
  return new Date(date).toLocaleString('en-US', options);
}

const calculateDaysLeft = (endDate) => {
  const end = new Date(endDate);

  const currentDate = new Date();

  const differenceMs = end - currentDate;

  const differenceDays = Math.ceil(differenceMs / (1000 * 60 * 60 * 24));

  return differenceDays;
};
</script>

<template>
    <Head title="Modify Category" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <FontAwesomeIcon class="text-gray-500 text-lg mr-2" icon="scissors" />
                Modify Order
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <VCard class="rounded-lg shadow-sm">
                    <VCardText>
                        <VRow>
                            <VCol cols="6">
                                <div class="text-left">
                                    <h1 class="text-lg font-bold py-1">{{ order.order_no }}</h1>
                                    <p class="text-sm py-1 text-black opacity-50">Waiting time left <span class="font-bold">{{ calculateDaysLeft(order.waiting_end_date)  }} days</span></p>
                                    <p class="py-1 text-black opacity-100">Order will be expired at <span class="font-bold">{{ formatDate(order.order_expired_date) }}</span></p>
                                    <p class="py-1 text-black">Total Amount is <span class="font-bold">{{ order.overall_price  }} MMK</span></p>
                                    <p class="py-1 text-black">Total Quantity is <span class="font-bold">{{ order.total_qty  }}</span></p>
                                </div>
                            </VCol>
                            <VCol cols="6">
                                <div class="text-right">
                                    <VChip class="text-capitalize font-bold text-lg" variant="flat" :color="getChipColor(order.order_status)">{{ order.order_status }}</VChip>
                                    <div class="py-1">
                                        <p class="font-bold text-capitalize">{{ order.user.name }}</p>
                                        <p>Phone</p>
                                        <p>Address</p>
                                        <p>Delivery Status</p>
                                        <p>Payment Action required</p>
                                    </div>
                                </div>
                            </VCol>
                        </VRow>
                        <hr class="my-5">
                        <div>
                            Note -
                        </div>
                        <hr class="my-5">
                        <div>
                            <h1>Category</h1>
                            <VRow class="my-1">
                                <VCol cols="2">
                                    <VCard class="rounded-lg">
                                        <VCardText>
                                            <VImg class="rounded-lg" src="https://i.pinimg.com/564x/70/84/7f/70847f48f36c33ec416e4718f7697ae4.jpg" cover></VImg>
                                            <div class="text-center mt-2">
                                                <p>Matte ( 2 x 2.5 inch )</p>
                                            </div>
                                        </VCardText>
                                    </VCard>
                                </VCol>
                                <VCol cols="2">
                                    <VCard class="rounded-lg">
                                        <VCardText>
                                            <VImg class="rounded-lg" src="https://i.pinimg.com/564x/70/84/7f/70847f48f36c33ec416e4718f7697ae4.jpg" cover></VImg>
                                            <div class="text-center mt-2">
                                                <p>Matte ( 2 x 2.5 inch )</p>
                                            </div>
                                        </VCardText>
                                    </VCard>
                                </VCol>
                                <VCol cols="2">
                                    <VCard class="rounded-lg">
                                        <VCardText>
                                            <VImg class="rounded-lg" src="https://i.pinimg.com/564x/70/84/7f/70847f48f36c33ec416e4718f7697ae4.jpg" cover></VImg>
                                            <div class="text-center mt-2">
                                                <p>Matte ( 2 x 2.5 inch )</p>
                                            </div>
                                        </VCardText>
                                    </VCard>
                                </VCol>
                                <VCol cols="2">
                                    <VCard>
                                        <VCardText>
                                            <VImg src="https://i.pinimg.com/564x/70/84/7f/70847f48f36c33ec416e4718f7697ae4.jpg" cover></VImg>
                                            <div class="text-center mt-2">
                                                <p>Matte ( 2 x 2.5 inch )</p>
                                            </div>
                                        </VCardText>
                                    </VCard>
                                </VCol>
                                <VCol cols="2">
                                    <VCard class="rounded-lg">
                                        <VCardText>
                                            <VImg class="rounded-lg" src="https://i.pinimg.com/564x/70/84/7f/70847f48f36c33ec416e4718f7697ae4.jpg" cover></VImg>
                                            <div class="text-center mt-2">
                                                <p>Matte ( 2 x 2.5 inch )</p>
                                            </div>
                                        </VCardText>
                                    </VCard>
                                </VCol>
                                <VCol cols="2">
                                    <VCard class="rounded-lg">
                                        <VCardText>
                                            <VImg class="rounded-lg" src="https://i.pinimg.com/564x/70/84/7f/70847f48f36c33ec416e4718f7697ae4.jpg" cover></VImg>
                                            <div class="text-center mt-2">
                                                <p>Matte ( 2 x 2.5 inch )</p>
                                            </div>
                                        </VCardText>
                                    </VCard>
                                </VCol>
                            </VRow>
                        </div>
                    </VCardText>
                </VCard>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
