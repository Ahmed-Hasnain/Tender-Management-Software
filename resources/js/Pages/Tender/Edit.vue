<template>

    <Head title="Edit Tender" />
    <AuthenticatedLayout>
        <form v-if="form" @submit.prevent="submit">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Tender</h4>
                </div>
                <div class="card-body">
                    <div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="Name">Reference No:</label>
                                <input type="text" class="form-control" id="name" placeholder="Reference Number"
                                    v-model="form.reference_no" :class="{ 'is-invalid': form.errors?.reference_no }">
                                <error :message="form.errors?.reference_no"></error>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="file_name">File Name:</label>
                                <input type="text" class="form-control" id="file_name" placeholder="File Name"
                                    v-model="form.file_name" :class="{ 'is-invalid': form.errors?.file_name }">
                                <error :message="form.errors?.file_name"></error>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="Category">Company:</label>
                                <select id="language" class="form-control" v-model="form.company_id"
                                    :class="{ 'is-invalid': form.errors?.company_id }">
                                    <option v-for="(company, index) in $page.props.companies" :key="index" :value="company.id"
                                        class="text-capitalize">{{ company.name }}</option>
                                </select>
                                <error :message="form.errors?.company_id"></error>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="Category">Type Of Demand:</label>
                                <select id="language" class="form-control" v-model="form.demand_id"
                                    :class="{ 'is-invalid': form.errors?.demand_id }">
                                    <option v-for="(demand, index) in $page.props.demands" :key="index" :value="demand.id"
                                        class="text-capitalize">{{ demand.name }}</option>
                                </select>
                                <error :message="form.errors?.demand_id"></error>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="Category">Clients:</label>
                                <select id="language" class="form-control" v-model="form.client_id"
                                    :class="{ 'is-invalid': form.errors?.client_id }">
                                    <option v-for="(client, index) in $page.props.clients" :key="index" :value="client.id"
                                        class="text-capitalize">{{ client.name }}</option>
                                </select>
                                <error :message="form.errors?.client_id"></error>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="Category">Mode Of Payment:</label>
                                <select id="language" class="form-control" v-model="form.mode_of_payment_id"
                                    :class="{ 'is-invalid': form.errors?.mode_of_payment_id }">
                                    <option v-for="(mop, index) in $page.props.mode_of_payment" :key="index" :value="mop.id"
                                        class="text-capitalize">{{ mop.name }}</option>
                                </select>
                                <error :message="form.errors?.mode_of_payment_id"></error>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="rfq_date">RFQ Date:</label>
                                <Datepicker v-model="form.rfq_date" :enable-time-picker="false"></Datepicker>
                                <error :message="form.errors?.rfq_date"></error>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="last_date_of_submission">Last Date of
                                    Submission:</label>
                                <Datepicker v-model="form.last_date_of_submission" :enable-time-picker="false">
                                </Datepicker>
                                <error :message="form.errors?.last_date_of_submission"></error>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="rate_basis">Rate Basis:</label>
                                <input type="text" class="form-control" id="rate_basis" placeholder="Rate Basis"
                                    v-model="form.rate_basis" :class="{ 'is-invalid': form.errors?.rate_basis }">
                                <error :message="form.errors?.rate_basis"></error>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="card-title">Tender Items</h4>
                        </div>
                        <div class="col-md-6 text-right m-auto">
                            <a class="btn btn-primary btn-sm text-light" @click="openModal('add')" v-if="checkUserPermissions('add_tender')">
                                <i class="anticon anticon-file-protect"></i>
                                <span>Add Tender Item</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                        <div class="table-responsive" v-if="form.items.length > 0">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 60px;">Id</th>
                                        <th scope="col">Name</th>
                                        <th scope="col" style="width: 200px;">Unit</th>
                                        <th scope="col" style="width: 200px;">Quantity</th>
                                        <th scope="col" style="width: 200px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(tenderItem, index) in form.items" :key="index">
                                        <th scope="row">{{ index+1 }}</th>
                                        <td class="text-capitalize">{{ tenderItem.item?.name }}<br><small>{{ tenderItem.description }}</small></td>
                                        <td class="text-capitalize">{{ tenderItem.unit?.full_name }}</td>
                                        <td class="text-capitalize">{{tenderItem.qty}}</td>
                                        <td class="text-capitalize">
                                            <a @click="openModal('edit', tenderItem.id)" class="btn btn-icon btn-hover btn-sm btn-rounded pull-right" v-if="checkUserPermissions('edit_tender')">
                                                <i class="anticon anticon-edit"></i>
                                            </a>
                                            <a @click="onDelete(tenderItem.id)" class="btn btn-icon btn-hover btn-sm btn-rounded" v-if="checkUserPermissions('delete_tender')">
                                                <i class="anticon anticon-delete"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div v-else>No record Found</div>
                    </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Others Details</h4>
                </div>
                <div class="card-body">
                    <div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="description">Tender Description:</label>
                                <textarea class="form-control" rows="4" v-model="form.description"
                                    :class="{ 'is-invalid': form.errors.description }"></textarea>
                                <error :message="form.errors?.description"></error>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="special_terms">Special Terms:</label>
                                <textarea class="form-control" rows="4" v-model="form.special_terms"
                                    :class="{ 'is-invalid': form.errors.special_terms }"></textarea>
                                <error :message="form.errors?.special_terms"></error>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-11">
                            </div>
                            <div class="form-group col-md-1 text-left">
                                <button class="btn btn-primary m-t-30 " :disabled="form.processing"
                                    :classes="form.processing ? 'btn btn-primary is-loading m-r-5' : 'btn btn-primary m-t-30'">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <ItemModal></ItemModal>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';
