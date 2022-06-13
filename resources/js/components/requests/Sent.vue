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
                                                        serviceRequest.id
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
        cancelServiceRequest() {
            let requestServiceForm = new Form({
                service_id: service.id,
            });

            Swal.fire({
                title: "Request a Service!",
                html: `Request <b>${service.product.name}</b> <br>from <b>${service.user.name}</b> <small>(${service.years}Y of experience)</small> <br>for </b>${service.product.price}<i> &#36;</i></b>`,
                showCancelButton: true,
                confirmButtonColor: "#137547",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, Request it!",
            }).then((result) => {
                // Send request to the server
                if (result.value) {
                    requestServiceForm
                        .post("/api/serviceRequest")
                        .then(() => {
                            Swal.fire(
                                "Requested!",
                                "Your request hase been sent.",
                                "success"
                            );
                            // Fire.$emit('AfterCreate');
                            // this.loadServices();
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
