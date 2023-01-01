<template>
    <Head title="Log in" />
    <!--begin::Wrapper-->
    <div class="container-fluid p-h-0 p-v-20 bg full-height d-flex" style="background-image: url('assets/images/others/login-3.png')">
        <div class="d-flex flex-column justify-content-between w-100">
            <div class="container d-flex h-100">
                <div class="row align-items-center w-100">
                    <div class="col-md-7 col-lg-5 m-h-auto">
                        <div class="card shadow-lg">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between m-b-30">
                                    <img class="img-fluid" alt="" src="assets/images/logo/logo.png">
                                    <h2 class="m-b-0">Sign In</h2>
                                </div>
                                <form @submit.prevent="submit">
                                    <div class="form-group">
                                        <label class="font-weight-semibold" for="userName">Username:</label>
                                        <div class="input-affix">
                                            <i class="prefix-icon anticon anticon-user"></i>
                                            <Input id="email" type="email" v-model="form.email" autofocus
                                            autocomplete="username" placeholder="Enter Email"
                                            :class="{'is-invalid' : form.errors.email}"
                                            class="form-control"/>
                                        </div>
                                        <error :message="form.errors.email"></error>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="font-weight-semibold" for="password">Password:</label>
                                        <a class="float-right font-size-13 text-muted" href="">Forget Password?</a>
                                        <div class="input-affix m-b-10">
                                            <i class="prefix-icon anticon anticon-lock"></i>
                                            <Input id="password" type="password" v-model="form.password" autocomplete="off" 
                                            placeholder="Enter Password" class="form-control"
                                            :class="{'is-invalid' : form.errors.password}"/>
                                        </div>
                                        <error :message="form.errors.password"></error>
                                    </div>
                                    <div class="form-group">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <!-- <span class="font-size-13 text-muted">
                                                Don't have an account? 
                                                <a class="small" href=""> Signup</a>
                                            </span> -->
                                            <Button :disabled="form.processing" :btnWidth="'w-100'" ref="submitButton" :classes="form.processing ? 'btn btn-primary is-loading m-r-5' : 'btn btn-primary btn-tone m-r-5'">
                                                <span v-if="!form.processing"> Sign in </span>
                                                <span v-if="form.processing">
                                                    <i class="anticon anticon-loading m-r-5"></i>
                                                    <span>Loading</span>
                                                </span>
                                            </Button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Button from '@/Components/Button.vue'
import BreezeGuestLayout from '@/Layouts/Guest.vue'
import Input from '@/Components/Input.vue'
import Label from '@/Components/Label.vue'
import { Head, Link } from '@inertiajs/inertia-vue3';
import Error from '@/Components/InputError.vue'

export default {
    layout: BreezeGuestLayout,

    components: {
        Button,
        Input,
        Label,
        Head,
        Link,
        Error
    },

    props: {
        canResetPassword: Boolean,
        status: String,
    },

    data() {
        return {
            form: this.$inertia.form({
                email: '',
                password: '',
                remember: false
            })
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('login'), {
                onFinish: () => {
                    this.form.reset('password')
                }
            })
        }
    }
}
</script>
