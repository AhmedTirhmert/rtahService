<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Sent Requests List</h3>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Pending</h3>

                            <div class="card-tools">
                                <button
                                    type="button"
                                    class="btn btn-sm btn-primary"
                                    @click="loadServiceRequests"
                                >
                                    <i class="fa fa-sync"></i>
                                    Refresh
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Founisseur</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Experience</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="serviceRequest in serviceRequests.data"
                                        :key="serviceRequest.id"
                                    >
                                        <td>{{ serviceRequest.id }}</td>
                                        <td>
                                            {{
                                                serviceRequest.service.user.name
                                            }}
                                        </td>
                                        <td>
                                            {{
                                                serviceRequest.service.product
                                                    .name
                                            }}
                                        </td>
                                        <td>
                                            {{
                                                serviceRequest.service.product
                                                    .description
                                                    | truncate(30, "...")
                                            }}
                                        </td>
                                        <td>
                                            {{
                                                serviceRequest.service.product
                                                    .category.name
                                            }}
                                        </td>
                                        <td>
                                            {{
                                                serviceRequest.service.product
                                                    .price
                                            }}
                                        </td>
                                        <td>
                                            {{ serviceRequest.service.years }}
                                        </td>
                                        <td>
                                            <a
                                                title="Cancel Request"
                                                href="#"
                                                @click="
                                                    cancelServiceRequest(
                                                        serviceRequest
                                                    )
                                                "
                                            >
                                                <i class="fas fa-times red"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <pagination
                                :data="serviceRequests"
                                @pagination-change-page="getResults"
                            ></pagination>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Accepted</h3>

                            <div class="card-tools">
                                <button
                                    type="button"
                                    class="btn btn-sm btn-primary"
                                    @click="loadAcceptedServiceRequests"
                                >
                                    <i class="fa fa-sync"></i>
                                    Refresh
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Founisseur</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Description</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Experience</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="serviceRequest in acceptedServiceRequests.data"
                                        :key="serviceRequest.id"
                                    >
                                        <td>{{ serviceRequest.id }}</td>
                                        <td>
                                            {{
                                                serviceRequest.service.user.name
                                            }}
                                        </td>
                                        <td>
                                            {{
                                                serviceRequest.service.user
                                                    .email
                                            }}
                                        </td>
                                        <td>
                                            {{
                                                serviceRequest.service.product
                                                    .name
                                            }}
                                        </td>
                                        <td>
                                            {{
                                                serviceRequest.service.product
                                                    .description
                                                    | truncate(30, "...")
                                            }}
                                        </td>
                                        <td>
                                            {{
                                                serviceRequest.service.product
                                                    .category.name
                                            }}
                                        </td>
                                        <td>
                                            {{
                                                serviceRequest.service.product
                                                    .price
                                            }}
                                        </td>
                                        <td>
                                            {{ serviceRequest.service.years }}
                                        </td>
                                        <td>
                                            <a
                                                title="Give Feedback"
                                                href="#"
                                                @click="
                                                    giveFeedback(serviceRequest)
                                                "
                                            >
                                                <i
                                                    class="fas fa-comment-dots blue"
                                                ></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <pagination
                                :data="serviceRequests"
                                @pagination-change-page="getResults"
                            ></pagination>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Rejected</h3>

                            <div class="card-tools">
                                <button
                                    type="button"
                                    class="btn btn-sm btn-primary"
                                    @click="loadRejectedServiceRequests"
                                >
                                    <i class="fa fa-sync"></i>
                                    Refresh
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Founisseur</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Experience</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="serviceRequest in rejectedServiceRequests.data"
                                        :key="serviceRequest.id"
                                    >
                                        <td>{{ serviceRequest.id }}</td>
                                        <td>
                                            {{
                                                serviceRequest.service.user.name
                                            }}
                                        </td>
                                        <td>
                                            {{
                                                serviceRequest.service.product
                                                    .name
                                            }}
                                        </td>
                                        <td>
                                            {{
                                                serviceRequest.service.product
                                                    .description
                                                    | truncate(30, "...")
                                            }}
                                        </td>
                                        <td>
                                            {{
                                                serviceRequest.service.product
                                                    .category.name
                                            }}
                                        </td>
                                        <td>
                                            {{
                                                serviceRequest.service.product
                                                    .price
                                            }}
                                        </td>
                                        <td>
                                            {{ serviceRequest.service.years }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <pagination
                                :data="serviceRequests"
                                @pagination-change-page="getResults"
                            ></pagination>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- MODAL -->
                <div
                    class="modal fade"
                    id="feedbackModal"
                    tabindex="-1"
                    role="dialog"
                    aria-labelledby="feedBackModal"
                    aria-hidden="true"
                >
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Feedback & Rating</h5>
                                <button
                                    type="button"
                                    class="close"
                                    data-dismiss="modal"
                                    aria-label="Close"
                                >
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <form @submit.prevent="submitFeedback()">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Service</label>
                                                <input
                                                    readonly
                                                    v-model="
                                                        feedBackForm.service
                                                            .product.name
                                                    "
                                                    type="text"
                                                    class="form-control"
                                                />
                                            </div>
                                            <div class="form-group">
                                                <label>Fournisseur</label>
                                                <input
                                                    readonly
                                                    v-model="
                                                        feedBackForm.service
                                                            .user.name
                                                    "
                                                    type="text"
                                                    class="form-control"
                                                />
                                            </div>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input
                                                    readonly
                                                    v-model="
                                                        feedBackForm.service
                                                            .user.email
                                                    "
                                                    type="text"
                                                    class="form-control"
                                                />
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Price</label>
                                                <input
                                                    readonly
                                                    v-model="
                                                        feedBackForm.service
                                                            .product.price
                                                    "
                                                    type="text"
                                                    class="form-control"
                                                />
                                            </div>
                                            <div class="form-group">
                                                <label>Experience</label>
                                                <input
                                                    readonly
                                                    v-model="
                                                        feedBackForm.service
                                                            .years
                                                    "
                                                    type="text"
                                                    class="form-control"
                                                />
                                            </div>

                                            <div class="form-group">
                                                <label
                                                    >Rating
                                                    <small>
                                                        <i>(0 to 5)</i></small
                                                    ></label
                                                >
                                                <input
                                                    required
                                                    v-model="
                                                        feedBackForm.rating
                                                    "
                                                    type="number"
                                                    class="form-control"
                                                    min="0"
                                                    max="5"
                                                    step="0.5"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label>FeedBack message</label>
                                            <textarea
                                                v-model="feedBackForm.message"
                                                type="text"
                                                class="form-control"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button
                                        type="button"
                                        class="btn btn-secondary"
                                        data-dismiss="modal"
                                    >
                                        Close
                                    </button>
                                    <button
                                        type="submit"
                                        class="btn btn-success"
                                    >
                                        Submit Feedback
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    components: {},
    data() {
        return {
            serviceRequests: {},
            acceptedServiceRequests: {},
            rejectedServiceRequests: {},
            feedBackForm: new Form({
                service_id: "",
                service: {
                    user: {
                        name: "",
                        email: "",
                    },
                    product: {
                        name: "",
                        price: "",
                    },
                    years: "",
                },
                rating: "",
                message: "",
                id: "",
            }),
        };
    },
    methods: {
        getResults(page = 1) {
            this.$Progress.start();

            axios
                .get("api/serviceRequest?page=" + page)
                .then(({ data }) => (this.serviceRequests = data.data));

            this.$Progress.finish();
        },
        loadServiceRequests() {
            this.$Progress.start();
            axios
                .get("/api/service-request/sent")
                .then(({ data }) => (this.serviceRequests = data.data));
            this.$Progress.finish();
        },
        loadAcceptedServiceRequests() {
            this.$Progress.start();
            axios
                .get("/api/service-request/sent/approved")
                .then(({ data }) => (this.acceptedServiceRequests = data.data));
            this.$Progress.finish();
        },
        loadRejectedServiceRequests() {
            this.$Progress.start();
            axios
                .get("/api/service-request/sent/rejected")
                .then(({ data }) => (this.rejectedServiceRequests = data.data));
            this.$Progress.finish();
        },
        giveFeedback(request) {
            this.feedBackForm.fill(request);
            console.log(this.feedBackForm);
            $("#feedbackModal").modal("show");
        },
        submitFeedback() {
            console.log(this.feedBackForm);
            this.feedBackForm
                .post(`/api/feedback`)
                .then(() => {
                    Swal.fire(
                        "FeedBack Sent!",
                        `FeedBack sent successfully`,
                        "success"
                    );
                    $("#feedbackModal").modal("hide");
                    this.loadServiceRequests();
                })
                .catch((error) => {
                    Swal.fire(
                        "Failed!",
                        error.response.data.message,
                        "warning"
                    );
                });
        },
        cancelServiceRequest(request) {
            this.feedBackForm.fill(request);
            Swal.fire({
                title: "Cancel Request!",
                html: `Cancel Request for Service <br><b>${request.service.product.name}</b> from <b>${request.client.name}</b> <br>for <b>${request.service.product.price}<i>&#36;</i></b>`,
                showCancelButton: true,
                confirmButtonColor: "#e85d04",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, Cancel it!",
            }).then((result) => {
                if (result.value) {
                    this.feedBackForm
                        .delete(
                            `/api/serviceRequest/${this.feedBackForm.id}`
                        )
                        .then(() => {
                            Swal.fire(
                                "Canceled!",
                                `Request canceled successfully`,
                                "success"
                            );
                            this.loadServiceRequests();
                        })
                        .catch((data) => {
                            Swal.fire("Failed!", data.message, "warning");
                        });
                }
            });
        },
    },
    mounted() {},
    created() {
        this.$Progress.start();

        this.loadServiceRequests();
        this.loadAcceptedServiceRequests();
        this.loadRejectedServiceRequests();

        this.$Progress.finish();
    },
    filters: {
        truncate: function (text, length, suffix) {
            return text.substring(0, length) + suffix;
        },
    },
    computed: {
        filteredItems() {
            return this.autocompleteItems.filter((i) => {
                return (
                    i.text.toLowerCase().indexOf(this.tag.toLowerCase()) !== -1
                );
            });
        },
    },
};
</script>
