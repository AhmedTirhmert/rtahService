<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Service List</h3>

                            <div class="card-tools">
                                <button
                                    type="button"
                                    class="btn btn-sm btn-primary"
                                    @click="loadServices"
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
                                        <th>User</th>
                                        <th v-show="$gate.isAdmin()">Email</th>
                                        <th>Product</th>
                                        <th>Description</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Experience</th>
                                        <th v-show="$gate.isAdmin()">
                                            Requests
                                        </th>
                                        <th>Average Rating</th>
                                        <th v-show="$gate.isAdmin()">
                                            Feedbacks
                                        </th>
                                        <th v-show="$gate.isAdmin()">
                                            Complains
                                        </th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="service in services.data"
                                        :key="service.id"
                                    >
                                        <td>{{ service.user.name }}</td>
                                        <td v-show="$gate.isAdmin()">
                                            {{ service.user.email }}
                                        </td>
                                        <td>{{ service.product.name }}</td>
                                        <td>
                                            {{
                                                service.product.description
                                                    | truncate(30, "...")
                                            }}
                                        </td>
                                        <td>
                                            {{ service.product.category.name }}
                                        </td>
                                        <td>{{ service.product.price }}</td>
                                        <td>{{ service.years }}</td>
                                        <td v-show="$gate.isAdmin()">
                                            {{ service.request.length }}
                                        </td>
                                        <td>
                                            <star-rating
                                                :star-size="20"
                                                read-only
                                                :show-rating="false"
                                                :rating="
                                                    service.request
                                                        | AVG_FeedBack()
                                                "
                                                :active-color="
                                                    service.request
                                                        | FeedBackColor()
                                                "
                                            />
                                            <small
                                                >{{
                                                    service.request
                                                        | FeedBackCount()
                                                }}
                                                reviews</small
                                            >
                                        </td>
                                        <td v-show="$gate.isAdmin()">
                                            <a
                                                title="Feedback"
                                                href="#"
                                                @click="feedBackModal(service)"
                                            >
                                                <i
                                                    class="fa fa-comment-dots"
                                                ></i>
                                                <small
                                                    >{{
                                                        service.request
                                                            | FeedBackCount()
                                                    }}
                                                    Feedbacks</small
                                                >
                                            </a>
                                        </td>
                                        <td v-show="$gate.isAdmin()">
                                            <a
                                                title="Complains"
                                                href="#"
                                                @click="complainsModal(service)"
                                                class="orange"
                                            >
                                                <i
                                                    class="fas fa-comment-slash orange"
                                                ></i>
                                                <small
                                                    >{{
                                                        service.request
                                                            | ComplainsCount()
                                                    }}
                                                    Complains</small
                                                >
                                            </a>
                                        </td>
                                        <td>
                                            <a
                                                v-show="$gate.isAdmin()"
                                                href="#"
                                                @click="
                                                    deleteService(service.id)
                                                "
                                            >
                                                <i class="fa fa-trash red"></i>
                                            </a>
                                            <a
                                                v-show="$gate.isClient()"
                                                href="#"
                                                @click="requestService(service)"
                                            >
                                                <i
                                                    class="fas fa-cart-plus green"
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
                                :data="services"
                                @pagination-change-page="getResults"
                            ></pagination>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
        <complains-modal :service="serviceComplains" />
        <feed-back-modal :service="feedBackService" />
    </section>
</template>

