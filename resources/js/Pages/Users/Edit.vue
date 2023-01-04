<template>

    <Head title="Add User" />
    <AuthenticatedLayout>
        <form v-if="form" @submit.prevent="submit" >
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Basic Infomation</h4>
                </div>
                <div class="card-body">
                    <div class="media align-items-center">
                        <div class="avatar avatar-image  m-h-10 m-r-15" style="height: 80px; width: 80px">
                            <img src="assets/images/avatars/thumb-3.jpg" alt="">
                        </div>
                        <div class="m-l-20 m-r-20">
                            <h5 class="m-b-5 font-size-18">Change Avatar</h5>
                            <p class="opacity-07 font-size-13 m-b-0">
                                Recommended Dimensions: <br>
                                120x120 Max fil size: 5MB
                            </p>
                        </div>
                        <div>
                            <button class="btn btn-tone btn-primary">Upload</button>
                        </div>
                    </div>
                    <hr class="m-v-25">
                    <div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="userName">User Name:</label>
                                <input type="text" class="form-control" id="userName" placeholder="User Name" v-model="form.name" :class="{'is-invalid' : form.errors.name}">
                                <error :message="form.errors.name"></error>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="email">Email:</label>
                                <input type="email" class="form-control" id="email" placeholder="email" v-model="form.email" :class="{'is-invalid' : form.errors.email}">
                                <error :message="form.errors.email"></error>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label class="font-weight-semibold" for="phoneNumber">Phone Number:</label>
                                <input type="number" class="form-control" id="phoneNumber" placeholder="Phone Number" v-model="form.phone" :class="{'is-invalid' : form.errors.phone}">
                                <error :message="form.errors.phone"></error>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="font-weight-semibold" for="dob">Date of Birth:</label>
                                <input type="text" class="form-control" id="dob" placeholder="Date of Birth" v-model="form.dob" :class="{'is-invalid' : form.errors.dob}">
                                <error :message="form.errors.dob"></error>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="font-weight-semibold" for="language">Type</label>
                                <select id="language" class="form-control" v-model="form.user_type" :class="{'is-invalid' : form.errors.user_type}" :disabled="form.id == $page.props.user.id">
                                    <option value="admin">Admin</option>
                                    <option value="manager">Manager</option>
                                </select>
                                <error :message="form.errors.user_type"></error>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="font-weight-semibold" for="language">Status</label>
                                <select id="language" class="form-control" v-model="form.status" :class="{'is-invalid' : form.errors.status}">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                                <error :message="form.errors.status"></error>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label class="font-weight-semibold" for="about">About</label>
                                <textarea class="form-control" rows="4" v-model="form.about" :class="{'is-invalid' : form.errors.about}"></textarea>
                                <error :message="form.errors.about"></error>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Change Password</h4>
                </div>
                <div class="card-body">
                    <div>
                        <div class="form-row">
                            <div class="form-group col-md-11">
                                <label class="font-weight-semibold" for="newPassword">New Password:</label>
                                <input type="password" class="form-control" id="newPassword" placeholder="New Password" v-model="form.password" :class="{'is-invalid' : form.errors.password}">
                                <error :message="form.errors.password"></error>
                            </div>
                            <div class="form-group col-md-1 ">
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
    components: {
        AuthenticatedLayout,
        Head,
        Error
    },
    props: ['user'],
    data() {
        return {
            singleUser: this.user,
            form: null,
        }
    },
    methods: {
        submit(){
            if (!this.form.id) {
                this.form.post(route('dashboard.user.store'), {
                    errorBag: 'user',
                    preserveScroll: true,
                    onSuccess: () => {},
                    onError: errors => {console.log(errors);}
                })
            } else {
                this.form.put(route('dashboard.user.update', this.form.id), {
                    errorBag: 'user',
                    preserveScroll: true,
                    onSuccess: () => {},
                    onError: errors => {console.log(errors);}
                })
            }
        },  
    },
    mounted() {
        this.form = useForm({
            id: this.singleUser ? this.singleUser.id : null,
            name: this.singleUser ? this.singleUser.name : null,
            email: this.singleUser ? this.singleUser.email : null,
            phone: this.singleUser ? this.singleUser.phone : null,
            about: this.singleUser ? this.singleUser.about : null,
            dob: this.singleUser ? this.singleUser.dob : null,
            user_type: this.singleUser ? this.singleUser.user_type : 'admin',
            status: this.singleUser ? this.singleUser.status : 'active',
            password: this.singleUser ? this.singleUser.password : null,
        })
    }
}
</script>

<style>

</style>
