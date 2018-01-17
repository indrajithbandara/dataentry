<template>
    <div>
        <h1 class="text-center">Departments</h1>
        <hr>
        <!-- Error and Success Messages -->
        <ErrorMessage :errorMes="errorMessage"></ErrorMessage>
        <SuccessMessage :successMes="successMessage"></SuccessMessage>
        <!-- Start of Departments Table -->
        <div>
            <div id="departments-table" v-if="list.length > 0" class="table-responsive">
                <table class="table table-condensed">
                    <thead>
                        <tr>
                            <th>Sort</th>
                            <th>Order</th>
                            <th>Name</th>
                            <th>Background Color</th>
                            <th>Text Color</th>
                            <th>View</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <Draggable 
                        v-model="list" 
                        :options="{group:'departments'}" 
                        :element="'tbody'"
                        :move="onMove"
                        @start="onStart" 
                        @end="onEnd"
                        >
                        <tr v-for="dept in list" :key="dept.key" class="cursor-move">
                            <td><i class="fa fa-bars fa-2x" aria-hidden="true"></i></td>
                            <td>{{ dept.key }}</td>
                            <td>{{ dept.dept_name }}</td>
                            <td>{{ dept.dept_bg_color }}</td>
                            <td>{{ dept.dept_txt_color }}</td>
                            <td><button class="btn btn-primary btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></td>
                            <td><button class="btn btn-warning btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</button></td>
                            <td><button class="btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button></td>
                        </tr>
                    </Draggable>
                </table>
            </div>
            <div v-else> 
                <p class="alert alert-info text-center">You currently have no routers to show.</p>
            </div>
        </div>
        <!-- End of Departments table -->
        <!-- Start of Viewing Area -->
        <div v-show="read">
            <transition name="fade">
                <div class="well" :style="read_text">
                    <h2 class="text-center lg-font underline">Mold</h2>
                    <p class="text-center">Sample text to see your color.</p>
                    <button class="btn btn-danger full-width">Close Viewing</button>
                </div>
            </transition>
        </div>
        <!-- End of Viewing Area -->
        <!-- Start Departments Form -->
        <div>
            <h2 class="text-center">Department Details</h2>
            <form action="#" @submit.prevent="">
                <TextForm :forVal="'dept_name'" :inputName="'Department Name'" :inputClass="'form-control'"></TextForm>
                <TextForm :forVal="'dept_bg_color'" :inputName="'Background Color'" :inputClass="'form-control'"></TextForm>
                <TextForm :forVal="'dept_txt_color'" :inputName="'Text Color'" :inputClass="'form-control'"></TextForm>
                <SubmitBtn :editMode="edit" :name="'Router'"></SubmitBtn>
            </form>
        </div>
        <!-- End Departments Form -->
    </div>
</template>
<script>
    import TextForm from '../../components/partials/form-text.vue';
    import ErrorMessage from '../../components/partials/error-message.vue';
    import SuccessMessage from '../../components/partials/success-message.vue';
    import SubmitBtn from '../../components/partials/submit-btn.vue';
    import Draggable from 'vuedraggable';
    export default {
        data(){
            return {
                read: false,
                edit: false,
                table: true,
                list: [
                    { dept_name: 'Wrap', dept_bg_color: '#af366c', dept_txt_color: '#fff', key: 1 },
                    { dept_name: 'Mold', dept_bg_color: '#74875f', dept_txt_color: '#fff', key: 2 },
                    { dept_name: 'Grind', dept_bg_color: '#29a77a', dept_txt_color: '#fff', key: 3 },
                    { dept_name: 'Wash', dept_bg_color: '#006a84', dept_txt_color: '#fff', key: 4 }
                ],
                successMessage: '',
                errorMessage: '',
                read_text: 'background: #af366c; color: #fff;',
            }
        },
        mounted() {

        },
        components: {
            TextForm,
            ErrorMessage,
            SuccessMessage,
            SubmitBtn,
            Draggable
        },
        computed: {

        },
        methods: {
            onMove(evt){
                console.log(evt.draggedContext);
                console.log(evt.relatedContext);
            },
            onStart(){
                console.log("drag started");
            },
            onEnd(){
                console.log("drag ended");
            }
        }
    }
</script>
<style scoped>
    #departments-table { 
        max-height: 565px; 
        overflow: scroll; 
    }
    .cursor-move {
        cursor: move;
    }
</style>