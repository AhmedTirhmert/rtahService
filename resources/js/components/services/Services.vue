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
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="service in services.data"
                                        :key="service.id"
                                    >
                                        <td>{{ service.user.name }}</td>
                                        <td v-show="$gate.isAdmin()">{{ service.user.email }}</td>
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
                                        <td>
                                            <a
                                                v-if="$gate.isAdmin()"
                                                href="#"
                                                @click="
                                                    deleteService(service.id)
                                                "
                                            >
                                                <i class="fa fa-trash red"></i>
                                            </a>
                                            <a
                                                v-else
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
    </section>
</template>

<script>
export default {
    components: {},
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
