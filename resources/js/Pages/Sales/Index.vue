<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref,onMounted } from 'vue';
import axios from 'axios';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const currentDate = new Date().toISOString().split('T')[0];
const startDate = ref(currentDate);
const endDate = ref(currentDate);
const sales = ref([]);

const fetchSalesData = async () =>  {
    try {
    const response = await axios.get('/sales-data?start_date=' + startDate.value + '&end_date=' + endDate.value);
    sales.value = response.data;
    } catch (error) {
        console.error('Error fetching data:', error);
    }
}

const handleDate = () => {
    startDate.value = new Date(startDate.value).toISOString().split('T')[0];
    endDate.value = new Date(endDate.value).toISOString().split('T')[0];

    fetchSalesData();
}

onMounted(() => {
    fetchSalesData();
});

</script>

<template>
    <Head title="Sales" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <FontAwesomeIcon class="text-gray-500 text-lg mr-2" icon="money-bill-transfer" />
                Sales
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <VRow>
                    <VCol cols="6">
                        <div class="d-flex justify-start">
                            <VueDatePicker v-model="startDate" :enable-time-picker="false"></VueDatePicker>
                            <span class="text-xl mx-5 mt-2">
                                <FontAwesomeIcon class="text-black opacity-50" icon="right-long" />
                            </span>
                            <VueDatePicker v-model="endDate" :enable-time-picker="false"></VueDatePicker>
                            <PrimaryButton class="mx-3" @click="handleDate()">Get</PrimaryButton>
                        </div>
                    </VCol>
                </VRow>
                <VCard class="my-3">
                    <h1 class="text-2xl p-5 font-bold">Sales Overall</h1>
                    <VCardText>
                        <VRow>
                            <VCol cols="3">
                                <VCard class="rounded-lg">
                                    <VCardText class="bg-[#a5ab68] rounded-lg shadow-lg">
                                        <div>
                                            <span class="text-md font-bold text-white">Total Amount</span>
                                        </div>
                                        <div class="my-3 text-center">
                                            <FontAwesomeIcon class="text-gray-200 icon-font opacity-50" icon="sack-dollar" />
                                        </div>
                                        <div class="text-right">
                                            <span class="text-2xl text-white">{{ sales?.overall?.total_order_amount }}</span>
                                        </div>
                                    </VCardText>
                                </VCard>
                            </VCol>
                            <VCol cols="3">
                                <VCard class="rounded-lg">
                                    <VCardText class="bg-[#3bb3af] rounded-lg shadow-lg">
                                        <div>
                                            <span class="text-md font-bold text-white">Total Points Covered</span>
                                        </div>
                                        <div class="my-3 text-center">
                                            <FontAwesomeIcon class="text-gray-200 icon-font opacity-50" icon="sack-dollar" />
                                        </div>
                                        <div class="text-right">
                                            <span class="text-2xl text-white">{{ sales?.overall?.total_save_with_points > 0 ? sales?.overall?.total_save_with_points + ' Points': 0 + ' Point' }}</span>
                                        </div>
                                    </VCardText>
                                </VCard>
                            </VCol>
                            <VCol cols="3">
                                <VCard class="rounded-lg">
                                    <VCardText class="bg-[#42acc2] rounded-lg shadow-lg">
                                        <div>
                                            <span class="text-md font-bold text-white">Total Orders</span>
                                        </div>
                                        <div class="my-3 text-center">
                                            <FontAwesomeIcon class="text-gray-200 icon-font opacity-50" icon="coins" />
                                        </div>
                                        <div class="text-right">
                                            <span class="text-2xl text-white">{{ sales?.overall?.total_orders }}</span>
                                        </div>
                                    </VCardText>
                                </VCard>
                            </VCol>
                            <VCol cols="3">
                                <VCard class="rounded-lg">
                                    <VCardText class="bg-[#cf1754] rounded-lg shadow-lg">
                                        <div>
                                            <span class="text-md font-bold text-white">Total Products</span>
                                        </div>
                                        <div class="my-3 text-center">
                                            <FontAwesomeIcon class="text-gray-200 icon-font opacity-50" icon="cubes" />
                                        </div>
                                        <div class="text-right">
                                            <span class="text-2xl text-white">{{ sales?.overall?.total_product_count }}</span>
                                        </div>
                                    </VCardText>
                                </VCard>
                            </VCol>
                            <VCol cols="3">
                                <VCard class="rounded-lg">
                                    <VCardText class="bg-[#545152] rounded-lg shadow-lg">
                                        <div>
                                            <span class="text-md font-bold text-white">Total Demand</span>
                                        </div>
                                        <div class="my-3 text-center">
                                            <FontAwesomeIcon class="text-gray-200 icon-font opacity-50" icon="money-bill-wave" />
                                        </div>
                                        <div class="text-right">
                                            <span class="text-2xl text-white">{{ sales?.overall?.total_demand }}</span>
                                        </div>
                                    </VCardText>
                                </VCard>
                            </VCol>
                            <VCol cols="3">
                                <VCard class="rounded-lg">
                                    <VCardText class="bg-[#3fab90] rounded-lg shadow-lg">
                                        <div>
                                            <span class="text-md font-bold text-white">Total Profit</span>
                                        </div>
                                        <div class="my-3 text-center">
                                            <FontAwesomeIcon class="text-gray-200 icon-font opacity-50" icon="money-bill-trend-up" />
                                        </div>
                                        <div class="text-right">
                                            <span class="text-2xl text-white">{{ sales?.overall?.total_profit }}</span>
                                        </div>
                                    </VCardText>
                                </VCard>
                            </VCol>
                        </VRow>
                    </VCardText>
                </VCard>
                <VCard class="my-3" v-for="(category_data,index) in sales?.each_category_data" :key="index">
                    <h1 class="text-2xl font-bold p-5 capitalize">{{ category_data.category }}</h1>
                    <VCardText>
                        <VRow>
                            <VCol cols="3">
                                <VCard class="rounded-lg">
                                    <VCardText class="bg-[#a5ab68] rounded-lg shadow-lg">
                                        <div>
                                            <span class="text-md font-bold text-white">Total Amount</span>
                                        </div>
                                        <div class="my-3 text-center">
                                            <FontAwesomeIcon class="text-gray-200 icon-font opacity-50" icon="sack-dollar" />
                                        </div>
                                        <div class="text-right">
                                            <span class="text-2xl text-white">{{ category_data.data?.total_amount }}</span>
                                        </div>
                                    </VCardText>
                                </VCard>
                            </VCol>
                            <VCol cols="3">
                                <VCard class="rounded-lg">
                                    <VCardText class="bg-[#cf1754] rounded-lg shadow-lg">
                                        <div>
                                            <span class="text-md font-bold text-white">Total Product Count</span>
                                        </div>
                                        <div class="my-3 text-center">
                                            <FontAwesomeIcon class="text-gray-200 icon-font opacity-50" icon="cubes" />
                                        </div>
                                        <div class="text-right">
                                            <span class="text-2xl text-white">{{ category_data.data?.total_product_count }}</span>
                                        </div>
                                    </VCardText>
                                </VCard>
                            </VCol>
                            <VCol cols="3">
                                <VCard class="rounded-lg">
                                    <VCardText class="bg-[#545152] rounded-lg shadow-lg">
                                        <div>
                                            <span class="text-md font-bold text-white">Total Demand</span>
                                        </div>
                                        <div class="my-3 text-center">
                                            <FontAwesomeIcon class="text-gray-200 icon-font opacity-50" icon="money-bill-wave" />
                                        </div>
                                        <div class="text-right">
                                            <span class="text-2xl text-white">{{ category_data.data?.total_demand }}</span>
                                        </div>
                                    </VCardText>
                                </VCard>
                            </VCol>
                            <VCol cols="3">
                                <VCard class="rounded-lg">
                                    <VCardText class="bg-[#3fab90] rounded-lg shadow-lg">
                                        <div>
                                            <span class="text-md font-bold text-white">Total Profit</span>
                                        </div>
                                        <div class="my-3 text-center">
                                            <FontAwesomeIcon class="text-gray-200 icon-font opacity-50" icon="money-bill-trend-up" />
                                        </div>
                                        <div class="text-right">
                                            <span class="text-2xl text-white">{{ category_data.data?.total_profit }}</span>
                                        </div>
                                    </VCardText>
                                </VCard>
                            </VCol>
                        </VRow>
                    </VCardText>
                </VCard>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
.icon-font{
    font-size: 5rem;
}
</style>
