<template>

    <Head title="Mode Of Payments" />
    <AuthenticatedLayout>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">All Mode Of Payments</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <button class="btn btn-primary btn-sm" @click="add()" v-if="checkUserPermissions('add_mode_of_payment')">
                                    <i class="anticon anticon-dollar"></i>
                                    <span>Add Mode Of Payment</span>
                                </button>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                    <label>Search:
                                        <search :url="'dashboard.mode-of-payment.index'" :searchedKeyword="searchedKeyword"></search>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-hover e-commerce-table dataTable no-footer"
                                    id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info" v-if="modeOfPayments?.data.length > 0">
                                    <thead>
                                        <tr role="row">
                                            <th style="width: 70px;">ID</th>
                                            <th style="width: 225.188px;">Name</th>
                                            <th class="text-right" style="width: 96.0125px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr role="row" class="odd" v-for="(mop,index) in modeOfPayments.data" :key="index">
                                            <td>{{ mop.id }}</td>
                                            <td class="text-capitalize">{{ mop.name }}</td>
                                            <td class="text-right">
                                                <button @click="edit(mop.id)" class="btn btn-icon btn-hover btn-sm btn-rounded pull-right" v-if="checkUserPermissions('edit_mode_of_payment')">
                                                    <i class="anticon anticon-edit"></i>
                                                </button>
                                                <button @click="onDelete(mop.id)" class="btn btn-icon btn-hover btn-sm btn-rounded" v-if="checkUserPermissions('delete_mode_of_payment')">
                                                    <i class="anticon anticon-delete"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div v-else class="pt-3 pl-3">No Data Found.</div>
                            </div>
                        </div>
                        <pagination :meta="modeOfPayments" :keyword="searchedKeyword"></pagination>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
import Helpers from '@/Mixins/Helpers';
import pagination from '@/Components/Pagination.vue';
import search from '@/Components/Search.vue';

export default {
    components: {
        AuthenticatedLayout,
        Head,
        pagination,
        search
    },
    props: ['mode_of_payments', 'searchedKeyword'],
    data() {
        return{
            modeOfPayments: this.mode_of_payments
        }
    },
    methods: {
        add(){
            this.$inertia.get(route('dashboard.mode-of-payment.create'), {
                onSuccess: () => {},
                onError: errors => {console.log(errors);}
            })
        },
        edit($id){
            this.$inertia.get(route('dashboard.mode-of-payment.edit', $id), {
                onSuccess: () => {},
                onError: errors => {console.log(errors);}
            })
        },
        onDelete($id) {
            this.swal.fire({
                title: "",
                html: "<h1 class='text-lg text-gray-800 mb-1'>Delete Record</h1><p class='text-base'>Are you sure want to delete this record?</p>",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "Delete Record",
                customClass: {
                confirmButton: 'danger'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$inertia.delete(route('dashboard.mode-of-payment.destroy', $id), {
                        preserveScroll: false,
                        onSuccess: () => {},
                        onError: errors => {console.log(errors);}
                    })
                }
            })
        }
    },
    watch: {
        mode_of_payments:{
            handler(mode_of_payments) {
                this.modeOfPayments = mode_of_payments
            },
            deep: true,
        },
    },
    mixins: [Helpers]
}
</script>

<style>

</style>
