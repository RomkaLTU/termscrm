<script>
    export default {
        methods: {
            $can(permissionName) {
                return PERMISSIONS.indexOf(permissionName) !== -1;
            },
        },
    };
</script>
