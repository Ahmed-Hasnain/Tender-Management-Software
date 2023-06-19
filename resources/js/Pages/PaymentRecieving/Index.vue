<template>
    <Head title="Payment Recieving" />
    <AuthenticatedLayout>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">All Payment Recievings</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <!-- <button class="btn btn-primary btn-sm" @click="add()" v-if="checkUserPermissions('add_payment_recieving')">
                                    <i class="anticon anticon-file-protect"></i>
                                    <span>Add Payment Recievings</span>
                                </button>  -->
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                    <label>Search:
                                        <search :url="'dashboard.payment-recieving.index'" :searchedKeyword="searchedKeyword"></search>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-hover e-commerce-table dataTable no-footer"
                                    id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info" v-if="allPayments?.data.length > 0">
                                    <thead>
                                        <tr role="row">
                                            <th style="width: 225.188px;">Quotation Ref</th>
                                            <th style="width: 225.188px;">Serial no.</th>
                                            <th style="width: 225.188px;">Bank Name</th>
                                            <th style="width: 225.188px;">Cheque Amount</th>
                                            <th style="width: 225.188px;">Company</th>
                                            <th class="text-right" style="width: 255.188px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr role="row" class="odd" v-for="(payment,index) in allPayments.data" :key="index">
                                            <td class="text-capitalize">{{ payment.supply_order?.quotation?.reference_no }}</td>
                                            <td class="text-capitalize">{{ payment.serial_no }}</td>
                                            <td class="text-capitalize">{{ removeDashes(payment.bank_name) }}</td>
                                            <td class="text-capitalize">{{ payment.supply_order?.quotation?.currency }} {{ formatNumber(payment.cheque_amount) }}</td>
                                            <td class="text-capitalize">{{ payment.supply_order?.quotation?.tender?.company?.name }}</td>
                                            <td class="text-right">
                                                <button @click="show(payment.id)" class="btn btn-icon btn-hover btn-sm btn-rounded pull-right" v-if="checkUserPermissions('view_payment_recieving')">
                                                    <i class="anticon anticon-eye"></i>
                                                </button>
                                                <button @click="edit(payment.id)" class="btn btn-icon btn-hover btn-sm btn-rounded pull-right" v-if="checkUserPermissions('edit_payment_recieving')">
                                                    <i class="anticon anticon-edit"></i>
                                                </button>
                                                <button @click="onDelete(payment.id)" class="btn btn-icon btn-hover btn-sm btn-rounded" v-if="checkUserPermissions('delete_payment_recieving')">
                                                    <i class="anticon anticon-delete"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div v-else class="pt-3 pl-3">No Data Found.</div>
                            </div>
                        </div>
                        <pagination :meta="allPayments" :keyword="searchedKeyword"></pagination>
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
    props: ['paymentRecieving', 'searchedKeyword'],
    data() {
        return{
            allPayments: this.paymentRecieving
        }
    },
    methods: {
        edit($id){
            this.$inertia.get(route('dashboard.payment-recieving.edit', $id), {
                onSuccess: () => {},
                onError: errors => {console.log(errors);}
            })
        },
        show($id){
            this.$inertia.get(route('dashboard.payment-recieving.show', $id), {
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
                    this.$inertia.delete(route('dashboard.payment-recieving.destroy', $id), {
                        preserveScroll: false,
                        onSuccess: () => {},
                        onError: errors => {console.log(errors);}
                    })
                }
            })
        },
    },
    watch: {
        paymentRecieving:{
            handler(paymentRecieving) {
                this.allPayments = paymentRecieving
            },
            deep: true,
        },
    },
    mounted() {
        console.log(this.paymentRecieving);
    },
    mixins: [Helpers]
}
</script>

<style>

</style>
