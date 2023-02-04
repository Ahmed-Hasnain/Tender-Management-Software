<template>

    <Head title="Edit Quotation" />
    <AuthenticatedLayout>
        <form v-if="form" @submit.prevent="submit">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Quotation</h4>
                </div>
                <div class="card-body">
                    <div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label class="font-weight-semibold" for="currency">Currency:</label>
                                <select id="language" class="form-control" v-model="form.currency">
                                    <option value="PKR" class="text-capitalize">PKR</option>
                                    <option value="USD" class="text-capitalize">USD</option>
                                    <option value="EUR" class="text-capitalize">EUR</option>
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
                                <div class="table-responsive" v-if="this.form.items.length > 0">
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
                                            <tr v-for="(item, index) in this.form.items" :key="index">
                                                <th scope="row">{{ item.id }}</th>
                                                <td class="text-capitalize">{{ item.tender_item?.item?.name }}</td>
                                                <td class="text-capitalize">{{ item.tender_item?.unit?.full_name }}</td>
                                                <td class="text-capitalize">{{ item.tender_item?.qty }}</td>
                                                <td class="text-capitalize"> 
                                                    <input type="number" class="form-control" id="name" placeholder="Unit Price" v-model="item.unit_price" >
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
    props: ['quotation', 'quotation_items'],
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
            this.form.put(route('dashboard.quotation.update', this.form.id), {
                errorBag: 'quotation',
                preserveScroll: true,
                onSuccess: () => { },
                onError: errors => { console.log(errors); }
            })
        },
    },
    mounted() {
        this.form = useForm({
            id: this.quotation ? this.quotation.id : null,
            currency: this.quotation ? this.quotation.currency : null,
            terms_and_conditions: this.quotation ? this.quotation.terms_and_conditions : null,
            items: this.quotation_items,
        })
    },
}
</script>

<style>

</style>
