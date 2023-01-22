<template>

    <Head title="Client Detail" />
    <AuthenticatedLayout>
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <div class="d-md-flex align-items-center">
                            <div class="text-center text-sm-left m-v-15">
                                <h2 class="m-b-5 text-capitalize">{{ client.name }}</h2>
                                <p class="text-opacity font-size-13">
                                    {{ client.website }}
                                </p>
                                <p class="text-dark m-b-20">
                                    Frontend Developer, UI/UX Designer
                                </p>
                                <button class="btn btn-primary btn-tone">
                                    Contact
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5>Address</h5>
                                <div class="m-t-20">
                                    <div class="media m-b-30">
                                        <div class="avatar avatar-image">
                                            <i class="anticon anticon-check" style="color:black"></i>
                                        </div>
                                        <div class="media-body m-l-20">
                                            <h6 class="m-b-0 text-capitalize">{{ client.address }}</h6>
                                            <span class="font-size-13 text-gray text-capitalize">Address</span>
                                        </div>
                                    </div>
                                    <div class="media m-b-30">
                                        <div class="avatar avatar-image">
                                            <i class="anticon anticon-check" style="color:black"></i>
                                        </div>
                                        <div class="media-body m-l-20">
                                            <h6 class="m-b-0 text-capitalize">{{ client.city }}</h6>
                                            <span class="font-size-13 text-gray text-capitalize">City</span>
                                        </div>
                                    </div>
                                    <div class="media m-b-30">
                                        <div class="avatar avatar-image">
                                            <i class="anticon anticon-check" style="color:black"></i>
                                        </div>
                                        <div class="media-body m-l-20">
                                            <h6 class="m-b-0 text-capitalize">{{ client.district }}</h6>
                                            <span class="font-size-13 text-gray text-capitalize">District</span>
                                        </div>
                                    </div>
                                    <div class="media m-b-30">
                                        <div class="avatar avatar-image">
                                            <i class="anticon anticon-check" style="color:black"></i>
                                        </div>
                                        <div class="media-body m-l-20">
                                            <h6 class="m-b-0 text-capitalize">{{ client.country }}</h6>
                                            <span class="font-size-13 text-gray text-capitalize">Country</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h5>Team</h5>
                        <button class="btn btn-primary btn-tone mb-3" @click="addPerson()">
                            Add Person
                        </button>
                        <div class="row" id="card-view" v-if="people.length > 0">
                            <div class="col-md-4" v-for="(person,index) in people" :key="index">
                                <person :person="person" :companyId="client.id"></person>
                            </div>
                        </div>
                        <div v-else>No record Found</div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head, useForm } from "@inertiajs/inertia-vue3";
import Error from "@/Components/InputError.vue";
import person from "@/Components/person.vue";

export default {
    props: ["client", "people"],
    components: {
        AuthenticatedLayout,
        Head,
        Error,
        person
    },
    data() {
        return {};
    },
    methods: {
        addPerson() {
            this.$inertia.get(route('dashboard.company.person.create', this.client.id), {type: 'client'}, {
                onSuccess: () => {},
                onError: errors => {console.log(errors);}
            })
        }
    },
    mounted() { 

    },
};
</script>

<style>

</style>
