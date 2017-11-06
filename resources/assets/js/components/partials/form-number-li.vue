<template>
    <div class="form-group" v-if="max">
        <label :for="forVal">{{ inputName }}</label>
        <input 
            :value="dataModel" 
            number type="number" 
            :name="forVal" 
            @keyup="updateModel" 
            @blur="updateTotal"
            :class="inputClass" 
            min="0" 
            step="1" 
            :maxlength="max"
            required>
        <p class="alert alert-warning" v-if="dataModel.length == max">{{ max }} character limit reached!</p>
    </div>
    <div class="form-group" v-else>
        <label :for="forVal">{{ inputName }}</label>
        <input 
            v-model="dataModel" 
            number type="number" 
            :name="forVal" 
            @keyup="updateModel" 
            @blur="updateTotal"
            :class="inputClass" 
            min="0" 
            step="1" 
            required>
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
        item: Number, // array index for line item
        set: Number // 0 or 1
        },
        methods: {
            updateModel(e) {
                this.$store.dispatch(
                    'commitMath', 
                    {
                        item: this.item,
                        set: this.set,
                        event: e.target.value
                    }
                );
            },
            updateTotal() {
                this.$store.dispatch('commitTotal');
            }
        }
    }
</script>