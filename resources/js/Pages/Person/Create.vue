<template>
    <Head title="Add Person" />
    <AuthenticatedLayout>
        <form v-if="form" @submit.prevent="submit">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Person</h4>
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
                                <label class="font-weight-semibold" for="Email">Email:</label>
                                <input type="text" class="form-control" id="Email" placeholder="Email" v-model="form.email" :class="{'is-invalid' : form.errors?.email}">
                                <error :message="form.errors?.email"></error>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="Mobile Number">Mobile Number:</label>
                                <input type="text" class="form-control" id="Mobile_Number" placeholder="Mobile Number" v-model="form.mobile_no" :class="{'is-invalid' : form.errors?.mobile_no}">
                                <error :message="form.errors?.mobile_no"></error>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="phone number">Phone Number:</label>
                                <input type="text" class="form-control" id="phone_number" placeholder="City" v-model="form.phone_no" :class="{'is-invalid' : form.errors?.phone_no}">
                                <error :message="form.errors?.phone_no"></error>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label class="font-weight-semibold" for="Category">Departments:</label>
                                <select id="language" class="form-control" v-model="form.department" :class="{'is-invalid' : form.errors?.department}">
                                    <option class="text-capitalize">Human Resources</option>
                                    <option class="text-capitalize">Accounting and Finance</option>
                                    <option class="text-capitalize">Sales and Marketing</option>
                                    <option class="text-capitalize">Operations</option>
                                    <option class="text-capitalize">Information Technology</option>
                                    <option class="text-capitalize">Customer Service</option>
                                    <option class="text-capitalize">Research and Development</option>
                                    <option class="text-capitalize">Legal</option>
                                    <option class="text-capitalize">Quality Assurance</option>
                                    <option class="text-capitalize">Supply Chain</option>
                                    <option class="text-capitalize">unknown</option>
                                </select>
                                <error :message="form.errors?.department"></error>
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

export default {
    props:['company_id', 'type'],
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
            this.form.type = this.type
            console.log(this.form.type, this.type);
            this.form.post(route('dashboard.company.person.store', this.company_id), {
                errorBag: 'person',
                preserveScroll: true,
                onSuccess: () => {},
                onError: errors => {console.log(errors);}
            })
        },  
    },
    mounted() {
        this.form = useForm({
            name: null,
            email: null,
            mobile_no: null,
            phone_no: null,
            department: null,
            type: null
        })
    },
}
</script>

<style>

</style>
