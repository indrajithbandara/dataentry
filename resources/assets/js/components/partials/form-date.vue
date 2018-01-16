<template>
    <div class="form-group">
        <label for="date">{{ inputName }}</label>
        <input :value="dataModel" @blur="updateModel" type="date" name="date" class="form-control" required>
    </div>
</template>
<script>
    export default {
        props: {
            forVal: String,
            inputName: String,
            inputClass: String,
            dataModel: String,
        },
        methods: {
            updateModel(e) {
                // this.$store.commit(
                //     'updateProduct', 
                //     {
                //         item: this.item, 
                //         event: e.target.value
                //     }
                // );
            }
        }
    }
</script>