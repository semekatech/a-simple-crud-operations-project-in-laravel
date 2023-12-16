<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="h5-heading">
                    {{label}}
                </div>
            </div>
        </div>
        <div class="d-flex">
            <div class=" d-flex justify-content-center">
                <div class="image-box-circle d-flex justify-content-center align-items-center "
                     :style="'background-image:url('+imageUrl+')' ">
                    <div v-if="imageUrl===null" class="small-image-icon"></div>
                </div>
            </div>
            <div
                class="mt-2 ml-3 d-flex justify-content-md-center justify-content-end align-items-center">
                <button
                    class="btn btn-primary btn-sm"
                    @click="$refs.inputFile.click()"
                >
                    Choose Photo
                </button>
                <input type="file" style="display: none"
                       ref="inputFile"
                       @change="onFileChange($event)"
                       accept="image/*">
            </div>
            <div
                class="d-flex justify-content-md-start  align-items-center mt-2 mt-md-0 ml-3"
                style="margin-left: -10px;cursor: pointer">
                <div class="delete-btn d-flex justify-content-center align-items-center "
                     @click="removePhoto">
                    <i class="fas fa-trash"></i>
                </div>
            </div>

            <img :src="imageUrl" style="display: none" @error="changeSrc"/>
        </div>
    </div>
</template>

<script>
    export default {
        name: "UploadPhoto",
        props: {
            url: {
                required: false,
                default: null
            },
            label: {
                required: false,
                default: 'Logo'
            }
        },
        watch: {
            url(newVal, oldVal) {
                console.log(typeof newVal)
                if ((typeof newVal) == 'string') {
                    console.log('image url watcher ', newVal)
                    this.imageUrl = newVal
                }

            }
        },
        data() {
            return {
                imageUrl: null
            }
        },
        methods: {
            onFileChange(e) {
                try {
                    const file = e.target.files[0];
                    this.imageUrl = URL.createObjectURL(file);
                    this.$emit('photoChanged', file)
                } catch (error) {
                    console.log(error.message)
                }
            },
            changeSrc() {
                this.imageUrl = "/assets/images/image_logo.png"
            },
            removePhoto() {
                this.imageUrl = null;
                this.$emit('photoChanged', null)
            }
        },
        mounted() {
            console.log('Url ' + this.url)
            this.imageUrl = this.url;
        }
    }
</script>

<style scoped>
    .image-box-circle {
        height: 140px;
        width: 140px;
        border-radius: 50%;
        background: #E5E5E5 no-repeat center center;
        background-size: contain;
    }
</style>
