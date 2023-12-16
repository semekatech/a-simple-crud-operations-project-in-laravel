<template>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-md-8 col-sm-10">
                <div>
                    <span class="h3-heading">Personal Details</span>
                    <div class="container field-container">
                        <div class="row">
                            <div class="col-12">
                                <upload-photo @photoChanged="getPhoto"
                                              :url="user_image"
                                              label="User Photo"
                                ></upload-photo>
                                <small id="image_error" class="form-text text-danger" style="margin-top: -30px;">{{image_error}}</small>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input
                                        v-model="name"
                                        type="text" class="form-control"
                                        placeholder="Enter name">
                                    <small id="name_error" class="form-text text-danger">{{name_error}}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Surname</label>
                                    <input v-model="father_name" type="text" class="form-control"
                                           placeholder="Enter Surname">
                                    <small id="father_name_error"
                                           class="form-text text-danger">{{father_name_error}}</small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email address</label>
                                    <input v-model="email" type="email" class="form-control"
                                           placeholder="Enter email">
                                    <small id="email_error" class="form-text text-danger">{{email_error}}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Phone number</label>
                                    <input v-model="mobile_number" type="text" class="form-control"
                                           placeholder="Enter phone number">
                                    <small id="mobile_number_error" class="form-text text-danger">{{mobile_number_error}}</small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Address</label>
                                    <input v-model="address" type="text" class="form-control"
                                           placeholder="Enter address">
                                    <small id="address_error" class="form-text text-danger">{{address_error}}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Gender</label><br/>
                                    <select v-model="gender" class="form-select" style="width: 100%;"
                                            aria-label="Default select example">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Date of birth</label>
                                    <Datepicker
                                        :enable-time-picker="false"
                                        v-model="dob"></Datepicker>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input v-model="password" type="password" class="form-control"
                                           placeholder="Enter password">
                                    <small id="password_error" class="form-text text-danger">{{password_error}}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <span class="h3-heading">Employment History</span>
                    <div class="container field-container">
                        <template v-for="(history,index) in employment_history">
                            <div class="row">
                                <div class="col-12 d-flex justify-content-end">
                                    <button
                                        @click="showModal(index)"
                                        class="btn btn-sm btn-danger ">Remove
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Department Name</label>
                                        <input
                                            v-model="history.company_name"
                                            type="text" class="form-control"
                                            placeholder="Enter department name">
                                        <small class="form-text text-danger" :id="'company_name_error_'+index"></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Designation</label>
                                        <input
                                            v-model="history.designation"
                                            type="text" class="form-control"
                                            placeholder="Enter designation">
                                        <small class="form-text text-danger" :id="'designation_error_'+index"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone number</label>
                                        <input
                                            v-model="history.phone_number"
                                            type="text" class="form-control"
                                            placeholder="Enter department phone number">
                                        <small class="form-text text-danger" :id="'phone_number_error_'+index"></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Date of first appointment</label><br/>
                                        <select v-model="history.first_appointment" class="form-select"
                                                style="width: 100%;"
                                                aria-label="Default select example">
                                            <option value="contract">Contract</option>
                                            <option value="permanent">Permanent</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Present Grade</label>
                                        <input
                                            v-model="history.present_grade"
                                            type="text" class="form-control"
                                            placeholder="Enter present grade">
                                        <small class="form-text text-danger" :id="'present_grade_error_'+index"></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>With effect from</label>
                                        <Datepicker
                                            :enable-time-picker="false"
                                            v-model="history.wef"></Datepicker>
                                        <small class="form-text text-danger" :id="'wef_error_'+index"></small>
                                        <!-- <input v-model="history.is_working" type="checkbox" :id="'working_'+index"
                                                name="vehicle1" value="Bike">
                                         <label :for="'working_'+index" class="ml-2">Currently work here</label><br>
 -->                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Membership date to union</label>
                                        <Datepicker
                                            :enable-time-picker="false"
                                            v-model="history.membership_date_to_union"></Datepicker>
                                        <small class="form-text text-danger"
                                               :id="'membership_date_to_union_error_'+index"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Job Description</label>
                                        <textarea v-model="history.description"
                                                  class="form-control"
                                                  rows="4"></textarea>
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
                            <div class="col-6 d-flex justify-content-end">
                                <button class="btn btn-sm btn-outline-primary" @click="addEmployment"
                                        v-if="employment_history.length===0">Add Employment
                                    Record
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="btn btn-success"
                        @click="save"><span v-if="isLoading" class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span>Save
                </button>
            </div>
        </div>
        <div class="modal fade" id="removeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Remove!</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Do you really want to remove this employment record?</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" @click="removeDepartmentRecord">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {onMounted, ref} from 'vue';
    import moment from 'moment';


    export default {
        name: "Member",
        props: {
            member: {required: false, default: null},
            employmentHistories: {required: false, default: null},
        },
        setup(props) {
            const image_removed = ref(true)
            const user_image = ref(null)
            const name = ref(null);
            const password = ref(null);
            const name_error = ref(null);
            const email = ref(null);
            const email_error = ref(null);
            const father_name = ref(null);
            const gender = ref('male');
            const dob = ref(null);

            const father_name_error = ref(null);
            const mobile_number = ref(null);
            const mobile_number_error = ref(null);
            const address = ref(null);
            const address_error = ref(null);
            const image_error = ref(null);
            const password_error = ref(null);

            const isLoading = ref(false);

            let employment_history = ref([]);

            const selected_employment = ref(null);

            const member = JSON.parse(props.member);

            const getPhoto = (value) => {
                if (value == null) {
                    image_removed.value = true
                } else {
                    image_removed.value = false
                }
                user_image.value = value;
            }
            const addEmployment = () => {
                employment_history.value.push({
                    company_name: '',
                    phone_number: '',
                    designation: '',
                    membership_date_to_union: new Date(),
                    wef: new Date(),
                    description: '',
                    is_working: false,
                    first_appointment: 'contract',
                    present_grade: null
                })
            }
            const isValidated = () => {
                let validated = true;
                if (name.value == null || name.value == '') {
                    name_error.value = 'Name field is required';
                    scrollTo(`#name_error`);
                    validated = false;
                }
                if (father_name.value == null || father_name.value == '') {
                    father_name_error.value = 'Surname field is required';
                    validated = false;
                    scrollTo(`#father_name_error`);
                }
                if (mobile_number.value == null || mobile_number.value == '') {
                    mobile_number_error.value = 'Mobile number field is required';
                    validated = false;
                    scrollTo(`#mobile_number_error`);

                }
                if (member == null) {
                    if (password.value == null || password.value == '') {
                        password_error.value = 'Password field is required';
                        validated = false;
                        scrollTo(`#password_error`);

                    }
                }
                if (email.value == null || email.value == '') {
                    email_error.value = 'Email field is required';
                    validated = false;
                    scrollTo(`#email_error`);
                }
                if (!validateEmail(email.value)) {
                    email_error.value = 'Invalid email address';
                    validated = false;
                    scrollTo(`#email_error`);
                }
                if (address.value == null || address.value == '') {
                    address_error.value = 'Address field is required.';
                    scrollTo(`#address_error`);
                    validated = false;
                }
                if (user_image.value == null || user_image.value == '') {
                    image_error.value = 'Kindly upload an image';
                    scrollTo(`#image_error`);
                    validated = false;
                }
                let histories = employment_history.value;
                if (histories.length) {
                    for (let i = 0; i < histories.length; i++) {
                        const history = histories[i];
                        if (history.company_name == null || history.company_name == '') {
                            $(`#company_name_error_${i}`).html('Department name field is required');
                            scrollTo(`#company_name_error_${i}`);
                            validated = false;
                        }
                        if (history.designation == null || history.designation == '') {
                            $(`#designation_error_${i}`).html('Designation field is required');
                            scrollTo(`#designation_error_${i}`)
                            validated = false;
                        }
                        if (history.membership_date_to_union == null || history.membership_date_to_union == '') {
                            $(`#membership_date_to_union_error_${i}`).html('Membership date to union field is required');
                            scrollTo(`#membership_date_to_union_error_${i}`)
                            validated = false;
                        }
                        if (!history.is_working) {
                            if (history.wef == null || history.wef == '') {
                                $(`#wef_error_${i}`).html('wef field is required');
                                validated = false;
                                scrollTo(`#wef_error_${i}`)
                            }
                        }
                    }
                }
                return validated;
            }
            const scrollTo = (element_id) => {
                $([document.documentElement, document.body]).animate({
                    scrollTop: $(element_id).offset().top
                }, 500);
            }
            const validateEmail = (email) => {
                return String(email)
                    .toLowerCase()
                    .match(
                        /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                    );
            }
            const resetErrors = () => {
                email_error.value = null;
                name_error.value = null;
                mobile_number_error.value = null;
                father_name_error.value = null;
                address_error.value = null;
                image_error.value = null;
                password_error.value = null;
            }
            const save = () => {
                if (!isValidated()) {
                    return;
                }
                resetErrors();
                isLoading.value = true;
                employment_history.value = employment_history.value.map((item) => {
                    return {
                        id: item.id,
                        company_name: item.company_name,
                        phone_number: item.phone_number,
                        designation: item.designation,
                        description: item.description,
                        is_working: item.is_working,
                        membership_date_to_union: moment(item.membership_date_to_union).format('YYYY-MM-DD'),
                        wef: moment(item.wef).format('YYYY-MM-DD'),
                        first_appointment: item.first_appointment,
                        present_grade: item.present_grade
                    }
                })
                const formData = new FormData();
                formData.append('name', name.value);
                formData.append('email', email.value);
                formData.append('gender', gender.value);
                formData.append('father_name', father_name.value);
                formData.append('mobile_number', mobile_number.value);
                formData.append('address', father_name.value);
                formData.append('password', password.value);
                formData.append('dob', moment(dob.value).format('YYYY-MM-DD'));
                formData.append('employment_history', JSON.stringify(employment_history.value));
                let url = `/api/member`;
                if (props.member == null) {
                    formData.append('image', user_image.value);
                } else {
                    url = `/api/member/${member.id}`
                    formData.append('user_id', member.id);
                    formData.append('_method', 'put');
                    if ((typeof user_image.value) != 'string') {
                        formData.append('image', user_image.value);
                    }
                }
                axios.post(url, formData).then(response => {
                    if (response.status == 200) {
                        window.location.href = '/'
                    }
                }).catch(error => {
                    if (error.response.status == 422) {
                        email_error.value = error.response.data.message;
                        scrollTo('#name_error');
                    }
                }).finally(() => {
                    isLoading.value = false;
                })
            }

            const showModal = (index) => {
                selected_employment.value = index;
                $('#removeModal').modal('toggle')
            }
            const removeDepartmentRecord = () => {
                employment_history.value.splice(selected_employment.value, 1)
                $('#removeModal').modal('toggle')
            }

            onMounted(() => {
                if (member != null) {
                    console.log('history ', props.employmentHistories)
                    user_image.value = member.image;
                    name.value = member.name;
                    email.value = member.email;
                    mobile_number.value = member.mobile_number;
                    father_name.value = member.father_name;
                    address.value = member.address;
                    employment_history.value = JSON.parse(props.employmentHistories);
                    dob.value = member.dob;
                }
            })
            return {
                gender,
                getPhoto,
                name,
                email,
                mobile_number,
                father_name,
                address,
                user_image,
                isLoading,
                password,
                name_error,
                email_error,
                mobile_number_error,
                father_name_error,
                address_error,
                image_error,
                password_error,
                employment_history,
                dob,
                addEmployment,
                removeDepartmentRecord,
                save,
                showModal
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

    .field-container {
        padding-top: 20px;
        background: white;
        border: 1px solid #bfbcbc;
        border-radius: 15px;
        padding-bottom: 10px;

    }

    input[type=text], [type=email], [type=password] {
        border-radius: 8px;
        border-color: #e3e3e3;
    }

    select {
        border-radius: 8px;
        border-color: #e3e3e3;
        height: 40px;
    }
</style>
