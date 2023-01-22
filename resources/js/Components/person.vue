<template>
    <div class="card">
        <div class="card-body">
            <div class="">
                <h4 class="mb-3 text-capitalize">{{ person.name }}</h4>
                <div class="media m-b-20">
                    <div class="avatar avatar-image">
                        <i class="anticon anticon-check" style="color:black"></i>
                    </div>
                    <div class="media-body m-l-20">
                        <h6 class="m-b-0">{{ person.email }}</h6>
                        <span class="font-size-13 text-gray text-capitalize">Email</span>
                    </div>
                </div>
                <div class="media m-b-20">
                    <div class="avatar avatar-image">
                        <i class="anticon anticon-check" style="color:black"></i>
                    </div>
                    <div class="media-body m-l-20">
                        <h6 class="m-b-0 text-capitalize">{{ person.phone_no }}</h6>
                        <span class="font-size-13 text-gray text-capitalize">Phone Number</span>
                    </div>
                </div>
                <div class="media m-b-20">
                    <div class="avatar avatar-image">
                        <i class="anticon anticon-check" style="color:black"></i>
                    </div>
                    <div class="media-body m-l-20">
                        <h6 class="m-b-0 text-capitalize">{{ person.mobile_no }}</h6>
                        <span class="font-size-13 text-gray text-capitalize">Mobile Number</span>
                    </div>
                </div>
                <div class="media m-b-20">
                    <div class="avatar avatar-image">
                        <i class="anticon anticon-check" style="color:black"></i>
                    </div>
                    <div class="media-body m-l-20">
                        <h6 class="m-b-0 text-capitalize">{{ person.department }}</h6>
                        <span class="font-size-13 text-gray text-capitalize">Department</span>
                    </div>
                </div>
                <div class="text-right">
                    <button @click="edit(person.id)" class="btn btn-icon btn-hover btn-sm btn-rounded pull-right" v-if="checkUserPermissions('edit_person')">
                        <i class="anticon anticon-edit"></i>
                    </button>
                    <button @click="onDelete(person.id)" class="btn btn-icon btn-hover btn-sm btn-rounded" v-if="checkUserPermissions('delete_person')">
                        <i class="anticon anticon-delete"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Helpers from '@/Mixins/Helpers';
export default {
    props: ['person', 'companyId'],
    methods: {
        edit($id){
            this.$inertia.get(route('dashboard.company.person.edit', [this.companyId, $id]), {
                onSuccess: () => {},
                onError: errors => {console.log(errors);}
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
                    this.$inertia.delete(route('dashboard.company.person.destroy', [this.companyId, $id]), {
                        preserveScroll: false,
                        onSuccess: () => {},
                        onError: errors => {console.log(errors);}
                    })
                }
            })
        }
    },
    mounted() {
        
    },
    mixins: [Helpers]
}
</script>

<style>

</style>
