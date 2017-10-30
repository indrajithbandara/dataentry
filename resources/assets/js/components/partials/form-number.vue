<template>
    <div class="form-group" v-if="max">
        <label :for="forVal">{{ inputName }}</label>
        <input 
            v-model="dataModel" 
            number type="number" 
            :name="forVal" 
            @keyup="setInnerModel" 
            @focus="setInnerModel" 
            @blur="updateModel" 
            :row="rows" 
            :class="inputClass" 
            :maxlength="max">
        <p class="alert alert-warning" v-if="model.length == max">{{ max }} character limit reached!</p>
    </div>
    <div class="form-group" v-else>
        <label :for="forVal">{{ inputName }}</label>
        <input 
            v-model="dataModel" 
            number type="number" 
            :name="forVal" 
            @keyup="setInnerModel" 
            @focus="setInnerModel" 
            @blur="updateModel" 
            :row="rows" 
            :class="inputClass">
    </div>
</template>
<script>
    export default {
        props: {
        dataModel: [Number, String],
        forVal: String,
        inputName: String,
        inputClass: String,
        max: Number,
        rows: Number
        },
        data() {
            return {
                model: 0
            }
        },
        methods: {
            updateModel() {
                this.$emit('setModel', this.model);
                this.model = 0;
            },
            setInnerModel() {
                this.model = this.dataModel;
            }
        }
    }
</script>