<template>

    <Head title="Add Quotation" />
    <AuthenticatedLayout>
        <form v-if="form" @submit.prevent="submit">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Quotation</h4>
                </div>
                <div class="card-body">
                    <div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label class="font-weight-semibold" for="currency">Currency:</label>
                                <select id="language" class="form-control" v-model="form.currency">
                                    <option value="Rs" class="text-capitalize">PKR</option>
                                    <option value="$" class="text-capitalize">USD</option>
                                    <option value="€" class="text-capitalize">EUR</option>
                                </select>
                                <error :message="form.errors?.currency"></error>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label class="font-weight-semibold" for="terms_and_conditions">Terms and
                                    Conditions:</label>
                                <textarea class="form-control" rows="2" v-model="form.terms_and_conditions"
                                    :class="{ 'is-invalid': form.errors.terms_and_conditions }"></textarea>
                                <error :message="form.errors?.terms_and_conditions"></error>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <div class="table-responsive" v-if="tender_items.length > 0">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">Id</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Unit</th>
                                                <th scope="col">Quantity</th>
                                                <th scope="col" style="width: 250px;">Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item, index) in tender_items" :key="index">
                                                <th scope="row">{{ item.id }}</th>
                                                <td class="text-capitalize">{{ item.item?.name }}</td>
                                                <td class="text-capitalize">{{ item.unit?.full_name }}</td>
                                                <td class="text-capitalize">{{ item.qty }}</td>
                                                <td class="text-capitalize"> 
                                                    <input type="number" class="form-control" id="name" placeholder="Unit Price" v-model="form.items[index].unit_price" :class="{'is-invalid' : form.errors?.reference_no}">
                                                    {{ this.setTenderItemId(item.id, index) }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div v-else>No record Found</div>
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
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';
import Error from '@/Components/InputError.vue'

export default {
    props: ['tender_items'],
    components: {
        AuthenticatedLayout,
        Head,
        Error
    },
    data() {
        return {
            form: null,
        }
    },
    methods: {
        submit() {
            this.form.tender_id = this.tender_items[0].tender_id
            this.form.post(route('dashboard.quotation.store'), {
                errorBag: 'quotation',
                preserveScroll: true,
                onSuccess: () => { },
                onError: errors => { console.log(errors); }
            })
        },
        addItems() {
            this.tender_items.forEach((val, index) => {
                this.form.items.push({
                    tender_item_id: null,
                    unit_price: null,
                })
            })
        },
        setTenderItemId(id, index) {
            this.form.items[index].tender_item_id = id
        }
    },
    mounted() {
        this.form = useForm({
            currency: null,
            terms_and_conditions: null,
            tender_id: null,
            items: [],
        })
        this.addItems()
    },
}
</script>

<style>

</style>
