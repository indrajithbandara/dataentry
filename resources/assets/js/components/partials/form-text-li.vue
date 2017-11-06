<template>
    <div class="form-group" v-if="max">
        <label :for="forVal">{{ inputName }}</label>
        <input 
            :value="dataModel" 
            type="text" 
            :name="forVal" 
            @keyup="updateModel" 
            :class="inputClass" 
            :maxlength="max"
            required>
        <p class="alert alert-warning" v-if="dataModel.length == max">{{ max }} character limit reached!</p>
    </div>
    <div class="form-group" v-else>
        <label :for="forVal">{{ inputName }}</label>
        <input 
            :value="dataModel" 
            type="text" 
            :name="forVal" 
            @keyup="updateModel" 
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
            max: Number,
            item: Number
        },
        methods: {
            updateModel(e) {
                this.$store.commit(
                    'updateLineItem', 
                    {
                        item: this.item, 
                        event: e.target.value
                    }
                );
            }
        }
    }
</script>