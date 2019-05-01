<template>
    <label class="kt-checkbox">
        <input type="checkbox" name="tasks[]" @change="toggleCheck"
               :checked="false"
               :value="task_id"> &nbsp;
        <span></span>
    </label>
</template>

<script>
    export default {
        name: 'task-check-done',
        props: ['task_id'],
        methods: {
            toggleCheck(value){
                this.$store.dispatch('tasks/setMarketDone', {
                    state: value.target.checked,
                    value: value.target.value,
                });
            },
        },
    }
</script>
