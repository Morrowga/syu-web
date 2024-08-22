<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref,onMounted, watch } from 'vue';
import axios from 'axios';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const currentDate = new Date().toISOString().split('T')[0];
const startDate = ref('');
const date = ref('');
const endDate = ref(currentDate);
const data = ref([]);

const fetchSalesData = async (type) =>  {
    try {
        let response;

        if(type == 'all')
        {
            response = await axios.get('/analysis-data?type=lifetime');
        } else {
            response = await axios.get('/analysis-data?start_date=' + startDate.value + '&end_date=' + endDate.value + '&type=date');
        }

        data.value = response.data.data;
    } catch (error) {
        console.error('Error fetching data:', error);
    }
}

const handleDate = () => {
    console.log(date.value);
    if(date.value.length > 0)
    {
        startDate.value = new Date(date.value[0]).toISOString().split('T')[0];
        endDate.value = new Date(date.value[1]).toISOString().split('T')[0];

        fetchSalesData('date');
        return;
    }

    alert('Select Date');
}


const getOverAll = () => {
    fetchSalesData('all');
}

onMounted(() => {
    getOverAll();
});

</script>

<template>
    <Head title="Sales" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <FontAwesomeIcon class="text-gray-500 text-lg mr-2" icon="money-bill-transfer" />
                Analysis
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <VRow>
                    <VCol cols="12">
                        <div class="d-flex justify-start">
                            <VueDatePicker v-model="date" style="width: 25%" :placeholder="'Select a date'" :enable-time-picker="false" model-auto range></VueDatePicker>
                            <PrimaryButton class="mx-3" :disabled="disableBtn" @click="handleDate">Get</PrimaryButton>
                            <PrimaryButton class="mx-3" :disabled="disableBtn" @click="getOverAll">Over All</PrimaryButton>
                        </div>
                    </VCol>
                </VRow>
                <VCard class="my-3">
                    <h1 class="text-2xl p-5 font-bold">General</h1>
                    <VCardText>
                        <VRow>
                            <VCol cols="4">
                                <VCard class="rounded-lg">
                                    <VCardText class="bg-[#1f2937] rounded-lg shadow-lg">
                                        <div>
                                            <span class="text-md font-bold text-white text-capitalize" style="font-size: 20px;">Top-Selling Category</span>
                                        </div>
                                        <div class="d-flex justify-between">
                                            <div>
                                                <div class="text-left mt-5">
                                                    <span class="text-2xl text-white text-capitalize"><strong style="font-size: 30px;">{{ data?.best_selling_category ?? 'None' }}</strong> </span>
                                                </div>
                                            </div>
                                                <div class="m-3 text-center">
                                                <FontAwesomeIcon class="text-gray-200 icon-font opacity-50" icon="magnifying-glass-chart" />
                                            </div>
                                        </div>
                                    </VCardText>
                                </VCard>
                            </VCol>
                            <VCol cols="4">
                                <VCard class="rounded-lg">
                                    <VCardText class="bg-[#1f2937] rounded-lg shadow-lg">
                                        <div>
                                            <span class="text-md font-bold text-white text-capitalize" style="font-size: 20px;">Top-Selling City</span>
                                        </div>
                                        <div class="d-flex justify-between">
                                            <div>
                                                <div class="text-left mt-5">
                                                    <span class="text-2xl text-white"><strong style="font-size: 25px;">{{ data?.best_selling_city?.name ?? 'None' }}</strong> </span>
                                                </div>
                                                <div class="text-left mt-5">
                                                    <span class="text-2xl text-white"><strong style="font-size: 30px;">{{ data?.best_selling_city?.total_orders }}</strong> Orders </span>
                                                </div>
                                            </div>
                                                <div class="m-3 text-center">
                                                <FontAwesomeIcon class="text-gray-200 icon-font opacity-50" icon="magnifying-glass-chart" />
                                            </div>
                                        </div>
                                    </VCardText>
                                </VCard>
                            </VCol>
                            <VCol cols="4">
                                <VCard class="rounded-lg">
                                    <VCardText class="bg-[#961134] rounded-lg shadow-lg">
                                        <div>
                                            <span class="text-md font-bold text-white text-capitalize" style="font-size: 20px;">Total Cancel Orders</span>
                                        </div>
                                        <div class="d-flex justify-between">
                                            <div>
                                                <div class="text-left mt-5">
                                                    <span class="text-2xl text-white"><strong style="font-size: 30px;">{{ data?.totalcancelOrders }}</strong> Orders </span>
                                                </div>
                                            </div>
                                                <div class="m-3 text-center">
                                                <FontAwesomeIcon class="text-gray-200 icon-font opacity-50" icon="magnifying-glass-chart" />
                                            </div>
                                        </div>
                                    </VCardText>
                                </VCard>
                            </VCol>
                            <VCol cols="4">
                                <VCard class="rounded-lg">
                                    <VCardText class="bg-[#1f2937] rounded-lg shadow-lg">
                                        <div>
                                            <span class="text-md font-bold text-white text-capitalize" style="font-size: 20px;">Total Cash On Delivery Orders</span>
                                        </div>
                                        <div class="d-flex justify-between">
                                            <div>
                                                <div class="text-left mt-5">
                                                    <span class="text-2xl text-white"><strong style="font-size: 30px;">{{ data?.totalcod }}</strong> Orders </span>
                                                </div>
                                            </div>
                                                <div class="m-3 text-center">
                                                <FontAwesomeIcon class="text-gray-200 icon-font opacity-50" icon="magnifying-glass-chart" />
                                            </div>
                                        </div>
                                    </VCardText>
                                </VCard>
                            </VCol>
                            <VCol cols="4">
                                <VCard class="rounded-lg">
                                    <VCardText class="bg-[#1f2937] rounded-lg shadow-lg">
                                        <div>
                                            <span class="text-md font-bold text-white text-capitalize" style="font-size: 20px;">Total Prepaid Orders</span>
                                        </div>
                                        <div class="d-flex justify-between">
                                            <div>
                                                <div class="text-left mt-5">
                                                    <span class="text-2xl text-white"><strong style="font-size: 30px;">{{ data?.totalpp }}</strong> Orders </span>
                                                </div>
                                            </div>
                                                <div class="m-3 text-center">
                                                <FontAwesomeIcon class="text-gray-200 icon-font opacity-50" icon="magnifying-glass-chart" />
                                            </div>
                                        </div>
                                    </VCardText>
                                </VCard>
                            </VCol>
                        </VRow>
                    </VCardText>
                    <h1 class="text-2xl p-5 font-bold">Age</h1>
                    <VCardText>
                        <VRow>
                            <VCol cols="4">
                                <VCard class="rounded-lg">
                                    <VCardText class="bg-[#1f2937] rounded-lg shadow-lg">
                                        <div>
                                            <span class="text-md font-bold text-white" style="font-size: 20px;">Age Above 18 </span>
                                        </div>
                                        <div class="d-flex justify-between">
                                            <div>
                                                <div class="text-left mt-5">
                                                    <span class="text-2xl text-white"><strong style="font-size: 30px;">{{ data?.age?.above18?.totaluser }}</strong> Users </span>
                                                </div>
                                                <div class="text-left my-3">
                                                    <span class="text-2xl text-white"><strong style="font-size: 30px;">{{ data?.age?.above18?.totalorders }}</strong> Orders</span>
                                                </div>
                                            </div>
                                             <div class="m-3 text-center">
                                                <FontAwesomeIcon class="text-gray-200 icon-font opacity-50" icon="magnifying-glass-chart" />
                                            </div>
                                        </div>
                                    </VCardText>
                                </VCard>
                            </VCol>
                            <VCol cols="4">
                                <VCard class="rounded-lg">
                                    <VCardText class="bg-[#1f2937] rounded-lg shadow-lg">
                                        <div>
                                            <span class="text-md font-bold text-white" style="font-size: 20px;">Age Under 18 </span>
                                        </div>
                                        <div class="d-flex justify-between">
                                            <div>
                                                <div class="text-left mt-5">
                                                    <span class="text-2xl text-white"><strong style="font-size: 30px;">{{ data?.age?.under18?.totaluser }}</strong> Users </span>
                                                </div>
                                                <div class="text-left my-3">
                                                    <span class="text-2xl text-white"><strong style="font-size: 30px;">{{ data?.age?.under18?.totalorders }}</strong> Orders</span>
                                                </div>
                                            </div>
                                             <div class="m-3 text-center">
                                                <FontAwesomeIcon class="text-gray-200 icon-font opacity-50" icon="magnifying-glass-chart" />
                                            </div>
                                        </div>

                                    </VCardText>
                                </VCard>
                            </VCol>
                        </VRow>
                    </VCardText>
                    <h1 class="text-2xl p-5 font-bold">Gender</h1>
                    <VCardText>
                        <VRow>
                            <VCol cols="4" v-for="(gender,index) in data?.gender" :key="index">
                                <VCard class="rounded-lg">
                                    <VCardText class="bg-[#1f2937] rounded-lg shadow-lg">
                                        <div>
                                            <span class="text-md font-bold text-white text-capitalize" style="font-size: 20px;">{{ index }} </span>
                                        </div>
                                        <div class="d-flex justify-between">
                                            <div>
                                                <div class="text-left mt-5">
                                                    <span class="text-2xl text-white"><strong style="font-size: 30px;">{{ gender?.totaluser }}</strong> Users </span>
                                                </div>
                                                <div class="text-left my-3">
                                                    <span class="text-2xl text-white"><strong style="font-size: 30px;">{{ gender?.totalorders }}</strong> Orders</span>
                                                </div>
                                            </div>
                                                <div class="m-3 text-center">
                                                <FontAwesomeIcon class="text-gray-200 icon-font opacity-50" icon="magnifying-glass-chart" />
                                            </div>
                                        </div>
                                    </VCardText>
                                </VCard>
                            </VCol>
                        </VRow>
                    </VCardText>
                    <h1 class="text-2xl p-5 font-bold">Payment Method</h1>
                    <VCardText>
                        <VRow>
                            <VCol cols="4" v-for="(method,index) in data?.payment_methods" :key="index">
                                <VCard class="rounded-lg">
                                    <VCardText class="bg-[#1f2937] rounded-lg shadow-lg">
                                        <div class="d-flex justify-between">
                                            <div>
                                                <div class="text-left mt-5">
                                                    <span class="text-2xl text-white"><strong style="font-size: 30px;">{{ method?.method }}</strong> </span>
                                                </div>
                                                <div class="text-left my-3">
                                                    <span class="text-2xl text-white"><strong style="font-size: 30px;">{{ method?.count }}</strong> Orders</span>
                                                </div>
                                            </div>
                                                <div class="m-3 text-center">
                                                <FontAwesomeIcon class="text-gray-200 icon-font opacity-50" icon="magnifying-glass-chart" />
                                            </div>
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
