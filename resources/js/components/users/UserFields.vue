<template>
    <div>
        <div class="form-group">
            <label>Vardas, Pavardė</label>
            <input type="text" class="form-control" v-model="formData.name" name="name" placeholder="Vardas, Pavardė">
        </div>
        <div class="form-group">
            <label>Tel. nr.</label>
            <input type="text" class="form-control" v-model="formData.phone" name="phone" placeholder="Tel. nr.">
        </div>
        <div class="form-group">
            <label>El. pašto adresas</label>
            <input type="email" class="form-control" v-model="formData.email" name="email" placeholder="El. pašto adresas">
        </div>
        <div v-if="$can('manage_users')" class="form-group">
            <label>Rolė</label>
            <select
                v-model="formData.role"
                class="form-control"
                name="role"
                required>
                <option
                    v-for="(role,index) in roles"
                    :key="`role_${index}`"
                    :value="role.id">{{ role.name }}</option>
            </select>
        </div>
        <div class="form-group">
            <label>Pareigos</label>
            <input v-if="$can('manage_users')" type="text" class="form-control" name="duties" v-model="formData.duties" placeholder="Pareigos">
            <input v-else type="text" class="form-control" v-model="formData.duties" disabled>
        </div>
        <div class="form-group">
            <label>Slaptažodis</label>
            <input type="password" class="form-control" name="password" placeholder="Naujas slaptažodis">
        </div>
    </div>
</template>

<script>
    export default {
        name: 'user-fields',
        props: ['roles','user','user_role','is_admin','editing_user_role'],
        data() {
            return {
                formData: {
                    role: ( this.editing_user_role ? this.editing_user_role[0].id : null ),
                    name: ( this.user ? this.user.name : null ),
                    email: ( this.user ? this.user.email : null ),
                    phone: ( this.user ? this.user.phone : null ),
                    duties: ( this.user ? this.user.duties : null ),
                },
            }
        },
    }
</script>
