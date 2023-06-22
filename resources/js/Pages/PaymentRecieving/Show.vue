<template>

    <Head title="Tender Detail" />
    <AuthenticatedLayout>
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <div class="d-md-flex align-items-center">
                            <div class="text-center text-sm-left">
                                <h2 class="m-b-5 text-capitalize">Quotation Ref: {{ paymentRecieving?.supply_order?.quotation?.reference_no }}</h2>
                                <p class="text-opacity ">
                                    {{ paymentRecieving?.supply_order?.quotation?.tender?.company?.name }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5>Details</h5>
                                <div class="m-t-20 row">
                                    <div class="col-6">
                                        <div class="media m-b-10">
                                            <div class="avatar avatar-image">
                                                <i class="anticon anticon-check" style="color:black"></i>
                                            </div>
                                            <div class="media-body m-l-20">
                                                <h6 class="m-b-0 text-capitalize">{{ paymentRecieving?.supply_order?.quotation?.tender?.client?.name }}</h6>
                                                <span class="font-size-13 text-gray text-capitalize">Client</span>
                                            </div>
                                        </div>
                                        <div class="media m-b-10">
                                            <div class="avatar avatar-image">
                                                <i class="anticon anticon-check" style="color:black"></i>
                                            </div>
                                            <div class="media-body m-l-20">
                                                <h6 class="m-b-0 text-capitalize">{{ paymentRecieving?.supply_order?.quotation?.tender?.company?.name }}</h6>
                                                <span class="font-size-13 text-gray text-capitalize">Company</span>
                                            </div>
                                        </div>
                                        <div class="media m-b-10">
                                            <div class="avatar avatar-image">
                                                <i class="anticon anticon-check" style="color:black"></i>
                                            </div>
                                            <div class="media-body m-l-20">
                                                <h6 class="m-b-0 text-capitalize">{{ paymentRecieving.supply_order?.quotation?.currency }} {{ formatNumber( paymentRecieving.cheque_amount) }}</h6>
                                                <span class="font-size-13 text-gray text-capitalize">Cheque Amount</span>
                                            </div>
                                        </div>
                                        <div class="media m-b-10">
                                            <div class="avatar avatar-image">
                                                <i class="anticon anticon-check" style="color:black"></i>
                                            </div>
                                            <div class="media-body m-l-20">
                                                <h6 class="m-b-0 text-capitalize">{{ paymentRecieving.supply_order?.quotation?.currency }} {{ formatNumber( paymentRecieving.income_tax_amount) }}</h6>
                                                <span class="font-size-13 text-gray text-capitalize">Income Tax Amount</span>
                                            </div>
                                        </div>
                                        <div class="media m-b-10">
                                            <div class="avatar avatar-image">
                                                <i class="anticon anticon-check" style="color:black"></i>
                                            </div>
                                            <div class="media-body m-l-20">
                                                <h6 class="m-b-0 text-capitalize">{{ paymentRecieving.supply_order?.quotation?.currency }} {{ formatNumber( paymentRecieving.gst_withhold_amount) }}</h6>
                                                <span class="font-size-13 text-gray text-capitalize">GST Withhold Amount</span>
                                            </div>
                                        </div>
                                        <div class="media m-b-10">
                                            <div class="avatar avatar-image">
                                                <i class="anticon anticon-check" style="color:black"></i>
                                            </div>
                                            <div class="media-body m-l-20">
                                                <h6 class="m-b-0 text-capitalize">{{ paymentRecieving.serial_no }}</h6>
                                                <span class="font-size-13 text-gray text-capitalize">Serial no</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="media m-b-10">
                                            <div class="avatar avatar-image">
                                                <i class="anticon anticon-check" style="color:black"></i>
                                            </div>
                                            <div class="media-body m-l-20">
                                                <h6 class="m-b-0 text-capitalize">{{ paymentRecieving.cheque_no }}</h6>
                                                <span class="font-size-13 text-gray text-capitalize">Cheque No.</span>
                                            </div>
                                        </div>
                                        <div class="media m-b-10">
                                            <div class="avatar avatar-image">
                                                <i class="anticon anticon-check" style="color:black"></i>
                                            </div>
                                            <div class="media-body m-l-20">
                                                <h6 class="m-b-0 text-capitalize">{{ removeDashes(paymentRecieving.bank_name) }}</h6>
                                                <span class="font-size-13 text-gray text-capitalize">Bank Name</span>
                                            </div>
                                        </div>
                                        <div class="media m-b-10">
                                            <div class="avatar avatar-image">
                                                <i class="anticon anticon-check" style="color:black"></i>
                                            </div>
                                            <div class="media-body m-l-20">
                                                <h6 class="m-b-0 text-capitalize">{{
                                                    formatDate(paymentRecieving.payment_date)
                                                }}</h6>
                                                <span class="font-size-13 text-gray text-capitalize">Payment Date</span>
                                            </div>
                                        </div>
                                        <div class="media m-b-10">
                                            <div class="avatar avatar-image">
                                                <i class="anticon anticon-check" style="color:black"></i>
                                            </div>
                                            <div class="media-body m-l-20">
                                                <h6 class="m-b-0 text-capitalize">{{
                                                    formatDate(paymentRecieving.cheque_date)
                                                }}</h6>
                                                <span class="font-size-13 text-gray text-capitalize">Cheque Date</span>
                                            </div>
                                        </div>
                                        <div class="media m-b-10">
                                            <div class="avatar avatar-image">
                                                <i class="anticon anticon-check" style="color:black"></i>
                                            </div>
                                            <div class="media-body m-l-20">
                                                <h6 class="m-b-0 text-capitalize">{{ paymentRecieving.status }}</h6>
                                                <span class="font-size-13 text-gray text-capitalize">Status</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head, useForm } from "@inertiajs/inertia-vue3";
import Error from "@/Components/InputError.vue";
import person from "@/Components/person.vue";
import Helpers from '@/Mixins/Helpers';


export default {
    props: ["paymentRecieving"],
    components: {
        AuthenticatedLayout,
        Head,
        Error,
        person
    },
    data() {
        return {};
    },
    methods: {

    },
    mounted(){
        console.log(this.paymentRecieving);
    },
    mixins: [Helpers]
};
</script>

<style>

</style>
