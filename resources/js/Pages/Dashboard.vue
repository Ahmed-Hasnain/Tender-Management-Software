<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <div class="row">
            <div class="col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="media align-items-center">
                            <div class="avatar avatar-icon avatar-lg avatar-blue">
                                <i class="anticon anticon-bank"></i>
                            </div>
                            <div class="m-l-15">
                                <h2 class="m-b-0">{{total_companies}}</h2>
                                <p class="m-b-0 text-muted">Total Companies Test</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="media align-items-center">
                            <div class="avatar avatar-icon avatar-lg avatar-cyan">
                                <i class="anticon anticon-copyright"></i>
                            </div>
                            <div class="m-l-15">
                                <h2 class="m-b-0">{{ total_clients }}</h2>
                                <p class="m-b-0 text-muted">Total Clients</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="media align-items-center">
                            <div class="avatar avatar-icon avatar-lg avatar-gold">
                                <i class="anticon anticon-user-add"></i>
                            </div>
                            <div class="m-l-15">
                                <h2 class="m-b-0">{{ total_suppliers }}</h2>
                                <p class="m-b-0 text-muted">Total Suppliers</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="media align-items-center">
                            <div class="avatar avatar-icon avatar-lg avatar-purple">
                                <i class="anticon anticon-contacts"></i>
                            </div>
                            <div class="m-l-15">
                                <h2 class="m-b-0">{{ total_contact_people }}</h2>
                                <p class="m-b-0 text-muted">Total Contact Persons</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="media align-items-center">
                            <div class="avatar avatar-icon avatar-lg avatar-red">
                                <i class="anticon anticon-file-protect"></i>
                            </div>
                            <div class="m-l-15">
                                <h2 class="m-b-0">{{total_tenders}}</h2>
                                <p class="m-b-0 text-muted">Total Tenders</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="media align-items-center">
                            <div class="avatar avatar-icon avatar-lg avatar-green">
                                <i class="anticon anticon-file-text"></i>
                            </div>
                            <div class="m-l-15">
                                <h2 class="m-b-0">{{ total_quotations }}</h2>
                                <p class="m-b-0 text-muted">Total Quotations</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="media align-items-center">
                            <div class="avatar avatar-icon avatar-lg avatar-lime">
                                <i class="anticon anticon-shopping-cart"></i>
                            </div>
                            <div class="m-l-15">
                                <h2 class="m-b-0">{{ total_items }}</h2>
                                <p class="m-b-0 text-muted">Total Items</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="media align-items-center">
                            <div class="avatar avatar-icon avatar-lg avatar-magenta">
                                <i class="anticon anticon-user"></i>
                            </div>
                            <div class="m-l-15">
                                <h2 class="m-b-0">{{ total_users }}</h2>
                                <p class="m-b-0 text-muted">Total Users</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
export default {
    props: [
            'total_companies',
            'total_clients',
            'total_suppliers',
            'total_contact_people',
            'total_tenders',
            'total_quotations',
            'total_items',
            'total_users',
        ],
    components: {
        AuthenticatedLayout,
        Head
    },
    methods: {

    }
}
</script>

<style>

</style>
