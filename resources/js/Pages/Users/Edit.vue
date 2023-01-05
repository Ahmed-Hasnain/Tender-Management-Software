<template>
    <Head title="Add User" />
    <AuthenticatedLayout>
        <form v-if="form" @submit.prevent="submit" enctype="multipart/form-data">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Basic Infomation</h4>
                </div>
                <div class="card-body">
                    <div class="media align-items-center">
                        <div class="avatar avatar-image  m-h-10 m-r-15" style="height: 80px; width: 80px">
                            <img :src="form.avatar" alt="">
                        </div>
                        <div class="m-l-20 m-r-20">
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" @input="uploadImage($event)" :class="{'is-invalid' : form.errors?.avatar ?  form.errors?.avatar : this.$page.props?.errors?.user?.avatar}">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                            <error :message="form.errors?.avatar ?  form.errors?.avatar : this.$page.props?.errors?.user?.avatar"></error>
                        </div>
                    </div>
                    <hr class="m-v-25">
                    <div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="userName">User Name:</label>
                                <input type="text" class="form-control" id="userName" placeholder="User Name" v-model="form.name" :class="{'is-invalid' : form.errors?.name ?  form.errors?.name : this.$page.props?.errors?.user?.name}">
                                <error :message="form.errors?.name ?  form.errors?.name : this.$page.props?.errors?.user?.name"></error>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="email">Email:</label>
                                <input type="email" class="form-control" id="email" placeholder="email" v-model="form.email" :class="{'is-invalid' : form.errors?.email ?  form.errors?.email : this.$page.props?.errors?.user?.email}">
                                <error :message="form.errors?.email ?  form.errors?.email : this.$page.props?.errors?.user?.email"></error>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label class="font-weight-semibold" for="phoneNumber">Phone Number:</label>
                                <input type="number" class="form-control" id="phoneNumber" placeholder="Phone Number" v-model="form.phone" :class="{'is-invalid' : form.errors?.phone ?  form.errors?.phone : this.$page.props.errors?.user?.phone}">
                                <error :message="form.errors?.phone ?  form.errors?.phone : this.$page.props.errors?.user?.phone"></error>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="font-weight-semibold" for="dob">Date of Birth:</label>
                                <input type="text" class="form-control" id="dob" placeholder="Date of Birth" v-model="form.dob" :class="{'is-invalid' : form.errors?.dob ?  form.errors?.dob : this.$page.props?.errors?.user?.dob}">
                                <error :message="form.errors?.dob ?  form.errors?.dob : this.$page.props?.errors?.user?.dob"></error>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="font-weight-semibold" for="language">Type</label>
                                <select id="language" class="form-control" v-model="form.user_type" :class="{'is-invalid' : form.errors?.user_type ?  form.errors?.user_type : this.$page.props?.errors?.user?.user_type}" :disabled="form.id && form.id == $page.props.user.id">
                                    <option value="admin">Admin</option>
                                    <option value="manager">Manager</option>
                                </select>
                                <error :message="form.errors?.user_type ?  form.errors?.user_type : this.$page.props?.errors?.user?.user_type"></error>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="font-weight-semibold" for="language">Status</label>
                                <select id="language" class="form-control" v-model="form.status" :class="{'is-invalid' : form.errors?.status ?  form.errors?.status : this.$page.props?.errors?.user?.status}">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                                <error :message="form.errors?.status ?  form.errors?.status : this.$page.props?.errors?.user?.status"></error>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label class="font-weight-semibold" for="about">About</label>
                                <textarea class="form-control" rows="4" v-model="form.about" :class="{'is-invalid' : form.errors?.about ?  form.errors?.about : this.$page.props?.errors?.user?.about}"></textarea>
                                <error :message="form.errors?.about ?  form.errors?.about : this.$page.props?.errors?.user?.about"></error>
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
                                <input type="password" class="form-control" id="newPassword" placeholder="New Password" v-model="form.password" :class="{'is-invalid' : form.errors?.password ?  form.errors?.password : this.$page.props?.errors?.user?.password}">
                                <error :message="form.errors?.password ?  form.errors?.password : this.$page.props?.errors?.user?.password"></error>
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
import { Inertia } from '@inertiajs/inertia'

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
                Inertia.post(route('dashboard.user.update', this.form.id), {
                    _method: 'put',
                    id:  this.form.id,
                    name:  this.form.name,
                    email:  this.form.email,
                    phone:  this.form.phone,
                    about:  this.form.about,
                    dob:  this.form.dob,
                    user_type:  this.form.user_type, 
                    status:  this.form.status, 
                    password:  this.form.password,
                    avatar:  this.form.avatar,
                },{
                    errorBag: 'user',
                    onSuccess: () => {},
                    onError: errors => {console.log(errors);}
                })
            }
        },  
        uploadImage(event){
            this.form.avatar = event.target.files[0]
        }
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
            avatar: this.singleUser ? this.singleUser.avatar : null,
        })
    },
}
</script>

<style>

</style>
