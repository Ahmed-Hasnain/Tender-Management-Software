<template>
    <Head title="Add Client" />
    <AuthenticatedLayout>
        <form v-if="form" @submit.prevent="submit">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Client</h4>
                </div>
                <div class="card-body">
                    <div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="Name">Name:</label>
                                <input type="text" class="form-control" id="name" placeholder="Name" v-model="form.name" :class="{'is-invalid' : form.errors?.name}">
                                <error :message="form.errors?.name"></error>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="Website">Website:</label>
                                <input type="text" class="form-control" id="name" placeholder="Website" v-model="form.website" :class="{'is-invalid' : form.errors?.website}">
                                <error :message="form.errors?.website"></error>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="Address">Address:</label>
                                <input type="text" class="form-control" id="name" placeholder="Address" v-model="form.address" :class="{'is-invalid' : form.errors?.address}">
                                <error :message="form.errors?.address"></error>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="City">City:</label>
                                <input type="text" class="form-control" id="name" placeholder="City" v-model="form.city" :class="{'is-invalid' : form.errors?.city}">
                                <error :message="form.errors?.city"></error>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="District">District:</label>
                                <input type="text" class="form-control" id="name" placeholder="District" v-model="form.district" :class="{'is-invalid' : form.errors?.district}">
                                <error :message="form.errors?.district"></error>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="Country">Country:</label>
                                <input type="text" class="form-control" id="name" placeholder="Country" v-model="form.country" :class="{'is-invalid' : form.errors?.country}">
                                <error :message="form.errors?.country"></error>
                            </div>
                        </div>
                        <!-- <div class="form-row">
                            <div class="form-group col-md-12">
                                <label class="font-weight-semibold" for="Category">Category:</label>
                                <select id="language" class="form-control" v-model="form.category_id" :class="{'is-invalid' : form.errors?.category_id}">
                                    <option v-for="(category,index) in categories" :key="index" :value="category.id" class="text-capitalize">{{ category.name }}</option>
                                </select>
                            </div>
                        </div> -->
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label class="font-weight-semibold" for="notes">Notes:</label>
                                <textarea class="form-control" rows="4" v-model="form.notes" :class="{'is-invalid' : form.errors.notes}"></textarea>
                                <error :message="form.errors?.notes"></error>
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
import Error from '@/Components/InputError.vue'

export default {
    props:['categories'],
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
        submit(){
            this.form.post(route('dashboard.client.store'), {
                errorBag: 'client',
                preserveScroll: true,
                onSuccess: () => {},
                onError: errors => {console.log(errors);}
            })
        },  
    },
    mounted() {
        this.form = useForm({
            name: null,
            website: null,
            address: null,
            city: null,
            district: null,
            country: null,
            category_id: null,
            notes: null,
        })
    },
}
</script>

<style>

</style>
