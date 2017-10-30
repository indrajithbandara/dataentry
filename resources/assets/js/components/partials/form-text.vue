<template>
    <div class="form-group" v-if="max">
        <label :for="forVal">{{ inputName }}</label>
        <input 
            v-model="dataModel" 
            type="text" 
            :name="forVal" 
            @keyup="setInnerModel" 
            @focus="setInnerModel" 
            @blur="updateModel" 
            :class="inputClass" 
            :maxlength="max">
        <p class="alert alert-warning" v-if="model.length == max">{{ max }} character limit reached!</p>
    </div>
    <div class="form-group" v-else>
        <label :for="forVal">{{ inputName }}</label>
        <input 
            v-model="dataModel" 
            type="text" 
            :name="forVal" 
            @keyup="setInnerModel" 
            @focus="setInnerModel" 
            @blur="updateModel" 
            :class="inputClass">
    </div>
</template>
<script>
    export default {
        props: {
        dataModel: String,
        forVal: String,
        inputName: String,
        inputClass: String,
        max: Number
        },
        data() {
            return {
                model: ''
            }
        },
        methods: {
            updateModel() {
                this.$emit('setModel', this.model);
                this.model = '';
            },
            setInnerModel() {
                this.model = this.dataModel;
            }
        }
    }
</script>