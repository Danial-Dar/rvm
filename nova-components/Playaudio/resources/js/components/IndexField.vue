<template>
    <span>
        <audio controls>
            <source :src="'https://rvm.nyc3.digitaloceanspaces.com/RVM/'+field.value" type="audio/wav">
        </audio>
    </span>
</template>

<script>
export default {
    props: ['resourceName', 'field'],
}
</script>
