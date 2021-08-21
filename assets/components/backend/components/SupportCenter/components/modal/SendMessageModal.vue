<template>
    <StdModal>
        <template v-slot:title>Send {{ $attrs.ticket.customer.name }} a message</template>
        <template v-slot:content>
            asd
        </template>
    </StdModal>

</template>

<script>
import StdModal from "../../../global/page/StdModal";
export default {
    name: "SendMessageModal",
    components: {StdModal}
}
</script>

<style scoped>

</style>