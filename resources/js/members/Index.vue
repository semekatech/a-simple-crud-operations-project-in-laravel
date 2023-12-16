<template>
    <div class="container">
        <div class="row mt-2">
            <div class="col-md-4 col-sm-12">
                <search-box @search="filterData"></search-box>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <select
                        @change="getMembers"
                        v-model="age_group" class="form-select" style="width: 100%;">
                        <option value="all">Select age group</option>
                        <option value="youth">0 to 35</option>
                        <option value="adults">Above 35</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <select
                        @change="getMembers"
                        v-model="company" class="form-select" style="width: 100%;">
                        <option value="all">Select Department</option>
                        <option v-for="(item,index) in companies" :value="item.id">{{item.company_name}}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2 d-flex justify-content-end" v-if="actualUser.user_type=='admin'">
                <a
                    href="member/create"
                    class="btn btn-outline-secondary mr-2 font-weight-bold">Add Member
                </a>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12" style="overflow: auto">
                <table class="table" style="border-radius:8px;  -moz-border-radius:6px;">
                    <thead>
                    <tr>
                        <th class="text-center">Membership Number</th>
                        <th class="text-center">Photo</th>
                        <th class=" text-center">Name</th>
                        <th class=" text-center">Contact Number</th>
                        <th class=" text-center">Email Address</th>
                        <th class=" text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr v-if="isLoading" style="background: rgba(255,255,255,0);width: 100%">
                        <td style="width: 100%" colspan="6">
                            <div class="row">
                                <div class="col-12 d-flex justify-content-center align-items-center">
                                    <loader></loader>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr v-else v-for="(member,index) in members" :key="index">
                        <td class="text-center">{{member.membership_number}}</td>
                        <td class="d-flex justify-content-center">
                            <div style="width: 100px;height: 100px">
                                <rounded-image
                                    img-height="90"
                                    img-width="90"
                                    :url="member.image"></rounded-image>
                            </div>
                        </td>
                        <td class="text-center">{{member.name}}</td>
                        <td class="text-center">{{member.mobile_number}}</td>
                        <td class="text-center">{{member.email}}</td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <i
                                    v-if="actualUser.user_type=='admin'"
                                    @click="edit(member.id)"
                                    class="fas fa-pen m-1 text-primary cursor-pointer"></i>
                                <i
                                    @click="view(member.id)"
                                    class="fas fa-eye m-1 text-success cursor-pointer"></i>
                                <i
                                    v-if="actualUser.user_type=='admin'"
                                    @click="showModal(member.id)"
                                    class="fas fa-trash m-1 text-danger cursor-pointer"></i>
                            </div>
                        </td>
                    </tr>

                    </tbody>
                    <tfoot v-if="members.length>0">
                    <tr>
                        <td colspan="7">
                            <div class="row">
                                <div class="col-md-4 col-5 d-flex">
                                    Rows Per Page
                                    <select style="border:0px;outline:0px;margin-left: 15px;background:#fff"
                                            @change="rowsPerPageChanged"
                                            v-model="rows_per_page">
                                        <option v-for="option in options">{{option}}</option>

                                    </select>
                                </div>
                                <div class="col-md-4 col-3 d-flex justify-content-end">
                                </div>
                                <div class="col-md-2 col-2 d-flex justify-content-center">
                                    <div>{{pagination.from}} - {{pagination.to}} of {{pagination.rowsNumber}}</div>
                                </div>
                                <div class="col-md-2 col-2" style="white-space: nowrap">
                                    <div>
                                        <i class="fas fa-angle-double-left cursor-pointer"
                                           @click="firstPage">
                                        </i>
                                        <i style="margin-left: 17px" class="fas fa-angle-left cursor-pointer"
                                           @click="previousPage">
                                        </i>
                                        <i style="margin-left: 5px" class=" fas fa-angle-right cursor-pointer"
                                           @click="nextPage">
                                        </i>
                                        <i style="margin-left: 10px" class=" fas fa-angle-double-right cursor-pointer"
                                           @click="lastPage">
                                        </i>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Member!</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Do you really want to delete this member?</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" @click="deleteMember">
                            <span v-if="isDeleting" class="spinner-border spinner-border-sm" role="status"
                                  aria-hidden="true"></span>
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: "Index",
        props: {
            user: {
                required: true
            }
        },
        data() {
            return {
                search_input: null,
                members: [],
                rows_per_page: 10,
                current_page: 1,
                options: [10, 25, 50, 100, 250, 500],
                filter: '',
                pagination: {
                    sortBy: null,
                    descending: false,
                    page: 1,
                    rowsPerPage: 10,
                    rowsNumber: 10,
                    from: 1,
                    to: 5
                },

                timer: null,
                props: null,
                isLoading: false,
                mobileNumberOrder: false,
                numberOrder: false,
                emailOrder: false,
                nameOrder: false,
                typeOrder: false,
                selected_member_id: null,
                isDeleting: false,
                companies: [],
                company: 'all',
                age_group: 'all',
                actualUser: {}
            }
        },
        methods: {
            deleteMember() {
                this.isDeleting = true;
                axios.delete(`/api/member/${this.selected_member_id}`).then(response => {
                    if (response.status === 200) {
                        this.showModal(null);
                        this.getMembers()
                    }
                }).finally(() => {
                    this.isDeleting = false
                })
            },
            showModal(id) {
                this.selected_member_id = id;
                $('#deleteModal').modal('toggle');
            },
            edit(id) {
                window.location.href = `/member/${id}/edit`
            },
            view(id) {
                window.location.href = `/member/${id}/view`
            },
            filterData(value) {
                this.filter = value;
                clearTimeout(this.timer)
                this.timer = setTimeout(() => {
                    this.getMembers()
                }, 1000)

            },
            previousPage() {
                this.current_page = this.pagination.page;
                if (this.current_page > 1) {
                    this.pagination.page--;
                    this.getMembers()
                }

            },
            nextPage() {
                this.current_page = this.pagination.page;
                if (this.current_page < this.pagination.total_pages) {
                    console.log("Next")
                    this.pagination.page++
                    this.getMembers()
                }
            },
            firstPage() {
                if (this.pagination.page != 1) {
                    this.current_page = 1;
                    this.pagination.page = 1;
                    this.getMembers();
                }

            },
            lastPage() {
                if (this.pagination.page != this.pagination.total_pages) {
                    this.current_page = this.pagination.total_pages;
                    this.pagination.page = this.current_page;
                    this.getMembers();
                }
            },
            rowsPerPageChanged() {
                this.pagination.rowsPerPage = this.rows_per_page;
                this.getMembers()
            },
            getMembers() {
                this.isLoading = true
                const props = this.getProps();
                axios.get('/api/members/index',
                    {
                        params: props
                    }
                ).then(response => {
                    this.members = response.data.data;
                    this.pagination = response.data.pagination;
                }).catch(error => {
                }).finally(() => {
                    this.isLoading = false
                });
            },
            getProps() {
                return {
                    filter: this.filter,
                    pagination: this.pagination,
                    age_group: this.age_group,
                    company: this.company
                }
            },
            getCompanies() {
                axios.get(`/api/companies`).then(response => {
                    this.companies = response.data.companies;
                })
            }
        },
        mounted() {
            this.actualUser = JSON.parse(this.user);
            this.getCompanies();
            this.getMembers(this.getProps())
        }
    }

