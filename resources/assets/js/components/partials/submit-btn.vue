<template>
    <div class="form-group margin-top">
        <button v-show="!editMode" type="submit" class="btn btn-primary full-width" name="button">Add {{ name }}</button>
        <button v-show="editMode" type="submit" class="btn btn-primary full-width" name="button">Update {{ name }}</button>
    </div>
</template>
<script>
    export default {
        props: {
            editMode: Boolean,
            name: String
        }
    }
</script>
<style scoped>
    .margin-top {
        margin-top: 20px;
    }
</style>