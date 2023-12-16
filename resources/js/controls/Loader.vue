<template>
    <div class="outer">
        <div class="loader">
        </div>
        <div class="img-box">
            <img
                class="loader-img"
                :src="src"/>
        </div>
    </div>
</template>
<script>
    export default {
        name: "Loader",
        props: {},
        data() {
            return {
                src: "/assets/images/spinner.gif"
            };
        },
        watch: {},
        methods: {},
        mounted() {

        },
        beforeMount() {

        },

    }
</script>
<style scoped>
    .outer {
        position: relative;
    }

    .loader {
        border: 5px solid rgba(255, 255, 255, 0.33);
        border-top: 5px solid #E0283F;
        /* border-left-color: #313232;*/
        border-radius: 50%;
        width: 55px;
        height: 55px;
        -webkit-animation: spin 1s linear infinite;
        animation: spin 1s linear infinite;
    }

    @-webkit-keyframes spin {
        0% {
            -webkit-transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(360deg);
        }
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }

    .img-box {
        position: absolute;
        top: 6.5px;
        left: 6px;
        -webkit-animation: none !important;
        background: #E0283F;
        border-radius: 50%;
    }

    .loader-img {
        width: 43px;
        height: 43px;
        border-radius: 50%;
    }
</style>

