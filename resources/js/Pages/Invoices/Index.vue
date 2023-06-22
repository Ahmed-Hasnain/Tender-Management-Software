<template>
    <Head title="Supply Orders" />
    <AuthenticatedLayout>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">All Supply Orders</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                    <label>Search:
                                        <search :url="'dashboard.invoices'" :searchedKeyword="searchedKeyword"></search>
                                    </label>
                                    <label class="px-2">
                                        <select class="form-control form-control-sm" v-model="company" @change="getInvoices()">
                                            <option value="OndreTicaretTemplate" class="text-capitalize">Ondre Ticaret</option>
                                            <option value="MSaadAndCompanyTemplate" class="text-capitalize">M Saad and Company</option>
                                            <option value="AscentTemplate" class="text-capitalize">Ascent Tech</option>
                                        </select>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-hover e-commerce-table dataTable no-footer"
                                    id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info" v-if="allSupplyOrder?.data.length > 0">
                                    <thead>
                                        <tr role="row">
                                            <th style="width: 225.188px;">Quotaion Ref#</th>
                                            <th style="width: 225.188px;">Tender Ref#</th>
                                            <th style="width: 225.188px;">File Name</th>
                                            <th style="width: 225.188px;">Price without GST</th>
                                            <th style="width: 225.188px;">Price with  GST</th>
                                            <th style="width: 225.188px;">Status</th>
                                            <th class="text-right" style="width: 300px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr role="row" class="odd" v-for="(supplyOrder, index) in allSupplyOrder.data" :key="index">
                                            <td class="text-capitalize">{{ supplyOrder.quotation?.reference_no }}</td>
                                            <td class="text-capitalize">{{ supplyOrder.quotation?.tender?.reference_no }}</td>
                                            <td class="text-capitalize">{{ supplyOrder.quotation?.tender?.file_name }}</td>
                                            <td class="text-capitalize">{{ supplyOrder.quotation?.currency }} {{ formatNumber(supplyOrder.total_price) }}</td>
                                            <td class="text-capitalize">{{ supplyOrder.quotation?.currency }} {{ getTotal(supplyOrder.total_price, calculateTax(supplyOrder.total_price, supplyOrder.quotation?.tax)) }}</td>
                                            <td class="text-capitalize">{{ supplyOrder.status }}</td>
                                            <td class="text-right">
                                                <a v-if="company" :href="route('dashboard.downloadSupplyOrder', [supplyOrder.id, company, 'sale_tax_invoice'])" class="btn btn-icon btn-hover btn-sm btn-rounded pull-right mx-1" :class="[supplyOrder.sti_downloaded ? 'bg-success text-white' : '']">
                                                    <i class="anticon anticon-dollar"></i>
                                                </a>
                                                <a v-if="company" :href="route('dashboard.downloadSupplyOrder', [supplyOrder.id, company, 'commercial_invoice'])" class="btn btn-icon btn-hover btn-sm btn-rounded pull-right" :class="[supplyOrder.ci_downloaded ? 'bg-success text-white' : '']">
                                                    <i class="anticon anticon-copyright"></i>
                                                </a>
                                                <button @click="supplyOrder.payment_recieving ? showPaymentRecieving(supplyOrder.payment_recieving.id) : addPaymentRecieving(supplyOrder.id)" class="btn btn-icon btn-hover btn-sm btn-rounded pull-right mx-1" v-if="checkUserPermissions('add_payment_recieving')" :class="[supplyOrder.payment_recieving ? 'bg-success text-white' : '']">
                                                    <i class="anticon anticon-edit"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div v-else class="pt-3 pl-3">No Data Found.</div>
                            </div>
                        </div>
                        <pagination :meta="allSupplyOrder" :keyword="searchedKeyword"></pagination>
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
    name:'Invoices',
    components: {
        AuthenticatedLayout,
        Head,
        pagination,
        search
    },
    props: ['supplyOrder', 'searchedKeyword', 'selectedCompany'],
    data() {
        return{
            allSupplyOrder: this.supplyOrder,
            company: this.selectedCompany,
        }
    },
    methods: {
        getInvoices(){
            this.$inertia.get(route('dashboard.invoices'), {company: this.company}, {
                onSuccess: () => {},
                onError: errors => {console.log(errors);}
            })
        },

        showPaymentRecieving(id){
            this.$inertia.get(route('dashboard.payment-recieving.show', id), {
                onSuccess: () => {},
                onError: errors => {console.log(errors);}
            })
        },

        addPaymentRecieving(supplyOrderId){
            this.$inertia.get(route('dashboard.payment-recieving.create'), {supplyOrder: supplyOrderId}, {
                onSuccess: () => {},
                onError: errors => {console.log(errors);}
            })
        },

        selectCompany() {
            this.swal.fire({
                title: '<strong>Select Company</strong>',
                icon: 'info',
                // html: 'You can use <b>bold text</b>, <a href="//sweetalert2.github.io">links</a> and other HTML tags',
                showCloseButton: true,
                showCancelButton: true,
                focusConfirm: false,
                confirmButtonText: '<i class="fa fa-thumbs-up"></i> Great!',
                confirmButtonAriaLabel: 'Thumbs up, great!',
                cancelButtonText: '<i class="fa fa-thumbs-down"></i>',
                cancelButtonAriaLabel: 'Thumbs down',
                input: 'select',
                inputOptions: {
                    OndreTicaretTemplate: 'Ondre Ticaret',
                    MSaadAndCompanyTemplate: 'M Saad And Company',
                    AscentTemplate: 'Ascent Tech'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const selectedOption = result.value;
                    this.company = selectedOption
                }
            });
        },
    },
    watch: {
        supplyOrder:{
            handler(supplyOrder) {
                this.allSupplyOrder = supplyOrder
            },
            deep: true,
        },
    },
    mounted(){
        console.log(this.supplyOrder);
    },
    mixins: [Helpers]
}
</script>

<style>

</style>
