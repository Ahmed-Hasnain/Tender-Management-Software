<template>

    <Head title="Quotation Details" />
    <AuthenticatedLayout>
        <div class="card">
            <div class="card-body">
                <div id="invoice" class="p-h-30">
                    <div class="m-t-15 lh-2">
                        <div class="inline-block">
                            <img :src="getImage(this.$page.props.settings.logo)" alt="Logo" height="60" width="60">
                            <address class="p-l-10">
                                <span class="font-weight-semibold text-dark">Ondre Ticaret, Inc.</span><br>
                                <span>Office # 1102, 11th Floor, Green Trust Tower,</span><br>
                                <span>Jinnah Avenue, Blue Area, Islamabad</span><br>
                                <abbr class="text-dark" title="Phone">Phone#</abbr>
                                <span> 051-2813153</span>
                                <br>
                                <abbr class="text-dark" title="Mobile">Mobile#</abbr>
                                <span> 0318-3788114</span>
                            </address>
                        </div>
                        <div class="float-right">
                            <h2>QUOTATION</h2>
                        </div>
                    </div>
                    <div class="row m-t-20 lh-2">
                        <div class="col-sm-9">
                            <h3 class="p-l-10 m-t-10">Quotation To:</h3>
                            <address class="p-l-10 m-t-10">
                                <span class="font-weight-semibold text-dark">{{ quotation.tender?.client?.name }}</span><br>
                                <span>{{ quotation.tender?.client?.address }}, </span><br>
                                <span>{{ quotation.tender?.client?.city }}, {{ quotation.tender?.client?.district }}, {{ quotation.tender?.client?.country }}</span>
                            </address>
                        </div>
                        <div class="col-sm-3">
                            <div class="m-t-80">
                                <div class="text-dark text-uppercase d-inline-block">
                                    <span class="font-weight-semibold text-dark">Quotation No :</span>
                                </div>
                                <div class="float-right">{{ quotation.reference_no }}</div>
                            </div>
                            <div class="text-dark text-uppercase d-inline-block">
                                <span class="font-weight-semibold text-dark">Date :</span>
                            </div>
                            <div class="float-right">{{ formatDate(quotation.created_at) }}</div>
                        </div>
                    </div>
                    <div class="m-t-20">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Items</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody v-if="quotation.items.length > 0">
                                    <tr v-for="(item, index) in quotation.items" :key="index">
                                        <th>{{ index }}</th>
                                        <td>{{ item.tender_item?.item?.name }}</td>
                                        <td>{{ item.tender_item?.qty }}</td>
                                        <td>{{ quotation.currency }}{{ formatNumber(item.unit_price) }} </td>
                                        <td>{{ quotation.currency }}{{ formatNumber(item.total_price) }} </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row m-t-30 lh-1-8">
                            <div class="col-sm-12">
                                <div class="float-right text-right">
                                    <p>Total amount: {{ quotation.currency }}{{ formatNumber(quotation.total_price) }}</p>
                                    <p>vat ({{ $page.props.settings.tax_percentage }}%) : {{ quotation.currency }}{{formatNumber(calculateTax(quotation.total_price))}}  </p>
                                    <hr>
                                    <h3><span class="font-weight-semibold text-dark">Total :</span> {{ quotation.currency }}{{ getTotal(quotation.total_price, calculateTax(quotation.total_price)) }} </h3>
                                </div>
                            </div>
                        </div>
                        <div class="row m-t-30 lh-2">
                            <div class="col-sm-12">
                                <div class="border-bottom p-v-20">
                                    <p class="text-opacity"><small>{{ quotation.terms_and_conditions }}</small></p>
                                </div>
                            </div>
                        </div>
                        <div class="row m-v-20">
                            <div class="col-sm-6">
                                <img class="img-fluid text-opacity m-t-5" width="100" src="assets/images/logo/logo.png"
                                    alt="">
                            </div>
                            <div class="col-sm-6 text-right">
                                <small><span class="font-weight-semibold text-dark">Phone:</span> 0318-3788114</small>
                                <br>
                                <small>support@ondreticaret.co</small>
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
import Helpers from '@/Mixins/Helpers';

export default {
    props: ["quotation"],
    components: {
        AuthenticatedLayout,
        Head,
        Error,
    },
    data() {
        return {};
    },
    methods: {

    },
    mounted() {
        console.log(this.quotation);
    },
    mixins: [Helpers]
};
</script>

<style>

</style>
