<template>

    <Head title="Tender Detail" />
    <AuthenticatedLayout>
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <div class="d-md-flex align-items-center">
                            <div class="text-center text-sm-left m-v-15">
                                <h2 class="m-b-5 text-capitalize">{{ tender.reference_no }}</h2>
                                <!-- <p class="text-opacity font-size-13">
                                    {{ tender.description }}
                                </p> -->
                                <p class="text-opacity m-b-20">
                                    {{ tender.description }}
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
                                        <div class="media m-b-30">
                                            <div class="avatar avatar-image">
                                                <i class="anticon anticon-check" style="color:black"></i>
                                            </div>
                                            <div class="media-body m-l-20">
                                                <h6 class="m-b-0 text-capitalize">{{ tender.file_name }}</h6>
                                                <span class="font-size-13 text-gray text-capitalize">File name</span>
                                            </div>
                                        </div>
                                        <div class="media m-b-30">
                                            <div class="avatar avatar-image">
                                                <i class="anticon anticon-check" style="color:black"></i>
                                            </div>
                                            <div class="media-body m-l-20">
                                                <h6 class="m-b-0 text-capitalize">{{ tender.rate_basis }}</h6>
                                                <span class="font-size-13 text-gray text-capitalize">Rate Basis</span>
                                            </div>
                                        </div>
                                        <div class="media m-b-30">
                                            <div class="avatar avatar-image">
                                                <i class="anticon anticon-check" style="color:black"></i>
                                            </div>
                                            <div class="media-body m-l-20">
                                                <h6 class="m-b-0 text-capitalize">{{ tender.client?.name }}</h6>
                                                <span class="font-size-13 text-gray text-capitalize">Client</span>
                                            </div>
                                        </div>
                                        <div class="media m-b-30">
                                            <div class="avatar avatar-image">
                                                <i class="anticon anticon-check" style="color:black"></i>
                                            </div>
                                            <div class="media-body m-l-20">
                                                <h6 class="m-b-0 text-capitalize">{{ tender.mop?.name }}</h6>
                                                <span class="font-size-13 text-gray text-capitalize">Mode of
                                                    Payment</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="media m-b-30">
                                            <div class="avatar avatar-image">
                                                <i class="anticon anticon-check" style="color:black"></i>
                                            </div>
                                            <div class="media-body m-l-20">
                                                <h6 class="m-b-0 text-capitalize">{{ formatDate(tender.rfq_date) }}</h6>
                                                <span class="font-size-13 text-gray text-capitalize">RFQ Date</span>
                                            </div>
                                        </div>
                                        <div class="media m-b-30">
                                            <div class="avatar avatar-image">
                                                <i class="anticon anticon-check" style="color:black"></i>
                                            </div>
                                            <div class="media-body m-l-20">
                                                <h6 class="m-b-0 text-capitalize">{{
                                                    formatDate(tender.last_date_of_submission)
                                                }}</h6>
                                                <span class="font-size-13 text-gray text-capitalize">Last date of
                                                    submission</span>
                                            </div>
                                        </div>
                                        <div class="media m-b-30">
                                            <div class="avatar avatar-image">
                                                <i class="anticon anticon-check" style="color:black"></i>
                                            </div>
                                            <div class="media-body m-l-20">
                                                <h6 class="m-b-0 text-capitalize">{{
                                                    formatDate(tender.validity_of_quotation)
                                                }}</h6>
                                                <span class="font-size-13 text-gray text-capitalize">Validity Of
                                                    Quotation</span>
                                            </div>
                                        </div>
                                        <div class="media m-b-30">
                                            <div class="avatar avatar-image">
                                                <i class="anticon anticon-check" style="color:black"></i>
                                            </div>
                                            <div class="media-body m-l-20">
                                                <h6 class="m-b-0 text-capitalize">Special Terms</h6>
                                                <span class="font-size-13 text-gray text-capitalize">{{ tender.special_terms }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h5>Items</h5>
                        <div class="table-responsive" v-if="tender.allItems.length > 0">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Id</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Unit</th>
                                        <th scope="col">Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item,index) in tender.allItems" :key="index">
                                        <th scope="row">{{ item.id }}</th>
                                        <td class="text-capitalize">{{ item.item?.name }}</td>
                                        <td class="text-capitalize">{{ item.unit?.full_name }}</td>
                                        <td class="text-capitalize">{{item.qty}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div v-else>No record Found</div>
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
    props: ["tender"],
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
    mounted() {
        console.log(this.tender);
    },
    mixins: [Helpers]
};
</script>

<style>

</style>