<script>
export default {
    components: {
        StarRating  : () => import('vue-star-rating'),
        feedBackModal : () => import('./feedbackModal.vue'),
        complainsModal : () => import('./complainsModal.vue'),
    },
    data() {
        return {
            editmode: false,
            products: {},
            services: {},
            form: new Form({
                id: "",
                category: "",
                name: "",
                description: "",
                photo: "",
                category_id: "",
                price: "",
                photoUrl: "",
                experience: 0,
                service_id: "",
            }),
            categories: [],
            feedBackService: { product: { name: "" }, feedback: [],complains: [] },
            serviceComplains: { product: { name: "" },complains: [] },
        };
    },
    methods: {
        setFields(value) {
            let id = value.srcElement.value;
            let selectedProduct = this.products.data.filter(
                (elem) => elem.id == id
            )[0];
            console.log(selectedProduct);
            this.form.fill(selectedProduct);
        },
        getResults(page = 1) {
            this.$Progress.start();

            axios
                .get("api/service?page=" + page)
                .then(({ data }) => (this.services = data.data));

            this.$Progress.finish();
        },
        loadProducts() {
            axios
                .get("/api/product")
                .then(({ data }) => (this.products = data.data));
        },
        loadServices() {
            this.$Progress.start();
            axios
                .get("/api/service")
                .then(({ data }) => (this.services = data.data));
            this.$Progress.finish();
        },
        editModal(service) {
            this.editmode = true;
            this.form.reset();
            $("#addNew").modal("show");
            let selectedService = {
                ...service.product,
                experience: service.years,
                service_id: service.id,
            };
            this.form.fill(selectedService);
        },
        newModal() {
            this.editmode = false;
            this.form.reset();
            $("#addNew").modal("show");
        },
        feedBackModal(service) {
            let feedBacks = service.request
                .filter((elem) => elem.feedback[0])
                .map((elem) => elem.feedback[0]);
            this.feedBackService = { ...service, feedback: feedBacks };
            console.log(this.feedBackService);
            $("#feedBackModal").modal("show");
        },
        complainsModal(service) {
            let complains = service.request
                .filter((elem) => elem.complain[0])
                .map((elem) => elem.complain[0]);
            this.serviceComplains = { ...service, complains: complains };
            $("#complainsModal").modal("show");
        },
        createService() {
            this.$Progress.start();

            this.form
                .post("/api/service")
                .then((data) => {
                    if (data.data.success) {
                        $("#addNew").modal("hide");

                        Toast.fire({
                            icon: "success",
                            title: data.data.message,
                        });
                        this.$Progress.finish();
                        this.loadServices();
                    } else {
                        Toast.fire({
                            icon: "error",
                            title: "Some error occured! Please try again",
                        });

                        this.$Progress.failed();
                    }
                })
                .catch(() => {
                    Toast.fire({
                        icon: "error",
                        title: "Some error occured! Please try again",
                    });
                });
        },
        updateService() {
            this.$Progress.start();
            this.form
                .put(`/api/service/${this.form.service_id}`)
                .then((response) => {
                    // success
                    $("#addNew").modal("hide");
                    Toast.fire({
                        icon: "success",
                        title: response.data.message,
                    });
                    this.$Progress.finish();
                    //  Fire.$emit('AfterCreate');

                    this.loadServices();
                })
                .catch(() => {
                    this.$Progress.fail();
                });
        },
        deleteService(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                // Send request to the server
                if (result.value) {
                    this.form
                        .delete("/api/service/" + id)
                        .then(() => {
                            Swal.fire(
                                "Deleted!",
                                "Your file has been deleted.",
                                "success"
                            );
                            // Fire.$emit('AfterCreate');
                            this.loadServices();
                        })
                        .catch((data) => {
                            Swal.fire("Failed!", data.message, "warning");
                        });
                }
            });
        },
        requestService(service) {
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

        this.loadServices();
        this.loadProducts();

        this.$Progress.finish();
    },
    filters: {
        truncate: function (text, length, suffix) {
            return text.substring(0, length) + suffix;
        },
        AVG_FeedBack(service) {
            let feedBacks = service.filter((elem) => elem.feedback[0]);
            let rating =
                feedBacks
                    .map((elem) => elem.feedback[0].rating)
                    .reduce((a, b) => a + b, 0) / feedBacks.length;
            return rating;
        },
        FeedBackColor(serviceRequests) {
            let feedBacks = serviceRequests.filter((elem) => elem.feedback[0]);
            let rating =
                feedBacks
                    .map((elem) => elem.feedback[0].rating)
                    .reduce((a, b) => a + b, 0) / feedBacks.length;
            return rating > 3 ? "#02c39a" : "#ff3c38";
        },
        FeedBackCount(serviceRequests) {
            let feedBacks = serviceRequests.filter((elem) => elem.feedback[0]);
            return feedBacks.length;
        },
        ComplainsCount(serviceRequests) {
            let complains = serviceRequests.filter((elem) => elem.complain[0]);
            return complains.length;
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
