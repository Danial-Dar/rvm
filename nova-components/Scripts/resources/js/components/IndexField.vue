<template>
    <div >
        <div v-html="field.value"></div>
    </div>
</template>

<script>
export default {
    props: ['resourceName', 'field'],
}
</script>