import Error from '@/Components/InputError.vue';
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import ItemModal from './ItemModal.vue';
import Helpers from '@/Mixins/Helpers';

export default {
    props: ['mode_of_payment', 'clients', 'items', 'units', 'companies', 'demands', 'tender'],
    components: {
        AuthenticatedLayout,
        Head,
        Error,
        Datepicker,
        ItemModal
    },
    data() {
        return {
            form: null,
        }
    },
    methods: {
        submit() {
            this.form.put(route('dashboard.tender.update', this.form.id), {
                errorBag: 'tender',
                preserveScroll: true,
                onSuccess: () => { },
                onError: errors => { console.log(errors); }
            })
        },
        openModal(action , id = null){
            var item = id ? this.form.items.filter((item) => item.id == id)[0] : null
            this.emitter.emit('open_modal', {
                tender_id: this.form.id,
                item: item,
                action: action,
            });
        },
        createFormObject(){
            this.form = useForm({
                id: this.tender ? this.tender.id : null,
                reference_no: this.tender ? this.tender.reference_no : null,
                file_name: this.tender ? this.tender.file_name : null,
                rate_basis: this.tender ? this.tender.rate_basis : null,
                delivery_time: this.tender ? this.tender.delivery_time : null,
                description: this.tender ? this.tender.description : null,
                special_terms: this.tender ? this.tender.special_terms : null,
                rfq_date: this.tender ? this.tender.rfq_date : null,
                last_date_of_submission: this.tender ? this.tender.last_date_of_submission : null,
                validity_of_quotation: this.tender ? this.tender.validity_of_quotation : null,
                client_id: this.tender ? this.tender.client_id : null,
                mode_of_payment_id: this.tender ? this.tender.mode_of_payment_id : null,
                company_id: this.tender ? this.tender.company_id : null,
                demand_id: this.tender ? this.tender.demand_id : null,
                items: this.tender ? this.tender.items : null,
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
                    this.$inertia.delete(route('dashboard.tender-item.destroy', $id), {
                        preserveScroll: false,
                        onSuccess: () => {},
                        onError: errors => {console.log(errors);}
                    })
                }
            })
        },
    },
    mounted() {
        this.createFormObject()
    },
    updated() {
        this.createFormObject()
        this.scrollToBottom()
    },
    mixins: [Helpers]
}
</script>

<style>

</style>
