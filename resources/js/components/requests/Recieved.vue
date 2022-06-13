<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Recieved Requests List</h3>
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
                                        <th>Client</th>
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
                                            {{ serviceRequest.client.name }}
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
                                                title="Accept Request"
                                                href="#"
                                                @click="
                                                    acceptServiceRequest(
                                                        serviceRequest
                                                    )
                                                "
                                            >
                                                <i
                                                    class="fa fa-check green"
                                                ></i>
                                            </a>
                                            /
                                            <a
                                                title="Refuse Request"
                                                href="#"
                                                @click="
                                                    refuseServiceRequest(
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
                                        <th>Client</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Description</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Experience</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="serviceRequest in acceptedServiceRequests.data"
                                        :key="serviceRequest.id"
                                    >
                                        <td>{{ serviceRequest.id }}</td>
                                        <td>
                                            {{ serviceRequest.client.name }}
                                        </td>
                                        <td>
                                            {{ serviceRequest.client.email }}
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
                                        <th>Client</th>
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
                                            {{ serviceRequest.client.name }}
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
                .get("/api/service-request/recieved")
                .then(({ data }) => (this.serviceRequests = data.data));
            this.$Progress.finish();
        },
        loadAcceptedServiceRequests() {
            this.$Progress.start();
            axios
                .get("/api/service-request/recieved/approved")
                .then(({ data }) => (this.acceptedServiceRequests = data.data));
            this.$Progress.finish();
        },
        loadRejectedServiceRequests() {
            this.$Progress.start();
            axios
                .get("/api/service-request/recieved/rejected")
                .then(({ data }) => (this.rejectedServiceRequests = data.data));
            this.$Progress.finish();
        },

        acceptServiceRequest(request) {
            let acceptServiceRequestForm = new Form({
                request_id: request.id,
                pending: false,
                accepted: true,
            });

            Swal.fire({
                title: "Accept Request!",
                html: `Accept Request for Service <br><b>${request.service.product.name}</b> from <b>${request.client.name}</b> <br>for <b>${request.service.product.price}<i>&#36;</i></b>`,
                showCancelButton: true,
                confirmButtonColor: "#137547",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, Accept it!",
            }).then((result) => {
                // Send request to the server
                if (result.value) {
                    acceptServiceRequestForm
                        .put(
                            `/api/serviceRequest/${acceptServiceRequestForm.request_id}`
                        )
                        .then(() => {
                            Swal.fire(
                                "Accepted!",
                                `Contact client at <b>${request.client.email}</b>`,
                                "success"
                            );
                            this.loadServiceRequests();
                            this.loadAcceptedServiceRequests();
                        })
                        .catch((data) => {
                            Swal.fire("Failed!", 'Something went wrong!<br> Try again later.', "warning");
                            this.loadServiceRequests();
                        });
                }
            });
        },
        refuseServiceRequest(request) {
            let acceptServiceRequestForm = new Form({
                request_id: request.id,
                pending: false,
                accepted: false,
            });

            Swal.fire({
                title: "Refuse Request!",
                html: `Refuse Request for Service <br><b>${request.service.product.name}</b> from <b>${request.client.name}</b> <br>for <b>${request.service.product.price}<i>&#36;</i></b>`,
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, Refuse it!",
            }).then((result) => {
                // Send request to the server
                if (result.value) {
                    acceptServiceRequestForm
                        .put(
                            `/api/serviceRequest/${acceptServiceRequestForm.request_id}`
                        )
                        .then(() => {
                            Swal.fire(
                                "Refused!",
                                `Request refused successfully`,
                                "success"
                            );
                            this.loadServiceRequests();
                            this.loadRejectedServiceRequests();
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