</script>

<style scoped>
    .cursor-pointer {
        cursor: pointer;
    }

    table th:first-child {
        border-radius: 8px 0 0 8px;
    }

    table th:last-child {
        border-radius: 0 8px 8px 0;
    }

    thead {
        letter-spacing: 0.04em;;
        font-weight: 500;
        font-size: 12px;
        color: #9FA2B4;
        background: #FFFFFF;
        box-shadow: 0px 1px 11px rgba(0, 0, 0, 0.1);
    }

    thead th {
        border: 0 !important;
    }

    tbody:before {
        content: "\200C";
        display: block;
        line-height: 10px;
        text-indent: -99999px;
    }


    tbody tr:first-child td:first-child {
        border-top-left-radius: 8px;
    }

    tbody tr:first-child td:last-child {
        border-top-right-radius: 8px;
    }

    tbody tr:first-child td {
        border: none;
    }

    tbody tr {
        background: #FFFFFF;

        color: #313232;
        font-style: normal;
        font-weight: normal;
        font-size: 13px;
        line-height: 24px;
        letter-spacing: 0.03em;
    }

    tbody tr td {
        border-bottom: 1px solid #DFE0EB;
    }

    tfoot {
        color: #9FA2B4;
        font-size: 14px;
        line-height: 20px;
        letter-spacing: 0.3px;
    }

    tfoot tr:first-child td:last-child {
        border-bottom-left-radius: 8px;
        border-bottom-right-radius: 8px;
        background: #FFFFFF;
        box-shadow: 0px 1px 11px rgba(0, 0, 0, 0.1);
    }


    .custom-checkbox {
        display: none;
    }

    .label-checkbox {
        cursor: pointer;
    }

    .custom-checkbox + .label-checkbox:before {
        width: 12px;
        height: 12px;
        border: 2px solid #DADADA;
        border-radius: 3px;
        box-sizing: border-box;
        background: rgba(255, 255, 255, 0);
        position: relative;
        display: inline-block;
        margin-right: 1ex;
        content: "";
    }

    .custom-checkbox:checked + .label-checkbox:before {
        width: 11px;
        height: 11px;
        outline: #E0283A solid 2px;
        -moz-outline-radius: 3px;
        border: 1px solid rgb(255, 255, 255);
        background-color: #E0283A;
        background-size: 10px;
    }

    .btn-primary {
        height: 38px;
    }

    .btn-outline-secondary {
        height: 38px;
        color: #E0283A;
        border-radius: 8px;
        border-color: #E0283A;
    }

    .btn-outline-secondary:hover {
        height: 38px;
        color: #fff;
        background-color: #E0283A;
        border-radius: 8px;
        border-color: #313232;
    }

    select {
        border-radius: 8px;
        border-color: #e3e3e3;
        height: 40px;
    }
</style>
