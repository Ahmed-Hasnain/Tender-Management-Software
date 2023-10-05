<template>
    <div>
        <!-- Modal -->
        <div class="modal fade bd-example-modal-lg" id="exampleModalCenter" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <slot name="header"></slot>
                        <button type="button" class="close" @click="hideModal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <slot name="content" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    methods: {
        showModal() {
            $('#exampleModalCenter').modal('show');
        },
        hideModal() {
            $('#exampleModalCenter').modal('hide');
        }
    },
    mounted(){
        this.emitter.on('open_modal', () => {
            this.showModal()
        })
        this.emitter.on('close_modal', () => {
            this.hideModal()
        })
    }
}
</script>

<style></style>