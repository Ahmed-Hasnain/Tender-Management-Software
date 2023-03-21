<template>

    <Head title="Supply Order Details" />
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
                            <h2>Supply Order</h2>
                            <div class="m-t-20">
                                <div class="text-dark text-capitalize d-inline-block">
                                    <span class="font-weight-semibold text-dark">Our Reference: </span>
                                </div>
                                <div class="float-right"> {{ supplyOrder.quotation?.reference_no }}</div>
                            </div>
                            <div>
                                <div class="text-dark text-capitalize d-inline-block">
                                    <span class="font-weight-semibold text-dark">Client Reference: </span>
                                </div>
                                <div class="float-right"> {{ supplyOrder.quotation?.tender?.reference_no }}</div>
                            </div>
                            <div>
                                <div class="text-dark text-capitalize d-inline-block">
                                    <span class="font-weight-semibold text-dark">File Name: </span>
                                </div>
                                <div class="float-right"> {{ supplyOrder.quotation?.tender?.file_name }}</div>
                            </div>
                            <div>
                                <div class="text-dark text-capitalize d-inline-block">
                                    <span class="font-weight-semibold text-dark">Supply Order Date: </span>
                                </div>
                                <div class="float-right"> {{ formatDate(supplyOrder.date_of_supply_order) }}</div>
                            </div>
                            <div>
                                <div class="text-dark text-capitalize d-inline-block">
                                    <span class="font-weight-semibold text-dark">Delivery Date: </span>
                                </div>
                                <div class="float-right"> {{ formatDate(supplyOrder.delivery_date) }}</div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="row m-t-20 lh-2">
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
                            <div class="float-right">{{ formatDate(quotation.applied_date) }}</div>
                        </div>
                    </div> -->
                    <div class="m-t-20">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">No.</th>
                                        <th>Items</th>
                                        <th style="width: 150px;">Quantity</th>
                                        <th style="width: 150px;">Price</th>
                                        <th style="width: 150px;">Total</th>
                                    </tr>
                                </thead>
                                <tbody v-if="supplyOrder.items.length > 0">
                                    <tr v-for="(item, index) in supplyOrder.items" :key="index">
                                        <th>{{ index+1 }}</th>
                                        <td>{{ item.quotation_item?.tender_item?.item?.name }}<br><small>{{ item.quotation_item?.tender_item?.description }}</small></td>
                                        <td>{{ item.qty }}</td>
                                        <td>{{ supplyOrder.quotation?.currency }} {{ formatNumber(item.unit_price) }} </td>
                                        <td>{{ supplyOrder.quotation?.currency }} {{ formatNumber(item.total) }} </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row m-t-30 lh-1-8">
                            <div class="col-sm-12">
                                <div class="float-right text-right">
                                    <p>Total amount: {{ supplyOrder.quotation.currency }} {{ formatNumber(supplyOrder.total_price) }}</p>
                                    <p>GST ({{ supplyOrder.quotation?.tax }}%) : {{ supplyOrder.quotation?.currency }} {{formatNumber(calculateTax(supplyOrder.total_price, supplyOrder.quotation?.tax))}}  </p>
                                    <hr>
                                    <h3><span class="font-weight-semibold text-dark">Total :</span> {{ supplyOrder.quotation?.currency }} {{ getTotal(supplyOrder.total_price, calculateTax(supplyOrder.total_price, supplyOrder.quotation?.tax)) }} </h3>
                                </div>
                            </div>
                        </div>
                        <div class="row m-t-30 lh-2">
                            <div class="col-sm-12">
                                <div class="border-bottom p-v-20">
                                    <p class="text-opacity"><small>{{ supplyOrder.quotation?.terms_and_conditions }}</small></p>
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
        <div class="card" v-if="supplyOrder.delivered == 1">
            <div class="card-body">
                <h4>Sale Tax Invoice</h4>
                <div class="form-row">
                    <div class="form-group col-md-10">
                        <select class="form-control" v-model="company">
                            <option value="OndreTicaretTemplate" class="text-capitalize">Ondre Ticaret</option>
                            <option value="MSaadAndCompanyTemplate" class="text-capitalize">M Saad and Company</option>
                            <option value="AscentTemplate" class="text-capitalize">Ascent</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2 text-right">
                        <a :href="route('dashboard.downloadSupplyOrder', [supplyOrder.id, company, 'sale_tax_invoice'])" class="btn btn-primary btn-">Download Pdf</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <h4>Commercial Invoice</h4>
                <div class="form-row">
                    <div class="form-group col-md-10">
                        <select class="form-control" v-model="company">
                            <option value="OndreTicaretTemplate" class="text-capitalize">Ondre Ticaret</option>
                            <option value="MSaadAndCompanyTemplate" class="text-capitalize">M Saad and Company</option>
                            <option value="AscentTemplate" class="text-capitalize">Ascent</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2 text-right">
                        <a :href="route('dashboard.downloadSupplyOrder', [supplyOrder.id, company, 'commercial_invoice'])" class="btn btn-primary btn-">Download Pdf</a>
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
    props: ["supplyOrder"],
    components: {
        AuthenticatedLayout,
        Head,
        Error,
    },
    data() {
        return {
            company: 'OndreTicaretTemplate',
        };
    },
    methods: {
    },
    mounted() {
        console.log(this.supplyOrder);
    },
    mixins: [Helpers]
};
</script>

<style>

</style>
