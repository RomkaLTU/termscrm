<template>
    <div>
        <div class="form-group">
            <label for="pavadinimas">Pavadinimas</label>
            <input type="text" class="form-control" id="pavadinimas" v-model="formData.name" name="name" placeholder="Pavadinimas">
        </div>
        <div class="form-group">
            <label for="rekvizitai">Rekvizitai</label>
            <textarea class="form-control" id="rekvizitai" rows="3" v-model="formData.details" name="details" placeholder="Rekvizitai"></textarea>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'object-fields',
        props: ['object'],

        data() {
            return {
                formData: {
                    name: ( this.object ? this.object.name : null ),
                    details: ( this.object ? this.object.details : null ),
                },
            }
        },
    }
</script>
