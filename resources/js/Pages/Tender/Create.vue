<template>
    <Head title="Add Tender" />
    <AuthenticatedLayout>
        <form v-if="form" @submit.prevent="submit">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Tender</h4>
                </div>
                <div class="card-body">
                    <div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="Name">Reference No:</label>
                                <input type="text" class="form-control" id="name" placeholder="Reference Number" v-model="form.reference_no" :class="{'is-invalid' : form.errors?.reference_no}">
                                <error :message="form.errors?.reference_no"></error>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="file_name">File Name:</label>
                                <input type="text" class="form-control" id="file_name" placeholder="File Name" v-model="form.file_name" :class="{'is-invalid' : form.errors?.file_name}">
                                <error :message="form.errors?.file_name"></error>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="Category">Company:</label>
                                <select id="language" class="form-control" v-model="form.company_id" :class="{'is-invalid' : form.errors?.company_id}">
                                    <option v-for="(company,index) in companies" :key="index" :value="company.id" class="text-capitalize">{{ company.name }}</option>
                                </select>
                                <error :message="form.errors?.company_id"></error>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="Category">Type Of Demand:</label>
                                <select id="language" class="form-control" v-model="form.demand_id" :class="{'is-invalid' : form.errors?.demand_id}">
                                    <option v-for="(demand,index) in demands" :key="index" :value="demand.id" class="text-capitalize">{{ demand.name }}</option>
                                </select>
                                <error :message="form.errors?.demand_id"></error>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="Category">Clients:</label>
                                <select id="language" class="form-control" v-model="form.client_id" :class="{'is-invalid' : form.errors?.client_id}">
                                    <option v-for="(client,index) in clients" :key="index" :value="client.id" class="text-capitalize">{{ client.name }}</option>
                                </select>
                                <error :message="form.errors?.client_id"></error>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="Category">Mode Of Payment:</label>
                                <select id="language" class="form-control" v-model="form.mode_of_payment_id" :class="{'is-invalid' : form.errors?.mode_of_payment_id}">
                                    <option v-for="(mop,index) in mode_of_payment" :key="index" :value="mop.id" class="text-capitalize">{{ mop.name }}</option>
                                </select>
                                <error :message="form.errors?.mode_of_payment_id"></error>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label class="font-weight-semibold" for="rfq_date">RFQ Date:</label>
                                <Datepicker v-model="form.rfq_date" :enable-time-picker="false"></Datepicker>
                                <error :message="form.errors?.rfq_date"></error>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="font-weight-semibold" for="last_date_of_submission">Last Date of Submission:</label>
                                <Datepicker v-model="form.last_date_of_submission" :enable-time-picker="false"></Datepicker>
                                <error :message="form.errors?.last_date_of_submission"></error>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="font-weight-semibold" for="validity_of_quotation">Validity of Quotation:</label>
                                <Datepicker v-model="form.validity_of_quotation" :enable-time-picker="false"></Datepicker>
                                <error :message="form.errors?.validity_of_quotation"></error>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="rate_basis">Rate Basis:</label>
                                <input type="text" class="form-control" id="rate_basis" placeholder="Rate Basis" v-model="form.rate_basis" :class="{'is-invalid' : form.errors?.rate_basis}">
                                <error :message="form.errors?.rate_basis"></error>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="delivery_time">Delivery Time:</label>
                                <input type="text" class="form-control" id="delivery_time" placeholder="Delivery Time" v-model="form.delivery_time" :class="{'is-invalid' : form.errors?.delivery_time}">
                                <error :message="form.errors?.delivery_time"></error>
                            </div>
                        </div>                       
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Item</h4>
                </div>
                <div class="card-body">
                    <div>
                        <div v-for="(tenderItem ,index) in form.items" :key="index">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label class="font-weight-semibold" for="Bank Name">Item</label>
                                    <select id="language" class="form-control" v-model="tenderItem.item_id">
                                        <option v-for="(item,index) in items" :key="index" :value="item.id" class="text-capitalize">{{ item.name }}</option>
                                    </select>
                                    <error :message="form.errors[`items.${index}.item_id`]"></error>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="font-weight-semibold" for="Account Title">Unit</label>
                                    <select id="language" class="form-control" v-model="tenderItem.unit_id">
                                        <option v-for="(unit,index) in units" :key="index" :value="unit.id" class="text-capitalize">{{ unit.full_name }}</option>
                                    </select>
                                    <error :message="form.errors[`items.${index}.unit_id`]"></error>
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="font-weight-semibold" for="Account Title">Quantity</label>
                                    <input type="number" class="form-control" placeholder="Quantity" v-model="tenderItem.qty">
                                    <error :message="form.errors[`items.${index}.qty`]"></error>
                                </div>
                                <div class="form-group col-md-2" style="align-self: center; padding-top: 49px;">
                                    <i class="anticon anticon-plus-square" style="font-size: 50px;" @click="addItem()"></i>
                                    <i class="anticon anticon-minus-square" style="font-size: 50px;" @click="removeItem(index)" v-if="form.items.length > 1 && index > 0"></i>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-10">
                                    <label class="font-weight-semibold" for="description">Item Description:</label>
                                    <textarea class="form-control" rows="1" v-model="tenderItem.description"></textarea>
                                    <error :message="form.errors[`items.${index}.description`]"></error>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                <textarea class="form-control" rows="4" v-model="form.description" :class="{'is-invalid' : form.errors.description}"></textarea>
                                <error :message="form.errors?.description"></error>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="special_terms">Special Terms:</label>
                                <textarea class="form-control" rows="4" v-model="form.special_terms" :class="{'is-invalid' : form.errors.special_terms}"></textarea>
                                <error :message="form.errors?.special_terms"></error>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-11">
                            </div>
                            <div class="form-group col-md-1 text-left">
                                <button class="btn btn-primary m-t-30 " :disabled="form.processing" :classes="form.processing ? 'btn btn-primary is-loading m-r-5' : 'btn btn-primary m-t-30'">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';
import Error from '@/Components/InputError.vue';
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

export default {
    props:['mode_of_payment', 'clients', 'items', 'units', 'companies', 'demands'],
    components: {
        AuthenticatedLayout,
        Head,
        Error,
        Datepicker
    },
    data() {
        return {
            form: null,
        }
    },
    methods: {
        submit(){
            this.form.post(route('dashboard.tender.store'), {
                errorBag: 'tender',
                preserveScroll: true,
                onSuccess: () => {},
                onError: errors => {console.log(errors);}
            })
        },  
        addItem() {
            this.form.items.push({
                item_id: null,
                unit_id: null,
                qty: null,
                description: null,
            })
        },
        removeItem(index) {
            this.form.items.splice(index, 1)
        }
    },
    mounted() {
        this.form = useForm({
            reference_no: null,
            file_name: null,
            rate_basis: null,
            delivery_time: null,
            description: null,
            special_terms: null,
            rfq_date: null,
            last_date_of_submission: null,
            validity_of_quotation: null,
            client_id : null,
            mode_of_payment_id : null,
            company_id : null,
            demand_id : null,
            items: [
                {
                    item_id: null,
                    unit_id: null,
                    qty: null,
                    description: null,
                }
            ]
        })
    },
}
</script>

<style>

</style>
