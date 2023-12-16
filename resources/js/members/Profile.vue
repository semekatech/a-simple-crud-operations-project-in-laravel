<template>
    <div class="container">
        <div class="row d-flex justify-content-center ">
            <div class="col-md-8 col-sm-10">
                <div>
                    <span class="h3-heading">Personal Details</span>
                    <div class="container field-container">
                        <div class="row">
                            <div class="col-md-7">
                                <upload-photo @photoChanged="uploadPhoto"
                                              :url="user_image"
                                              label="User Photo"
                                ></upload-photo>
                                <!-- <rounded-image :url="member.image"></rounded-image>-->
                            </div>
                            <div class="col-md-5 d-flex align-items-center">
                                <div class="form-group">
                                    <label class="h4-heading">Membership Number</label>
                                    <div>{{member.membership_number}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="h4-heading">Name</label>
                                    <div>{{member.name}}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="h4-heading">Surname</label>
                                    <div>{{member.father_name}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="h4-heading">Email Address</label>
                                    <div>{{member.email}}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="h4-heading">Phone Number</label>
                                    <div>{{member.mobile_number}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="h4-heading">Gender</label>
                                    <div>{{member.gender}}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="h4-heading">Date of birth</label>
                                    <div>{{member.dob}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="h4-heading">Address</label>
                            <div>{{member.address}}</div>
                        </div>
                    </div>
                </div>
                <div>
                    <span class="h3-heading">Employment History</span>
                    <div class="container field-container">
                        <template v-for="(history,index) in employment_history">
                            <div class="row">
                                <div class="col-12">
                                    <div class="rounded-number d-flex justify-content-center align-items-center">
                                        {{index+1}}
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="h4-heading">Department Name</label>
                                        <div>{{history.company_name}}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="h4-heading">Designation</label>
                                        <div>{{history.designation}}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="h4-heading">Phone number</label>
                                        <div>{{history.phone_number}}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="h4-heading">Date of first appointment</label>
                                        <div>{{history.first_appointment}}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="h4-heading">Present Grade</label>
                                        <div>{{history.present_grade}}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="h4-heading">With effect from</label>
                                        <div>{{history.wef}}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="h4-heading">Membership date to union</label>
                                        <div>{{history.membership_date_to_union}}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="h4-heading">Job Description</label>
                                        <div>{{history.description}}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <hr>
                                </div>
                            </div>
                        </template>
                        <div class="row">
                            <div class="col-6">
                                <span v-if="!employment_history.length">No employment record added</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {onMounted, ref} from 'vue';


    export default {
        name: "Member",
        props: {
            member: {required: false, default: null},
            employmentHistories: {required: false, default: null},
        },
        setup(props) {
            let employment_history = ref(JSON.parse(props.employmentHistories));
            const member = ref(JSON.parse(props.member));
            const user_image = ref(member.value.image);

            const uploadPhoto = (value) => {
                const formDate = new FormData();
                formDate.append('image', value);
                formDate.append('_method', 'patch');
                axios.post(`/api/user/update-photo`, formDate).then(response => {
                    alert('Profile photo has been updated successfully.')
                });
            }
            onMounted(() => {
                console.log('user image ', user_image.value)
            })
            return {
                user_image,
                member,
                uploadPhoto,
                employment_history,
            }
        },

    }
</script>

<style scoped>
    .container {
        margin-bottom: 40px;
    }

    .h3-heading {
        font-size: 20px;
        color: #616161;
        font-weight: bold;
    }

    .h4-heading {
        font-size: 16px;
        color: #616161;
        font-weight: bold;
    }

    .field-container {
        padding-top: 20px;
        background: white;
        border: 1px solid #bfbcbc;
        border-radius: 15px;
        padding-bottom: 10px;

    }

    input[type=text], [type=email] {
        border-radius: 8px;
        border-color: #e3e3e3;
    }

    .rounded-number {
        color: white;
        font-size: 16px;
        font-weight: bold;
        background-color: #080e2d;
        width: 30px;
        height: 30px;
        border-radius: 50%;
    }
</style>
