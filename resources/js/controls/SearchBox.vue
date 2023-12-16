<template>
    <div>
        <div class="row">
            <div class="col-12">
                <input
                    @input="$emit('search', search)"
                    type="text"
                    class="form-control"
                    id="form-input"
                    v-model="search"
                    :style="'background:'+ backgroundColor"
                    :placeholder="placeHolder">
                <i class="fas fa-search search-btn"></i>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SearchBox",
        props: {
            placeHolder: {
                required: false,
                default: 'Search'
            }, backgroundColor: {
                required: false,
                default: '#ffffff'
            },
        },
        data() {
            return {
                search: '',
            }
        }
    }
</script>

<style scoped>
    .search-btn {
        float: right;
        margin-right: 15px;
        margin-top: -28px;
        position: relative;
        z-index: 2;
        color: #9FA2B4
    }

    .form-control {
        display: block;
        width: 100%;
        height: 38px;
        padding: .4375rem .875rem;
        font-size: .875rem;
        font-weight: 400;
        line-height: 1.5715;
        color: #313232;
        background-clip: padding-box;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        background: #FFFFFF;
        border: 1px solid #9FA2B4;
        box-sizing: border-box;
        border-radius: 12px;
    }
</style>
