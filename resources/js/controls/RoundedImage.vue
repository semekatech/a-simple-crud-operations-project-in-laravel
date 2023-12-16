<template>
    <div
        class="rounded-border"
        :style="'width:'+imgWidth+'px;height:'+imgHeight+'px;background-image:url('+imageUrl+');'">
    </div>

</template>

<script>
    export default {
        name: "RoundedImage",
        props: {
            url: {
                required: true,
            },
            imgWidth: {
                required: false,
                default: 150
            },
            imgHeight: {
                required: false,
                default: 150
            },
            alt: {
                required: false,
                default: ''
            },
            borderColor: {
                required: false,
                default: '#ccc'
            },
            borderThickness: {
                required: false,
                default: '3px'
            }
        },
        watch: {
            url(newVal, oldVal) {
                this.imageUrl = null;
                if (newVal == null) {
                    this.imageUrl = this.placeHolderImg
                } else {
                    this.imageUrl = newVal;

                }
            }
        },
        data() {
            return {
                imageUrl: null,
                placeHolderImg: "/images/goozam_icon_red_hand.png"
            }
        },
        methods: {
            changeSrc() {
                //	console.log("RoundedImage: Error Occur ");
                this.imageUrl = this.placeHolderImg
            }
        },
        beforeMount() {
            //	console.log("Image Url " + this.url)
            this.imageUrl = this.url != null ? this.url : this.placeHolderImg
        }
    }
</script>

<style scoped>
    .rounded-border {
        border-radius: 50%;
        border: 1px solid #ff8282;
        background: #E5E5E5 no-repeat center center;
        background-size: cover;
    }
</style>
