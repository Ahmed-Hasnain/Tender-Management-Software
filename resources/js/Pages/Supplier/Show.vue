<template>

    <Head title="Supplier Detail" />
    <AuthenticatedLayout>
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <div class="d-md-flex align-items-center">
                            <div class="text-center text-sm-left m-v-15">
                                <h2 class="m-b-5 text-capitalize">{{ supplier.name }}</h2>
                                <p class="text-opacity font-size-13">
                                    {{ supplier.website }}
                                </p>
                                <p class="text-dark m-b-20">
                                    Frontend Developer, UI/UX Designer
                                </p>
                                <button class="btn btn-primary btn-tone">
                                    Contact
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5>Address</h5>
                                <div class="m-t-20">
                                    <div class="media m-b-30">
                                        <div class="avatar avatar-image">
                                            <i class="anticon anticon-check" style="color:black"></i>
                                        </div>
                                        <div class="media-body m-l-20">
                                            <h6 class="m-b-0 text-capitalize">{{ supplier.address }}</h6>
                                            <span class="font-size-13 text-gray text-capitalize">Address</span>
                                        </div>
                                    </div>
                                    <div class="media m-b-30">
                                        <div class="avatar avatar-image">
                                            <i class="anticon anticon-check" style="color:black"></i>
                                        </div>
                                        <div class="media-body m-l-20">
                                            <h6 class="m-b-0 text-capitalize">{{ supplier.city }}</h6>
                                            <span class="font-size-13 text-gray text-capitalize">City</span>
                                        </div>
                                    </div>
                                    <div class="media m-b-30">
                                        <div class="avatar avatar-image">
                                            <i class="anticon anticon-check" style="color:black"></i>
                                        </div>
                                        <div class="media-body m-l-20">
                                            <h6 class="m-b-0 text-capitalize">{{ supplier.district }}</h6>
                                            <span class="font-size-13 text-gray text-capitalize">District</span>
                                        </div>
                                    </div>
                                    <div class="media m-b-30">
                                        <div class="avatar avatar-image">
                                            <i class="anticon anticon-check" style="color:black"></i>
                                        </div>
                                        <div class="media-body m-l-20">
                                            <h6 class="m-b-0 text-capitalize">{{ supplier.country }}</h6>
                                            <span class="font-size-13 text-gray text-capitalize">Country</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5>Bank Info</h5>
                                <div class="m-t-20">
                                    <div class="media m-b-30">
                                        <div class="avatar avatar-image">
                                            <i class="anticon anticon-check" style="color:black"></i>
                                        </div>
                                        <div class="media-body m-l-20">
                                            <h6 class="m-b-0 text-capitalize">{{ supplier.bank_name }}</h6>
                                            <span class="font-size-13 text-gray text-capitalize">Bank Name</span>
                                        </div>
                                    </div>
                                    <div class="media m-b-30">
                                        <div class="avatar avatar-image">
                                            <i class="anticon anticon-check" style="color:black"></i>
                                        </div>
                                        <div class="media-body m-l-20">
                                            <h6 class="m-b-0 text-capitalize">{{ supplier.account_title }}</h6>
                                            <span class="font-size-13 text-gray text-capitalize">Account Title</span>
                                        </div>
                                    </div>
                                    <div class="media m-b-30">
                                        <div class="avatar avatar-image">
                                            <i class="anticon anticon-check" style="color:black"></i>
                                        </div>
                                        <div class="media-body m-l-20">
                                            <h6 class="m-b-0 text-capitalize">{{ supplier.account_number }}</h6>
                                            <span class="font-size-13 text-gray text-capitalize">Account Number</span>
                                        </div>
                                    </div>
                                    <div class="media m-b-30">
                                        <div class="avatar avatar-image">
                                            <i class="anticon anticon-check" style="color:black"></i>
                                        </div>
                                        <div class="media-body m-l-20">
                                            <h6 class="m-b-0 text-capitalize">{{ supplier.branch_code }}</h6>
                                            <span class="font-size-13 text-gray text-capitalize">Branch Code</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h5>Contact Persons</h5>
                        <div class="row" id="card-view">
                            <div class="col-md-3" v-for="n in 9" :key="n">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="m-t-20 text-center">
                                            <h4 class="m-t-30">Erin Gonzales</h4>
                                            <p>erin.gon@gmail.com</p>
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

export default {
    props: ["supplier"],
    components: {
        AuthenticatedLayout,
        Head,
        Error,
    },
    data() {
        return {};
    },
    methods: {},
    mounted() { console.log(this.supplier) },
};
</script>

<style>

</style>
