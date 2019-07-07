<template>
    <div>
        <div class="form-group">
            <label>Parametro pavadinimas</label>
            <input type="text" class="form-control" v-model="formData.name" name="name" placeholder="Parametro pavadinimas" required>
        </div>
        <div class="form-group">
            <div class="form-group">
                <label>Tyrimo sritys</label>
                <div class="kt-checkbox-inline mt-2">
                    <div class="research-area-type" v-for="ra in research_areas" :key="`ra_${ra.id}`">
                        <label class="kt-checkbox mb-0">
                            <input type="checkbox" name="research_area[]" v-model="formData.research_area" :value="ra.id"> {{ ra.name }}
                            <span></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'taskparams-fields',
        props: ['task_param','research_areas','research_area','creating'],
        data() {
            return {
                formData: {
                    name: ( this.task_param ? this.task_param.name : null ),
                    research_area: ( this.research_area ? this.research_area : [] ),
                },
            }
        },
        methods: {

        }
    }
</script>
