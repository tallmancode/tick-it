<template>
    <StandardModal>
        <template v-slot:title><span class="text-danger">Something went Kaboom!!</span></template>
        <template v-slot:content>
            <p class="text-center">It appears there is a problem, if it persists call Steve</p>
        </template>
    </StandardModal>
</template>

<script>
import StandardModal from "./StandardModal";
export default {
    name: "ErrorModal",
    components: {StandardModal}
}
</script>
